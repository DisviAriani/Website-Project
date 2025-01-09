<?php
require_once('Connections/pesantiket.php'); 
?>

<?php
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
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        // Menggunakan mysqli_real_escape_string untuk menghindari SQL injection
        global $pesantiket;  // Mengakses koneksi database
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

$query_sudahCheckIn = "SELECT * FROM pesantiket WHERE Status = 'Tiket Sudah Terpakai' ORDER BY ID ASC";
$sudahCheckIn = mysqli_query($pesantiket, $query_sudahCheckIn) or die(mysqli_error($pesantiket));
$row_sudahCheckIn = mysqli_fetch_assoc($sudahCheckIn);
$totalRows_sudahCheckIn = mysqli_num_rows($sudahCheckIn);

$query_belumCheckIn = "SELECT * FROM pesantiket WHERE Status = 'Tiket Belum Terpakai' ORDER BY ID ASC";
$belumCheckIn = mysqli_query($pesantiket, $query_belumCheckIn) or die(mysqli_error($pesantiket));
$row_belumCheckIn = mysqli_fetch_assoc($belumCheckIn);
$totalRows_belumCheckIn = mysqli_num_rows($belumCheckIn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Data Laporan</title>
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

.table-container {
  margin-bottom: 20px;
}

.data-table {
  width: 100%;
  margin-bottom: 40px;
  border-collapse: collapse;
  background-color: #fff;
  border: 1px solid #ddd;
}

.data-table th {
  background-color: #042CE3;
  padding: 10px;
  color:#fff;
  border: 1px solid #ddd;
  text-align: left;
  font-size: 14px;
}

.data-table td {
  padding: 10px;
  border: 1px solid #ddd;
  font-size: 12px;
  color: #000;
}

.data-table tr:nth-child(odd) {
  background-color: #f9f9f9;
}

.data-table tr:nth-child(even) {
  background-color: #fff;
}

.print-button {
  display: block;
  width: 150px;
  margin: 20px auto;
  padding: 10px;
  font-size: 16px;
  font-weight: bold;
  color: #fff;
  background-color: #007bff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.print-button:hover {
  background-color: #0056b3;
}

@media print {
  .header,
  .print-button {
    display: none;
  }

  body {
    margin: 0;
    padding: 0;
  }

  .content {
    margin: 0;
    padding: 0;
  }

  .data-table {
    width: 100%;
    border-collapse: collapse;
  }

  .data-table th, .data-table td {
    padding: 7px;
    font-size: 12px;
  }

  .data-table th {
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    text-align: left;
  color:#000000;
  }

  .data-table td {
    border: 1px solid #ddd;
  }

  .data-table tr:nth-child(odd) {
    background-color: #f9f9f9;
  }

  .data-table tr:nth-child(even) {
    background-color: #fff;
  }
}

.style4 {
  font-size: 24px;
  font-weight: bold;
}

.style5 {
  font-size: 30px;
  font-weight: bold;
}

.style6 {
  font-size: 24px;
  font-weight: bold;
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
    <a href="home_admin.php">Daftar Pemesan</a>
    <a href="check-in.php">Check In</a>
    <a href="laporan.php">Laporan</a>
    <a href="<?php echo $logoutAction ?>" class="logout">Log Out</a>
  </div>
  
  <div class="content">
    <h1 align="center" class="style4">DAFTAR SUDAH CHECK IN</h1>
    <div class="table-container">
      <table class="data-table">
        <tr>
          <th width="10%">ID</th>
          <th width="25%">Nama</th>
          <th>No_Telepon</th>
          <th>Harga</th>
          <th width="15%">Tanggal_Pemesanan</th>
          <th>Status</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_sudahCheckIn['ID']; ?></td>
            <td><?php echo $row_sudahCheckIn['Nama']; ?></td>
            <td><?php echo $row_sudahCheckIn['No_Telepon']; ?></td>
            <td><?php echo $row_sudahCheckIn['Harga']; ?></td>
            <td><?php echo $row_sudahCheckIn['Tanggal_Pemesanan']; ?></td>
            <td><?php echo $row_sudahCheckIn['Status']; ?></td>
          </tr>
        <?php } while ($row_sudahCheckIn = mysqli_fetch_assoc($sudahCheckIn)); ?>
      </table>
    </div>
    
    <h1 align="center" class="style4">DAFTAR BELUM CHECK IN</h1>
    <div class="table-container">
      <table class="data-table">
        <tr>
          <th width="10%">ID</th>
          <th width="25%">Nama</th>
          <th>No_Telepon</th>
          <th>Harga</th>
          <th width="15%">Tanggal_Pemesanan</th>
          <th>Status</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_belumCheckIn['ID']; ?></td>
            <td><?php echo $row_belumCheckIn['Nama']; ?></td>
            <td><?php echo $row_belumCheckIn['No_Telepon']; ?></td>
            <td><?php echo $row_belumCheckIn['Harga']; ?></td>
            <td><?php echo $row_belumCheckIn['Tanggal_Pemesanan']; ?></td>
            <td><?php echo $row_belumCheckIn['Status']; ?></td>
          </tr>
        <?php } while ($row_belumCheckIn = mysqli_fetch_assoc($belumCheckIn)); ?>
      </table>
    </div>

    <button class="print-button" onClick="window.print()">Cetak Laporan</button>
  </div>
</div>
</body>
</html>

<?php
// Menggunakan mysqli_free_result() untuk membebaskan hasil query
mysqli_free_result($belumCheckIn);
mysqli_free_result($sudahCheckIn);
?>
