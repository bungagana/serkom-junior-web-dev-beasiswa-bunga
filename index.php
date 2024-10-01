<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <title>Pilihan Beasiswa</title>
</head>

<body>
    <main id="main" class="main scroll">
        <?php include 'tabBar.php'; ?>

        <div class="tab-content" id="myTabContent">
            <!-- Tab Pilihan Beasiswa -->
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <section class="hero text-start">
    <div class="hero-content">
        <h1>Ambil Peluang Masa Depanmu</h1>
        <p>Beasiswa TUP adalah cara terbaik berkuliah.</p>
        <p>Dapatkan keuntungan mendaftar beasiswa di TUP</p>
        <div class="hero-buttons">
            <a href="#daftar" class="btn btn-primary rounded">Daftar</a>
            <a href="#syarat" class="btn btn-secondary rounded">Cek Syarat</a>
        </div>
    </div>
</section>


                <section class="section pilihan">
                    <div class="pagetitle">
                        <h1>Pilihan Beasiswa</h1>
                    </div>
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        <div class="col">
                            <div class="card h-100 rounded">
                                <img src="assets/img/istockphoto-1460535745-1024x1024.jpg" class="card-img-top" alt="Beasiswa Akademik" />
                                <div class="card-body">
                                    <h5 class="card-title">Beasiswa Akademik</h5>
                                    <p class="card-text">Bantuan keuangan untuk mahasiswa berprestasi akademis.</p>
                                    <a href="#syarat-akademik" class="btn btn-outline-dark" onclick="scrollToSection('syarat-akademik')">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 rounded">
                                <img src="assets/img/track-and-field-1867053_1280.jpg" class="card-img-top" alt="Beasiswa Non-Akademik" />
                                <div class="card-body">
                                    <h5 class="card-title">Beasiswa Non-Akademik</h5>
                                    <p class="card-text">Bantuan finansial untuk mahasiswa berprestasi di luar akademik.</p>
                                    <a href="#syarat-non-akademik" class="btn btn-outline-dark" onclick="scrollToSection('syarat-non-akademik')">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 rounded">
                                <img src="assets/img/kip.png" class="card-img-top" alt="Beasiswa KIP Kuliah" />
                                <div class="card-body">
                                    <h5 class="card-title">Beasiswa KIP Kuliah</h5>
                                    <p class="card-text">Bantuan biaya pendidikan untuk mahasiswa kurang mampu.</p>
                                    <a href="#syarat-kip" class="btn btn-outline-dark" onclick="scrollToSection('syarat-kip')">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 rounded">
                                <img src="assets/img/beasiswa_lain.jpg" class="card-img-top" alt="Beasiswa Lain" />
                                <div class="card-body">
                                    <h5 class="card-title">Beasiswa Lain</h5>
                                    <p class="card-text">Bantuan keuangan dari berbagai lembaga untuk pendidikan tinggi.</p>
                                    <a href="#syarat-lain" class="btn btn-outline-dark" onclick="scrollToSection('syarat-lain')">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Tab Daftar -->
            <div class="tab-pane fade" id="daftar" role="tabpanel" aria-labelledby="daftar-tab">
                <h2>Formulir Pendaftaran</h2>
                <p>Isi formulir di bawah ini untuk mendaftar beasiswa.</p>
                <!-- Tambahkan formulir pendaftaran di sini -->
            </div>

            <!-- Tab Hasil -->
            <div class="tab-pane fade" id="hasil" role="tabpanel" aria-labelledby="hasil-tab">
                <h2>Hasil Seleksi</h2>
                <p>Pengumuman hasil seleksi beasiswa akan ditampilkan di sini.</p>
            </div>
        </div>

        <section class="alur-pendaftaran">
            <div class="container">
                <h2 class="text-center">Alur Pendaftaran Beasiswa</h2>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card alur-card mb-4">
                            <div class="card-body text-center">
                                <span class="step">1</span>
                                <h5 class="card-title">Registrasi</h5>
                                <p class="card-text">Isi formulir registrasi online dan lihat ketentuan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card alur-card mb-4">
                            <div class="card-body text-center">
                                <span class="step">2</span>
                                <h5 class="card-title">Berkas</h5>
                                <p class="card-text">Kumpulkan berkas yang diperlukan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card alur-card mb-4">
                            <div class="card-body text-center">
                                <span class="step">3</span>
                                <h5 class="card-title">Seleksi</h5>
                                <p class="card-text">Ikuti proses seleksi yang ditentukan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card alur-card mb-4">
                            <div class="card-body text-center">
                                <span class="step">4</span>
                                <h5 class="card-title">Pengumuman</h5>
                                <p class="card-text">Pengumuman hasil seleksi beasiswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Syarat dan Ketentuan Umum -->
        <section id="syarat" class="section syarat-ketentuan">
            <div class="pagetitle">
                <h1>Syarat dan Ketentuan Umum</h1>
            </div>
            <div class="container">
                <ul>
                    <li>Mahasiswa aktif semester 1-8.</li>
                    <li>IPK minimal 3.0.</li>
                    <li>Terdaftar di program studi yang diakui.</li>
                    <li>Memiliki prestasi di bidang akademik atau non-akademik.</li>
                </ul>
            </div>
        </section>

        <!-- Section Syarat per Beasiswa -->
        <section class="section syarat-per-beasiswa">
            <div class="pagetitle">
                <h2>Syarat per Jenis Beasiswa</h2>
            </div>
            <div class="container">
                <div class="syarat-item" id="syarat-akademik">
                    <h5>Beasiswa Akademik</h5>
                    <p>Bantuan keuangan untuk mahasiswa berprestasi akademis.</p>
                    <ul>
                        <li>IPK minimal 3.5.</li>
                        <li>Aktif dalam organisasi kampus.</li>
                        <li>Melampirkan sertifikat prestasi akademik.</li>
                    </ul>
                </div>
                <div class="syarat-item" id="syarat-non-akademik">
                    <h5>Beasiswa Non-Akademik</h5>
                    <p>Bantuan finansial untuk mahasiswa berprestasi di luar akademik.</p>
                    <ul>
                        <li>Aktif di kegiatan sosial atau olahraga.</li>
                        <li>Melampirkan sertifikat prestasi non-akademik.</li>
                    </ul>
                </div>
                <div class="syarat-item" id="syarat-kip">
                    <h5>Beasiswa KIP Kuliah</h5>
                    <p>Bantuan biaya pendidikan untuk mahasiswa kurang mampu.</p>
                    <ul>
                        <li>Bukti tidak mampu (surat keterangan).</li>
                        <li>IPK minimal 2.5.</li>
                    </ul>
                </div>
                <div class="syarat-item" id="syarat-lain">
                    <h5>Beasiswa Lain</h5>
                    <p>Bantuan keuangan dari berbagai lembaga untuk pendidikan tinggi.</p>
                    <ul>
                        <li>Setiap lembaga memiliki syarat yang berbeda.</li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer">
        <div class="container">
            <div class="text-center">
                <p>© 2024 Beasiswa TUP. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>

</html>
