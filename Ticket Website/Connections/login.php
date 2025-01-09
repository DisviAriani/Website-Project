<?php
$hostname_login = "localhost";
$database_login = "ticket"; // Pastikan nama database sudah benar
$username_login = "root";
$password_login = ""; // Jika menggunakan password kosong, biarkan kosong

// Membuat koneksi ke database
$login = mysqli_connect($hostname_login, $username_login, $password_login, $database_login);

// Cek koneksi
if (!$login) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
