<?php
include_once 'connection.php';
include 'tabBar.php';

$stmt = $conn->query("SELECT * FROM tb_daftar");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Hasil Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <main class="main">
        <div class="container">
            <h1>Hasil Pendaftaran Beasiswa</h1>
            <table class="table">
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
                            <td><?php echo htmlspecialchars($row['status_ajuan']); ?></td> <!-- New field -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
