<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'beasiswa';
$port = 3308;

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8"; 

try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
