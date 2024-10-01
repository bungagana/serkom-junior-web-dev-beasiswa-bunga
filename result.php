<?php
include_once 'connection.php';
include 'tabBar.php';

// Fetch data for the table
$stmt = $conn->query("SELECT * FROM tb_daftar");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the charts
$status_counts = [];
$ipk_sum = [];
$semester_counts = [];
$beasiswa_counts = [];

// Initialize counters
foreach ($results as $row) {
    // Count based on verification status
    $status = $row['status_ajuan'];
    if (!isset($status_counts[$status])) {
        $status_counts[$status] = 0;
    }
    $status_counts[$status]++;

    // Sum IPK by semester
    $semester = $row['semester'];
    if (!isset($ipk_sum[$semester])) {
        $ipk_sum[$semester] = ['total' => 0, 'count' => 0];
    }
    $ipk_sum[$semester]['total'] += $row['ipk'];
    $ipk_sum[$semester]['count']++;

    // Count scholarships
    $beasiswa = $row['beasiswa'];
    if (!isset($beasiswa_counts[$beasiswa])) {
        $beasiswa_counts[$beasiswa] = 0;
    }
    $beasiswa_counts[$beasiswa]++;
}

// Prepare data for the charts
$status_labels = array_keys($status_counts);
$status_data = array_values($status_counts);

$semester_labels = range(1, 8);
$semester_ipk_data = [];
foreach ($semester_labels as $sem) {
    if (isset($ipk_sum[$sem])) {
        $average_ipk = $ipk_sum[$sem]['total'] / $ipk_sum[$sem]['count'];
        $semester_ipk_data[] = round($average_ipk, 2);
    } else {
        $semester_ipk_data[] = 0; // No data for this semester
    }
}

$beasiswa_labels = array_keys($beasiswa_counts);
$beasiswa_data = array_values($beasiswa_counts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Hasil Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/result.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
</head>
<body>
    <main class="main">
        <div class="container">
            <h1>Hasil Pendaftaran Beasiswa</h1>

            <div class="chart-container">
                <div>
                    <h3>Jumlah Pendaftar per Jenis Beasiswa</h3>
                    <canvas id="beasiswaChart"></canvas>
                </div>
                <div>
                    <h3>IPK Rata-rata per Semester</h3>
                    <canvas id="ipkChart"></canvas>
                </div>
                <div>
                    <h3>Status Verifikasi</h3>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Semester</th>
                        <th>IPK</th>
                        <th>Jenis Beasiswa</th>
                        <th>Berkas</th>
                        <th>Status Ajuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['nope']); ?></td>
                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td><?php echo htmlspecialchars($row['ipk']); ?></td>
                            <td><?php echo htmlspecialchars($row['beasiswa']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($row['berkas']); ?>" target="_blank">Lihat Berkas</a></td>
                            <td><?php echo htmlspecialchars($row['status_ajuan']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Status Verification Chart
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($status_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($status_data); ?>,
                    backgroundColor: ['#36A2EB', '#FF6384'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // IPK Average by Semester Chart
        const ctxIPK = document.getElementById('ipkChart').getContext('2d');
        const ipkChart = new Chart(ctxIPK, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($semester_labels); ?>,
                datasets: [{
                    label: 'IPK Rata-rata',
                    data: <?php echo json_encode($semester_ipk_data); ?>,
                    borderColor: '#FFCE56',
                    fill: false,
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

        // Scholarship Type Chart
        const ctxBeasiswa = document.getElementById('beasiswaChart').getContext('2d');
        const beasiswaChart = new Chart(ctxBeasiswa, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($beasiswa_labels); ?>,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: <?php echo json_encode($beasiswa_data); ?>,
                    backgroundColor: '#4BC0C0',
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
    </script>
</body>
</html>
