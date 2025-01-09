<?php 
require_once('Connections/pesantiket.php'); 
session_start(); 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cek Tiket Saya</title>
<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body, html {
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  font-family: "Montserrat", sans-serif;
  background: url(bahan/cari-background.jpg) no-repeat center center fixed;
  background-size: cover;
}

.header {
  background-color: #000;
  padding: 7px 0;
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  position: absolute;
  width: 100%;
  top: 0;
  left: 0;
}

.header table {
  width: 100%;
  max-width: 1318px;
  margin: 0 auto;
}

.header img {
  vertical-align: middle;
}

.header a {
  text-decoration: none;
  font-weight: bold;
  color: #fff;
}

.header a:hover {
  color: #ccc;
}

.style3 {
  font-size: 14px;
}

.container {
  text-align: center;
  background: rgba(0, 0, 0, 0.8);
  padding: 50px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 36px;
  margin-bottom: 10px;
  color: #fff;
}

p {
  font-size: 16px;
  margin-bottom: 20px;
  color: #fff;
}

form {
  display: flex;
  align-items: center;
  justify-content: center;
}

input[type="text"] {
  padding: 10px;
  margin-right: 10px;
  flex: 1;
  max-width: 600px;
  font-family: "Montserrat", sans-serif;
  border: 1px solid #ddd;
  border-radius: 4px;
}

input[type="submit"] {
  padding: 10px 20px;
  font-size: 16px;
  font-weight: bold;
  color: #fff;
  background-color: #042CE3;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  font-family: "Montserrat", sans-serif;
}

input[type="submit"]:hover {
  background-color: #999999;
}

#error-message {
  color: #ff0000;
  font-size: 18px;
  margin-top: 20px;
}
</style>
</head>
<body>
<div class="header">
    <table height="50" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="121"><div align="center"><img src="bahan/t.png" width="65" height="auto" /></div></td>
            <td width="95"><div align="left"><a href="index.html" class="style3">Home</a></div></td>
            <td width="134"><div align="left"><a href="pesan_tiket.php" class="style3">Pesan Tiket</a></div></td>
            <td width="611"><div align="left"><a href="cari_tiket.php" class="style3">Cek Tiket Saya</a></div></td>
            <td width="100"><a href="login.php" class="style3">Login Admin</a></td>
            <td width="20"></td>
        </tr>
    </table>
</div>

<div class="container">
  <h1 align="left">Cek Tiket</h1>
  <p align="left">Silakan masukkan Nomor Telepon yang anda gunakan pada form pemesanan tiket.</p>
  <form id="form1" name="form1" method="get" action="tiket.php">
    <input type="text" name="no_telepon" id="No_Telepon" placeholder="Masukkan Nomor Telepon" />
    <input type="submit" name="button" id="button" value="CARI" />
  </form>
  <?php
  if (isset($_SESSION['not_found']) && $_SESSION['not_found']) {
      echo '<p id="error-message">ID TIDAK DITEMUKAN</p>';
      unset($_SESSION['not_found']);
  }
  ?>
</div>

</body>
</html>
