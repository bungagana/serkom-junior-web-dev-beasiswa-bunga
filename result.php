<?php
include_once 'connection.php'; // Menghubungkan ke database
include 'tabBar.php'; // Menyertakan navigasi/tab bar

// Mengambil data dari tabel tb_daftar
$stmt = $conn->query("SELECT * FROM tb_daftar");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mempersiapkan data untuk grafik
$status_counts = []; // Menyimpan jumlah pendaftar berdasarkan status
$ipk_sum = []; // Menyimpan total dan jumlah IPK per semester
$beasiswa_counts = []; // Menyimpan jumlah pendaftar berdasarkan jenis beasiswa

// Menghitung jumlah dan total IPK
foreach ($results as $row) {
    // Menghitung berdasarkan status verifikasi
    $status = $row['status_ajuan'];
    if (!isset($status_counts[$status])) {
        $status_counts[$status] = 0; // Inisialisasi jika status belum ada
    }
    $status_counts[$status]++;

    // Menghitung rata-rata IPK per semester
    $semester = $row['semester'];
    if (!isset($ipk_sum[$semester])) {
        $ipk_sum[$semester] = ['total' => 0, 'count' => 0]; // Inisialisasi
    }
    $ipk_sum[$semester]['total'] += $row['ipk'];
    $ipk_sum[$semester]['count']++;

    // Menghitung jumlah pendaftar per jenis beasiswa
    $beasiswa = $row['beasiswa'];
    if (!isset($beasiswa_counts[$beasiswa])) {
        $beasiswa_counts[$beasiswa] = 0; // Inisialisasi jika beasiswa belum ada
    }
    $beasiswa_counts[$beasiswa]++;
}

// Mempersiapkan data untuk grafik
$status_labels = array_keys($status_counts); // Label status
$status_data = array_values($status_counts); // Data jumlah per status

$semester_labels = range(1, 8); // Label semester
$semester_ipk_data = [];
foreach ($semester_labels as $sem) {
    if (isset($ipk_sum[$sem])) {
        $average_ipk = $ipk_sum[$sem]['total'] / $ipk_sum[$sem]['count']; // Menghitung rata-rata IPK
        $semester_ipk_data[] = round($average_ipk, 2);
    } else {
        $semester_ipk_data[] = 0; // Jika tidak ada data
    }
}

$beasiswa_labels = array_keys($beasiswa_counts); // Label beasiswa
$beasiswa_data = array_values($beasiswa_counts); // Data jumlah per beasiswa
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Hasil Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/result.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/css/tab.css" />
</head>
<body>
    <main class="main">
        <div class="container">
            <h1>Hasil Pendaftaran Beasiswa</h1>

            <div class="chart-container">
                <div>
                    <h4 style="font-size: 1rem;">Jumlah Pendaftar per Jenis Beasiswa</h4>
                    <canvas id="beasiswaChart"></canvas>
                </div>
                <div>
                    <h4 style="font-size: 1rem;">IPK Rata-rata per Semester</h4>
                    <canvas id="ipkChart"></canvas>
                </div>
                <div>
                    <h4 style="font-size: 1rem;">Status Verifikasi</h4>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <div class="search-container">
                <input type="text" id="tableSearch" placeholder="Cari..." aria-label="Search"> <!-- Input pencarian -->
            </div>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Semester</th>
                        <th>IPK</th>
                        <th>Jenis Beasiswa</th>
                        <th>Status Ajuan</th>
                        <th>Berkas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['nope']); ?></td>
                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td><?php echo htmlspecialchars($row['ipk']); ?></td>
                            <td><?php echo htmlspecialchars($row['beasiswa']); ?></td>
                            <td><?php echo htmlspecialchars($row['status_ajuan']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($row['berkas']); ?>" target="_blank">Lihat Berkas</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Grafik Status Verifikasi
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($status_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($status_data); ?>,
                    backgroundColor: ['#36A2EB', '#FF6384'], // Warna untuk pie chart
                    borderWidth: 1,
                    hoverOffset: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });

        // Grafik Rata-rata IPK per Semester
        const ctxIPK = document.getElementById('ipkChart').getContext('2d');
        const ipkChart = new Chart(ctxIPK, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($semester_labels); ?>,
                datasets: [{
                    label: 'IPK Rata-rata',
                    data: <?php echo json_encode($semester_ipk_data); ?>,
                    borderColor: '#FFCE56',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true // Mulai sumbu Y dari 0
                    }
                }
            }
        });

        // Grafik Jenis Beasiswa
        const ctxBeasiswa = document.getElementById('beasiswaChart').getContext('2d');
        const beasiswaChart = new Chart(ctxBeasiswa, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($beasiswa_labels); ?>,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: <?php echo json_encode($beasiswa_data); ?>,
                    backgroundColor: '#4BC0C0',
                    borderColor: '#36A2EB',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true // Mulai sumbu Y dari 0
                    }
                }
            }
        });

        // Fitur Pencarian Tabel
        document.getElementById('tableSearch').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('.table tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
                row.style.display = match ? '' : 'none'; // Menampilkan atau menyembunyikan baris
            });
        });
    </script>
</body>
</html>
