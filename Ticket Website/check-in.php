<?php
require_once('Connections/pesantiket.php');

if (!isset($_SESSION)) {
  session_start();
}

$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  
  $logoutGoTo = "index.html";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

$message = '';
$tiket_terpakai = [];
$totalRows_tiket_terpakai = 0;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Gunakan mysqli_real_escape_string() untuk membersihkan input
    $id = mysqli_real_escape_string($pesantiket, $id);

    // Membuat query dengan parameter yang aman
    $query = sprintf("SELECT * FROM pesantiket WHERE ID = '%s'", $id);
    
    // Menjalankan query menggunakan mysqli_query
    $result = mysqli_query($pesantiket, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            if ($row['Status'] === 'Tiket Sudah Terpakai') {
                $tiket_terpakai[] = $row;
                $totalRows_tiket_terpakai = 1;
            } else {
                $totalRows_tiket_terpakai = 0;
            }
        } else {
            $totalRows_tiket_terpakai = 0;
        }
    } else {
        $message = "Terjadi kesalahan dalam query.";
    }

    if ($totalRows_tiket_terpakai == 0) {
        $message = "Tiket tidak ditemukan<br>Pemilik belum melakukan konfirmasi atau pembayaran.";
    }

    // Menggunakan mysqli_free_result untuk membebaskan resource
    if (isset($result) && is_resource($result)) {
        mysqli_free_result($result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Check-In Tiket</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body, html {
  height: 100%;
  font-family: "Montserrat", sans-serif;
  background-color:#f0f0f0;
}

.container {
  display: flex;
  height: 100vh;
}

.header {
  background-color: #000;
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  width: 220px;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.header-content {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  background-color: #042CE3;
  width: 100%;
  padding: 10px;
  box-sizing: border-box;
}

.header img {
  margin-right: 10px;
}

.header-title {
  font-size: 16px;
  font-weight: bold;
  color: #fff;
}

.header a {
  display: block;
  text-decoration: none;
  font-weight: bold;
  color: #fff;
  margin: 20px 15px;
  padding: 10px;
  border-radius: 5px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.header a:hover {
  background-color: #042CE3;
}

.logout {
  position: absolute;
  bottom: 0;
}

.main-content {
  flex: 1;
  background-color:#FFFFFF;
	border-radius:5px;
	 margin:8px;
	 overflow-y: auto;
}

.message {
  text-align: center;
  font-weight: bold;
  margin-top: 200px;
  color: #333;
}

p {
  text-align: center;
  font-size: 24px;
  font-weight: bold;
  margin: 10px 0;
  color: #333;
}

.search-form {
  margin-bottom: 20px;
  text-align: center;
}

.search-form input[type="text"] {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 400px;
  font-size: 14px;
}

.search-form input[type="submit"] {
  padding: 9px 15px;
  border: none;
  border-radius: 4px;
  background-color: #042CE3;
  color: white;
  font-size: 14px;
  font-weight: bold;
  cursor: pointer;
}

.search-form input[type="submit"]:hover {
  background-color: #0056b3;
}

.title {
  font-size: 30px;
  font-weight: bold;
  margin: 50px 0;
}

.data {
  max-width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: -200px;
  padding: 20px;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  border: 1px solid #ddd;
}

.data-table thead {
  background-color: #042CE3;
}

.data-table th {
  padding: 12px;
  font-size: 13px;
  text-align: left;
  font-weight: bold;
  color: #FFFFFF;
  border-bottom: 1px solid #ddd;
}

.data-table td {
  padding: 8px;
  font-size: 13px;
  border-bottom: 1px solid #ddd;
}

.data-table tbody tr:hover {
  background-color: #f9f9f9;
  cursor: pointer;
}

.data-table a {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

.data-table a:hover {
  text-decoration: underline;
}
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <div class="header-content">
      <img src="bahan/account-security_11135274.png" width="40" height="auto" />
      <span class="header-title">ADMINISTRATOR</span>
    </div>
    <a href="home_admin.php" class="style3">Daftar Pemesan</a>
    <a href="check-in.php" class="style3">Check In</a>
    <a href="laporan.php" class="style3">Laporan</a>
    <a href="<?php echo $logoutAction ?>" class="logout">Log Out</a>
  </div>

  <div class="main-content">
    <p class="title">CHECK IN</p>
    <form id="form1" name="form1" method="get" action="check-in.php" class="search-form">
      <input type="text" name="id" id="ID" required placeholder="Masukkan ID Tiket"/>
      <input type="submit" name="button" id="button" value="CARI" />
    </form>

    <div class="message">
      <?php if (!empty($message)) echo "<p>$message</p>"; ?>
    </div>

    <?php if (isset($totalRows_tiket_terpakai) && $totalRows_tiket_terpakai > 0): ?>
    <div class="data">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Nama</th>
            <th>No_Telepon</th>
            <th>Harga</th>
            <th>Tanggal_Pemesanan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tiket_terpakai as $tiket): ?>
            <tr>
              <td><?php echo htmlspecialchars($tiket['ID']); ?></td>
              <td><?php echo htmlspecialchars($tiket['Status']); ?></td>
              <td><?php echo htmlspecialchars($tiket['Nama']); ?></td>
              <td><?php echo htmlspecialchars($tiket['No_Telepon']); ?></td>
              <td><?php echo htmlspecialchars($tiket['Harga']); ?></td>
              <td><?php echo htmlspecialchars($tiket['Tanggal_Pemesanan']); ?></td>
              <td>Sudah Check-In</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
