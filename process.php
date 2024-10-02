<?php 
// Mengimpor koneksi ke database dan tab bar
include_once 'connection.php';
include 'tabBar.php'; 

// Menghasilkan nilai IPK acak antara 2.50 dan 4.00
function generateRandomIPK() {
    return round(mt_rand(250, 400) / 100, 2); // Membagi dengan 100 untuk mendapatkan dua angka desimal
}

// Set IPK awal
$ipk = '';

// Mengecek apakah metode request adalah POST dan tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Mengambil data dari form
    $nama = $_POST['inputNama']; // Nama pengguna
    $email = $_POST['inputEmail']; // Email pengguna
    $nope = $_POST['inputNumber']; // Nomor HP pengguna
    $semester = $_POST['semester']; // Semester saat ini
    $ipk = $_POST['randomIPK']; // IPK terakhir (disembunyikan dari input)
    $beasiswa = $_POST['jenisBeasiswa']; // Jenis beasiswa yang dipilih
    $status_ajuan = 'Belum di Verifikasi'; // Status pendaftaran awal

    // Menangani upload file
    if (isset($_FILES['inputFile']) && $_FILES['inputFile']['error'] == 0) {
        $file_tmp = $_FILES['inputFile']['tmp_name']; // Path file sementara
        $file_name = basename($_FILES['inputFile']['name']); // Nama file yang di-upload
        $upload_dir = 'uploads/'; // Direktori untuk menyimpan file (pastikan bisa ditulis)
        $file_path = $upload_dir . $file_name; // Path lengkap file yang di-upload

        // Memindahkan file yang di-upload ke direktori yang dituju
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Menyiapkan query SQL untuk memasukkan data ke database
            $stmt = $conn->prepare("INSERT INTO tb_daftar (nama, email, nope, semester, ipk, beasiswa, berkas, status_ajuan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            // Menjalankan query dengan parameter
            $stmt->execute([$nama, $email, $nope, $semester, $ipk, $beasiswa, $file_path, $status_ajuan]);

            // Menampilkan pesan sukses dan mengarahkan ke halaman hasil
            echo "<script>alert('Registrasi berhasil!'); window.location.href='result.php';</script>";
            exit; // Menghentikan eksekusi script
        } else {
            // Gagal upload file
            echo "<script>alert('Gagal mengupload file.');</script>";
        }
    } else {
        // Tidak ada file yang di-upload
        echo "<script>alert('Silakan pilih file untuk diupload.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" size="32x32" href="assets/img/logo.png" />
    <title>Daftar Beasiswa</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/daftar.css" />
    <link rel="stylesheet" href="assets/css/tab.css" />
</head>

<body>

    <main id="main" class="main">
        <section class="section daftar" id="daftar">
            <div class="pagetitle">
                <h1>Registrasi Beasiswa</h1>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form action="daftar.php" method="POST" enctype="multipart/form-data" id="formDaftar" class="needs-validation" name="formDaftar" novalidate>
                                
                                <!-- Input Nama -->
                                <div class="row mb-3">
                                    <label for="inputNama" class="col-sm-2 col-form-label form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="inputNama" name="inputNama" class="form-control" placeholder="Masukkan Nama" required />
                                        <div class="invalid-feedback"> Harap masukkan nama. </div>
                                    </div>
                                </div>

                                <!-- Input Email -->
                                <div class="row mb-3">
                                    <label for="inputEmail" class="col-sm-2 col-form-label form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Masukkan Email" required />
                                        <div class="invalid-feedback"> Harap masukkan email. </div>
                                    </div>
                                </div>

                                <!-- Input Nomor HP -->
                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label form-label">Nomor HP</label>
                                    <div class="col-sm-10">
                                        <input type="tel" id="inputNumber" name="inputNumber" class="form-control" placeholder="Masukkan Nomor HP" required />
                                        <div class="invalid-feedback"> Harap masukkan nomor handphone. </div>
                                    </div>
                                </div>

                                <!-- Pilihan Semester -->
                                <div class="row mb-3">
                                    <label for="semester" class="col-sm-2 col-form-label form-label">Semester Saat Ini</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="semester" id="semester" aria-label="Pilih Semester" required onchange="generateIPK()">
                                            <option selected disabled value="">Pilih Semester</option>
                                            <option value="1">Semester 1</option>
                                            <option value="2">Semester 2</option>
                                            <option value="3">Semester 3</option>
                                            <option value="4">Semester 4</option>
                                            <option value="5">Semester 5</option>
                                            <option value="6">Semester 6</option>
                                            <option value="7">Semester 7</option>
                                            <option value="8">Semester 8</option>
                                        </select>
                                        <div class="invalid-feedback"> Harap pilih semester. </div>
                                    </div>
                                </div>

                                <!-- Input IPK -->
                                <div class="row mb-3">
                                    <label for="randomIPK" class="col-sm-2 col-form-label form-label">IPK Terakhir</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" class="form-control" name="randomIPK" id="randomIPKInput" />
                                        <input type="text" class="form-control" id="randomIPK" disabled readonly>
                                    </div>
                                </div>

                                <!-- Pilihan Beasiswa -->
                                <div class="row mb-3">
                                    <label for="jenisBeasiswa" class="col-sm-2 col-form-label form-label">Pilihan Beasiswa</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" id="jenisBeasiswa" name="jenisBeasiswa" aria-label="Pilih Jenis Beasiswa" required disabled>
                                            <option selected disabled value="">Pilih Jenis Beasiswa</option>
                                            <option value="Akademik">Akademik</option>
                                            <option value="Non-Akademik">Non-Akademik</option>
                                            <option value="Tahfids">Tahfids</option>
                                            <option value="Internasional">Internasional</option>
                                        </select>
                                        <div class="invalid-feedback"> Harap pilih jenis beasiswa. </div>
                                    </div>
                                </div>

                                <!-- Upload File -->
                                <div class="row mb-3">
                                    <label for="inputFile" class="col-sm-2 col-form-label form-label">File Upload</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" id="inputFile" name="inputFile" accept=".pdf" required disabled />
                                        <div class="invalid-feedback"> Harap input file hanya berupa pdf. </div>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="row text-end">
                                    <div class="col">
                                        <button type="reset" name="reset" id="resetForm" onclick="cancel()" class="btn btn-link text-secondary" style="text-decoration: none;">Batal</button>
                                        <button type="submit" name="submit" id="submitForm" class="btn btn-primary" disabled>Daftar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function generateIPK() {
            var input = document.getElementById("randomIPK");
            var hiddenInput = document.getElementById("randomIPKInput");
            var jenisBeasiswa = document.getElementById("jenisBeasiswa");
            var inputFile = document.getElementById("inputFile");
            var submitForm = document.getElementById("submitForm");

            // Generate a random IPK
            var randomIPK = (Math.random() * (4.00 - 2.50) + 2.50).toFixed(2);
            input.value = randomIPK;
            hiddenInput.value = randomIPK;

            // Tampilkan container IPK
            input.disabled = true; // Pastikan field IPK tidak dapat diedit

            // Enable or disable fields based on the IPK value
            if (parseFloat(randomIPK) < 3.0) {
                jenisBeasiswa.disabled = true;
                inputFile.disabled = true;
                submitForm.disabled = true;
                alert('IPK Anda di bawah 3.0, Anda tidak dapat melanjutkan pendaftaran.');
            } else {
                jenisBeasiswa.disabled = false;
                inputFile.disabled = false;
                submitForm.disabled = false;
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
