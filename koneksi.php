<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_tugas_abang";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Waduh, koneksi putus Mang: " . mysqli_connect_error());
}
?>