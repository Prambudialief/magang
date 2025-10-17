<?php
// ../service/connection.php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'root'; // ubah kalau pakai password
$DB_NAME = 'magang'; // ubah sesuai nama database

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

$main_url = 'http://localhost/magang/auth/login.php'
?>
