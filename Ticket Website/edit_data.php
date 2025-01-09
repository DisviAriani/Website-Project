<?php
// Hanya panggil koneksi yang sudah ada di file 'Connections/pesantiket.php'
require_once('Connections/pesantiket.php');

// Fungsi untuk menangani input data yang aman untuk SQL
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        // Pastikan untuk menggunakan koneksi yang telah didefinisikan
        global $pesantiket; // Menggunakan koneksi global yang dideklarasikan di file 'Connections/pesantiket.php'
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
    $updateSQL = sprintf("UPDATE pesantiket SET Status=%s, Nama=%s, No_Telepon=%s, Harga=%s, Tanggal_Pemesanan=%s WHERE ID=%s",
                         GetSQLValueString($_POST['Status'], "text"),
                         GetSQLValueString($_POST['Nama'], "text"),
                         GetSQLValueString($_POST['No_Telepon'], "text"),
                         GetSQLValueString($_POST['Harga'], "text"),
                         GetSQLValueString($_POST['Tanggal_Pemesanan'], "date"),
                         GetSQLValueString($_POST['ID'], "text"));

    // Menggunakan mysqli_query untuk eksekusi query
    $Result1 = mysqli_query($pesantiket, $updateSQL) or die(mysqli_error($pesantiket));

    $updateGoTo = "home_admin.php?update=success";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_data = "-1";
if (isset($_GET['ID'])) {
    $colname_edit_data = $_GET['ID'];
}

// Menggunakan mysqli_query untuk query
$query_edit_data = sprintf("SELECT * FROM pesantiket WHERE ID = %s", GetSQLValueString($colname_edit_data, "text"));
$edit_data = mysqli_query($pesantiket, $query_edit_data) or die(mysqli_error($pesantiket));
$row_edit_data = mysqli_fetch_assoc($edit_data);
$totalRows_edit_data = mysqli_num_rows($edit_data);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Data</title>
<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body, html {
  height: 100%;
  font-family: "Montserrat", sans-serif;
  background-color: #f0f0f0;
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
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color:#FFFFFF;
	border-radius:5px;
	 margin:8px;

}

.title {
  font-size: 30px;
  font-weight: bold;
  margin-bottom: 20px;
  color: #333;
}

form {
  max-width: 550px;
  width: 100%;
  color: black;
}

form table {
  width: 100%;
  border-collapse: collapse;
}

form td {
  padding: 10px;
  vertical-align: top; 
}

form .form-group {
  display: flex;
  flex-direction: column;
}

form .form-group label {
  margin-bottom: 5px;
  font-size:14px;
  font-weight: bold;
}

form .form-group input,
form .form-group select {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #fff;
  color: #000;
  
}

form .form-group input[readonly] {
  background-color: #f5f5f5;
}

form input[type="submit"],
form .back-button {
  background-color: #042CE3;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  text-align: center;
  font-size: 16px;
  line-height: 1.5;
  display: inline-block;
  margin-right:10px;
  width: auto;
  height: auto;
  text-decoration:none;
}

form .back-button {
  background-color:#FF0000;
}

form input[type="submit"]:hover,
form .back-button:hover {
  background-color: #CCCCCC;
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
    <p class="title">UPDATE DATA</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table>
            <tr valign="baseline">
                <td>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="Status" id="status">
                            <option value="Tiket Belum Terpakai" <?php if ($row_edit_data['Status'] == "Tiket Belum Terpakai") echo "SELECTED"; ?>>Tiket Belum Terpakai</option>
                            <option value="Tiket Sudah Terpakai" <?php if ($row_edit_data['Status'] == "Tiket Sudah Terpakai") echo "SELECTED"; ?>>Tiket Sudah Terpakai</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr valign="baseline">
                <td>
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input name="ID" type="text" id="id" value="<?php echo $row_edit_data['ID']; ?>" readonly/>
                    </div>
                </td>
            </tr>
            <tr valign="baseline">
                <td>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input name="Nama" type="text" id="nama" value="<?php echo htmlentities($row_edit_data['Nama'], ENT_COMPAT, 'utf-8'); ?>" />
                    </div>
                </td>
            </tr>
            <tr valign="baseline">
                <td>
                    <div class="form-group">
                        <label for="no_telepon">No_Telepon</label>
                        <input name="No_Telepon" type="text" id="no_telepon" value="<?php echo htmlentities($row_edit_data['No_Telepon'], ENT_COMPAT, 'utf-8'); ?>" />
                    </div>
                </td>
            </tr>
            <tr valign="baseline">
                <td>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input name="Harga" type="text" id="harga" value="<?php echo htmlentities($row_edit_data['Harga'], ENT_COMPAT, 'utf-8'); ?>" readonly />
                    </div>
                </td>
            </tr>
            <tr valign="baseline">
                <td>
                    <div class="form-group">
                        <label for="tanggal_pemesanan">Tanggal_Pemesanan</label>
                        <input name="Tanggal_Pemesanan" type="text" id="tanggal_pemesanan" value="<?php echo htmlentities($row_edit_data['Tanggal_Pemesanan'], ENT_COMPAT, 'utf-8'); ?>" readonly />
                    </div>
                </td>
            </tr>
            <tr valign="baseline">
                <td>
                    <input type="submit" value="Update" />
                    <a href="home_admin.php" class="back-button">Kembali</a>
                </td>
            </tr>
        </table>
        <input type="hidden" name="MM_update" value="form2" />
        <input type="hidden" name="ID" value="<?php echo $row_edit_data['ID']; ?>" />
    </form>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($edit_data);
?>
