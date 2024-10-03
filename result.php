<?php
/**
 * Filename: result.php
 * Description: Menampilkan hasil pendaftaran beasiswa, termasuk grafik dan tabel 
 * yang menunjukkan statistik pendaftar.
 * Author: Bunga
 * Version: 1.0
 * Date:  2-10-2024
 */

// Include necessary files
include_once 'connection.php';
include 'tabBar.php';

/**
 * Mengambil data pendaftaran dari database.
 * @param PDO $conn Koneksi ke database.
 * @return array Data pendaftaran.
 */
function getPendaftaranData($conn) {
    $stmt = $conn->query("SELECT * FROM data_pendaftaran");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

     // Debugging: Lihat data yang diambil
    //  var_dump($data); 
}

/**
 * Menghitung jumlah pendaftar berdasarkan status.
 * @param array $results Daftar pendaftar.
 * @return array Jumlah pendaftar per status.
 */
function calculateStatusCounts($results) {
    $status_counts = [];
    foreach ($results as $row) {
        $status = $row['status_ajuan'];
        if (!isset($status_counts[$status])) {
            $status_counts[$status] = 0;
        }
        $status_counts[$status]++;
    }
      // Debugging: Lihat isi $status_counts
    //   var_dump($status_counts);
    // Mengurutkan berdasarkan jumlah pendaftar
    arsort($status_counts);
    return $status_counts;
}

/**
 * Menghitung rata-rata IPK per semester.
 * @param array $results Daftar pendaftar.
 * @return array Rata-rata IPK per semester.
 */
function calculateAverageIPK($results) {
    $ipk_sum = [];
    foreach ($results as $row) {
        $semester = $row['semester'];
        if (!isset($ipk_sum[$semester])) {
            $ipk_sum[$semester] = ['total' => 0, 'count' => 0]; 
        }
        $ipk_sum[$semester]['total'] += $row['ipk'];
        $ipk_sum[$semester]['count']++;
    }
    // Debugging: Lihat total dan count per semester
    // var_dump($ipk_sum);

    $semester_ipk_data = [];
    for ($sem = 1; $sem <= 8; $sem++) {
        if (isset($ipk_sum[$sem]) && $ipk_sum[$sem]['count'] > 0) {
            $average_ipk = $ipk_sum[$sem]['total'] / $ipk_sum[$sem]['count'];
            $semester_ipk_data[] = round($average_ipk, 2);
        } else {
            $semester_ipk_data[] = 0; // Jika tidak ada data
        }
    }
    

    return $semester_ipk_data;
}

/**
 * Menghitung jumlah pendaftar berdasarkan jenis beasiswa.
 * @param array $results Daftar pendaftar.
 * @return array Jumlah pendaftar per jenis beasiswa.
 */
function calculateBeasiswaCounts($results) {
    $beasiswa_counts = [];
    foreach ($results as $row) {
        $beasiswa = $row['beasiswa'];
        if (!isset($beasiswa_counts[$beasiswa])) {
            $beasiswa_counts[$beasiswa] = 0;
        }
        $beasiswa_counts[$beasiswa]++;
    }
    // Mengurutkan berdasarkan jumlah pendaftar
    arsort($beasiswa_counts);
    return $beasiswa_counts;
}

// Ambil data pendaftaran
$results = getPendaftaranData($conn);

// Mempersiapkan data untuk grafik
$status_counts = calculateStatusCounts($results);
$semester_ipk_data = calculateAverageIPK($results);
$beasiswa_counts = calculateBeasiswaCounts($results);

// Menyiapkan data untuk grafik
$status_labels = array_keys($status_counts);
$status_data = array_values($status_counts);
$beasiswa_labels = array_keys($beasiswa_counts);
$beasiswa_data = array_values($beasiswa_counts);

// HTML dan grafik
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
                <input type="text" id="tableSearch" placeholder="Cari..." aria-label="Search">
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
                    backgroundColor: ['#36A2EB', '#FF6384'],
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
                labels: <?php echo json_encode(range(1, 8)); ?>,
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
                        beginAtZero: true
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
                        beginAtZero: true
                    }
                }
            }
        });

        // Fitur search Tabel
        document.getElementById('tableSearch').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('.table tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
                row.style.display = match ? '' : 'none'; 
            });
        });
    </script>
</body>
</html>
