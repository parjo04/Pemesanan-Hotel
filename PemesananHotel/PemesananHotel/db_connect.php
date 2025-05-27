<?php
// Koneksi ke database 'pemesananhotel'
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'pemesananhotel';

// Buat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset ke UTF-8 (opsional tapi penting untuk dukungan karakter internasional)
$conn->set_charset("utf8");
?>
