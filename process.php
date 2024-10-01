<?php
include_once 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" size="32x32" href="assets/img/logo.png" />

    <!-- judul halaman -->
    <title>Daftar Beasiswa</title>

    <!-- Vendor -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- header -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a href="index.php" class="logo d-flex align-items-center">
                    <img src="assets/img/logo header.png" alt />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Pilihan Beasiswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="daftar.php">Daftar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="hasil.php">Hasil</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- === Main Page ==== -->
    <main id="main" class="main">
        <section class="section daftar" id="daftar">
            <div class="pagetitle">
                <h1>Daftar Beasiswa</h1>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Registrasi Beasiswa</h5>

                            <!-- General Form Elements -->
                            <form action="koneksi.php" method="POST" enctype="multipart/form-data" id="formDaftar"
                                class="needs-validation" name="formDaftar" novalidate>
                                <div class="row mb-3">
                                    <label for="inputNama" class="col-sm-2 col-form-label form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="inputNama" name="inputNama" class="form-control"
                                            placeholder="Masukkan Nama" required />
                                        <div class="invalid-feedback"> Harap masukkan nama. </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail" class="col-sm-2 col-form-label form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" id="inputEmail" name="inputEmail" class="form-control"
                                            placeholder="Masukkan Email" required />
                                        <div class="invalid-feedback"> Harap masukkan email. </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label form-label">Nomor HP</label>
                                    <div class="col-sm-10">
                                        <input type="tel" id="inputNumber" name="inputNumber" class="form-control"
                                            placeholder="Masukkan Nomor HP" required />
                                        <div class="invalid-feedback"> Harap masukkan nomor handphone. </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="semester" class="col-sm-2 col-form-label form-label">Semester Saat
                                        Ini</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="semester" id="semester"
                                            aria-label="Pilih Semester" onchange="generateIPK()" required>
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

                                <div class="row mb-3">
                                    <label for="randomIPK" class="col-sm-2 col-form-label form-label">IPK
                                        Terakhir</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" class="form-control" name="randomIPK" />
                                        <input type="text" class="form-control" id="randomIPK" placeholder="0.00"
                                            disabled readonly></input>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="jenisBeasiswa" class="col-sm-2 col-form-label form-label">Pilihan
                                        Beasiswa</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" id="jenisBeasiswa" name="jenisBeasiswa"
                                            aria-label="Pilih Jenis Beasiswa" required>
                                            <option selected disabled value="">Pilih Jenis Beasiswa</option>
                                            <option value="Akademik">Akademik</option>
                                            <option value="Non-Akademik">Non-Akademik</option>
                                            <option value="KIP Kuliah">KIP Kuliah</option>
                                        </select>
                                        <div class="invalid-feedback"> Harap pilih jenis beasiswa. </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputFile" class="col-sm-2 col-form-label form-label">File
                                        Upload</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" id="inputFile" name="inputFile"
                                            accept=".pdf" required />
                                        <div class="invalid-feedback"> Harap input file hanya berupa pdf. </div>
                                    </div>
                                </div>

                                <div class="row text-end">
                                    <div class="col">
                                        <button type="submit" name="submit" id="submitForm"
                                            class="btn btn-primary">Daftar</button>
                                        <button type="reset" name="reset" id="resetForm" onclick="cancel()"
                                            class="btn btn-secondary">Batal</button>
                                    </div>
                                </div>
                            </form>
                            <!-- End General Form Elements -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section syarat beasiswa -->
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Raihan Ahmad Fahrezi 20102313</span></strong>. Sertifikasi Kompetensi Junior
            Web Developer
        </div>
    </footer>
    <!-- End Footer -->

    <!-- button back to top -->
    <div class="back-to-top d-flex align-items-center justify-content-center" id="backToTopBtn">
        <a href="#header"><ion-icon name="arrow-up-outline"></ion-icon></a>
    </div>

    <!-- Install ION ICON -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Vendor JS File -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Main Js File -->
    <script src="assets/js/script.js"></script>
    <script type="text/javascript">
    </script>
</body>

</html>