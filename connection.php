<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'beasiswa';
$port = 3308; // Specify your port here

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8"; // Include port in DSN

try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
