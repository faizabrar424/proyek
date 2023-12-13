<?php
// Konfigurasi koneksi ke database MySQL
$servername = "dbiot.cwm006uvfjrp.us-east-1.rds.amazonaws.com"; // Ganti dengan nama server database Anda
$username = "wahyu8798"; // Ganti dengan username database Anda
$password = "katak8798"; // Ganti dengan password database Anda
$dbname = "dbiot"; // Ganti dengan nama database Anda

// Buat koneksi
$koneksi = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
