<?php 
/**
 * Filename: process.php
 * Description: Memproses pendaftaran beasiswa dengan menerima input dari formulir, 
 * meng-upload file, dan menyimpan data ke database.
 * Author: Bunga
 * Version: 1.0
 * Date:  2-10-2024
 *
 * Variabel:
 * - $ipk: Menyimpan nilai IPK yang di-inputkan.
 * - $nama: Menyimpan nama lengkap yang di-inputkan.
 * - $email: Menyimpan email yang di-inputkan.
 * - $nope: Menyimpan nomor telepon yang di-inputkan.
 * - $semester: Menyimpan semester saat ini yang di-inputkan.
 * - $beasiswa: Menyimpan jenis beasiswa yang dipilih.
 * - $status_ajuan: Menyimpan status pendaftaran (default: 'Belum di Verifikasi').
 * - $file_tmp: Menyimpan path file sementara yang di-upload.
 * - $file_name: Menyimpan nama file yang di-upload.
 * - $upload_dir: Menyimpan direktori untuk menyimpan file yang di-upload.
 * - $file_path: Menyimpan path lengkap file yang di-upload.
 *
 * Fungsi:
 * - Ada di proccess.js
 */


 include_once 'connection.php'; 
 include 'tabBar.php'; 
 
 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
     // Ambil dan sanitasi input
     $nama = htmlspecialchars(trim($_POST['inputNama']));
     $email = htmlspecialchars(trim($_POST['inputEmail']));
     $nope = htmlspecialchars(trim($_POST['inputNumber'])); 
     $semester = htmlspecialchars(trim($_POST['semester'])); 
     $ipk = htmlspecialchars(trim($_POST['randomIPK']));
     $beasiswa = htmlspecialchars(trim($_POST['jenisBeasiswa'])); 
     $status_ajuan = 'Belum di Verifikasi'; 
 
     // Validasi input
     $errors = [];
 
     // Validasi nama
     if (empty($nama)) {
         $errors[] = 'Nama tidak boleh kosong.';
     }
 
     // Validasi email
     if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $errors[] = 'Email tidak valid.';
     }
 
     // Validasi nomor telepon
     if (empty($nope) || !preg_match('/^\d{10,13}$/', $nope)) {
         $errors[] = 'Nomor telepon tidak valid. Harus antara 10-13 digit.';
     }
 
     // Validasi semester
     if (empty($semester)) {
         $errors[] = 'Semester harus dipilih.';
     }
 
     // Validasi IPK
     if (empty($ipk) || $ipk < 0 || $ipk > 4) {
         $errors[] = 'IPK harus antara 0 dan 4.';
     }
 
     // Validasi file upload
     if (isset($_FILES['inputFile']) && $_FILES['inputFile']['error'] == 0) {
         $file_tmp = $_FILES['inputFile']['tmp_name'];
         $file_name = basename($_FILES['inputFile']['name']);
         $upload_dir = 'uploads/';
         $file_path = $upload_dir . $file_name;
         $allowed_types = ['application/pdf'];
 
         // Validasi tipe file
         if (!in_array($_FILES['inputFile']['type'], $allowed_types)) {
             $errors[] = 'Hanya file PDF yang diizinkan.';
         }
 
         // Validasi ukuran file
         if ($_FILES['inputFile']['size'] > 2 * 1024 * 1024) { // 2 MB
             $errors[] = 'Ukuran file terlalu besar. Maksimal 2 MB.';
         }
 
         // Jika tidak ada error, do upload
         if (empty($errors) && move_uploaded_file($file_tmp, $file_path)) {
             $stmt = $conn->prepare("INSERT INTO data_pendaftaran (nama, email, nope, semester, ipk, beasiswa, berkas, status_ajuan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
             $stmt->execute([$nama, $email, $nope, $semester, $ipk, $beasiswa, $file_path, $status_ajuan]);
             echo "<script>alert('Registrasi berhasil!'); window.location.href='result.php';</script>";
             exit;
         } else {
             $errors[] = 'Gagal mengupload file.';
         }
     } else {
         $errors[] = 'Silakan pilih file untuk diupload.';
     }
 
     // Jika ada error, show alert
     if (!empty($errors)) {
         foreach ($errors as $error) {
             echo "<script>alert('$error');</script>";
         }
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
    <link rel="stylesheet" href="assets/css/process.css" />
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
                            <form action="process.php" method="POST" enctype="multipart/form-data" id="formDaftar" class="needs-validation" novalidate>
                                
                                <!-- Input Nama -->
                                <div class="row mb-3">
                                    <label for="inputNama" class="col-sm-2 col-form-label form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="inputNama" name="inputNama" class="form-control" placeholder="Masukkan Nama" required />
                                        <div class="invalid-feedback"> Masukkan Nama Anda. </div>
                                    </div>
                                </div>

                              <!-- Input Email -->
                               <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-label form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Masukkan Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Masukkan format email yang valid." />
                                    <div class="invalid-feedback"> Masukan Email Anda yang valid. </div>
                                </div>
                               </div>

                                <!-- Input Nomor HP -->
                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label form-label">Nomor HP</label>
                                    <div class="col-sm-10">
                                        <input type="tel" id="inputNumber" name="inputNumber" class="form-control" placeholder="Masukkan Nomor HP" required maxlength="13" pattern="\d{1,13}" title="Hanya angka, maksimal 13 digit." />
                                        <div class="invalid-feedback"> Masukkan Nomor Handphone yang valid. </div>
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
                                        <input type="text" class="form-control" id="randomIPK" disabled readonly required>
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
                                        <button type="reset" name="reset" id="resetForm" class="btn btn-link text-secondary" style="text-decoration: none;">Batal</button>
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
     <!-- Footer -->
     <?php include 'footer.php'; ?>

    <!-- === JS ==== -->
    <script src="assets/js/process.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
