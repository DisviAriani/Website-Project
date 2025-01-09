<?php
$hostname_pesantiket = "localhost";
$database_pesantiket = "ticket";  // Nama database
$username_pesantiket = "root";
$password_pesantiket = "";

// Membuat koneksi dan memilih database dalam satu langkah
$pesantiket = mysqli_connect($hostname_pesantiket, $username_pesantiket, $password_pesantiket, $database_pesantiket);

// Cek koneksi
if (!$pesantiket) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
