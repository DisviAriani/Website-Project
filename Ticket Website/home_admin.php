<?php 
require_once('Connections/pesantiket.php'); // Koneksi ke database

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
?>

<?php
if (!isset($_SESSION)) {
  session_start();
}

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  $isValid = False; 
  if (!empty($UserName)) { 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  global $pesantiket;  // Mengakses koneksi database

  // Gunakan mysqli_real_escape_string untuk menghindari SQL injection
  $theValue = mysqli_real_escape_string($pesantiket, $theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// Tidak perlu lagi mysql_select_db, karena koneksi sudah ada dengan mysqli
$searchID = isset($_GET['searchID']) ? GetSQLValueString($_GET['searchID'], "text") : null;

$query_daftarpemesan = "SELECT * FROM pesantiket";
if ($searchID) {
  $query_daftarpemesan .= " WHERE ID = $searchID";
}
$query_daftarpemesan .= " ORDER BY ID ASC";

// Menggunakan mysqli_query untuk eksekusi query
$daftarpemesan = mysqli_query($pesantiket, $query_daftarpemesan) or die(mysqli_error($pesantiket));
$row_daftarpemesan = mysqli_fetch_assoc($daftarpemesan);
$totalRows_daftarpemesan = mysqli_num_rows($daftarpemesan);
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Halaman Admin</title>
<script>
function confirmDeletion(event) {
    if (!confirm("Apakah yakin Anda ingin menghapusnya?")) {
        event.preventDefault();
    }
}
function closeAlert() {
    var alertBox = document.getElementById('alertBox');
    if (alertBox) {
        alertBox.style.display = 'none';
    }
}
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body, html {
    height: 100%;
	background-color:#f0f0f0;
    font-family: "Montserrat", sans-serif;
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

.content {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
	background-color:#FFFFFF;
	border-radius:5px;
	 margin:8px;
  
}

.search-form {
    margin-bottom: 20px;
    text-align: right;
}

.search-form input[type="text"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
    font-size: 14px;
}

.search-form input[type="submit"] {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    font-size: 14px;
    cursor: pointer;
}

.search-form input[type="submit"]:hover {
    background-color: #0056b3;
}

.alert-succes {
    background-color: #d4edda;
    color: #155724;
    font-size: 13px;
    border: 1px solid #c3e6cb;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 20px;
    text-align: left;
    font-weight: bold;
    position: relative;
}

.close {
    background: none;
    border: none;
    font-size: 20px;
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
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
    padding: 7px;
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

.button {
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    margin: 0 5px;
}

.button.edit {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.button.edit:hover {
text-decoration:none;
    background-color: #0056b3;
    border-color: #0056b3;
}

.button.delete {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.button.delete:hover {
text-decoration:none;
    background-color: #c82333;
    border-color: #c82333;
}

.status-button {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 4px;
    color: white;
    font-size: 13px;
    font-weight: bold;
    text-align: center;
}

.status-belum-terpakai {
    background-color: red;
}

.status-sudah-terpakai {
    background-color: green;
}

.title {
    font-size: 30px;
    font-weight: bold;
    margin: 30px 0;
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

  <div class="content">
    <p align="center" class="title">DAFTAR PEMESAN</p>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="search-form">
      <input type="text" name="searchID" placeholder="Cari ID" value="<?php echo isset($_GET['searchID']) ? htmlspecialchars($_GET['searchID']) : ''; ?>" />
      <input type="submit" value="Cari" />
    </form>

    <?php
    if (isset($_GET['update']) && $_GET['update'] == 'success') {
        echo '<div class="alert-succes" id="alertBox">Tiket berhasil diupdate <button class="close" onclick="closeAlert()">×</button></div>';
    }

    if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
        echo '<div class="alert-succes" id="alertBox">Data berhasil dihapus <button class="close" onclick="closeAlert()">×</button></div>';
    }
    ?>

    <table class="data-table">
      <thead>
        <tr>
          <th><div align="center">ID</div></th>
          <th><div align="center">STATUS</div></th>
          <th>NAMA</th>
          <th><div align="center">NO TELEPON</div></th>
          <th><div align="center">HARGA</div></th>
          <th><div align="center">TANGGAL PEMESANAN</div></th>
          <th><div align="center">AKSI</div></th>
        </tr>
      </thead>
      <tbody>
        <?php if ($totalRows_daftarpemesan > 0) { ?>
          <?php do { ?>
            <tr>
              <td><div align="center"><?php echo $row_daftarpemesan['ID']; ?></div></td>
              <td>
                <div align="center">
                    <?php if ($row_daftarpemesan['Status'] == "Tiket Belum Terpakai"): ?>
                        <span class="status-button status-belum-terpakai"><?php echo htmlspecialchars($row_daftarpemesan['Status']); ?></span>
                    <?php else: ?>
                        <span class="status-button status-sudah-terpakai"><?php echo htmlspecialchars($row_daftarpemesan['Status']); ?></span>
                    <?php endif; ?>
                </div>
              </td>
              <td><div align="left"><?php echo $row_daftarpemesan['Nama']; ?></div></td>
              <td><div align="center"><?php echo $row_daftarpemesan['No_Telepon']; ?></div></td>
              <td><div align="center"><?php echo $row_daftarpemesan['Harga']; ?></div></td>
              <td><div align="center"><?php echo $row_daftarpemesan['Tanggal_Pemesanan']; ?></div></td>
              <td>
                <div align="center">
                  <a href="edit_data.php?ID=<?php echo $row_daftarpemesan['ID']; ?>" class="button edit">Edit</a> 
                  <a href="hapus_data.php?ID=<?php echo $row_daftarpemesan['ID']; ?>&delete=success" class="button delete" onClick="confirmDeletion(event)">Hapus</a>
                </div>
              </td>
            </tr>
          <?php } while ($row_daftarpemesan = mysqli_fetch_assoc($daftarpemesan)); ?>
        <?php } else { ?>
          <tr>
            <td colspan="7" align="center">Data tidak ditemukan</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>

<?php
mysqli_free_result($daftarpemesan);
?>