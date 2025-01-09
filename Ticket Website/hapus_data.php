<?php require_once('Connections/pesantiket.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
    {
        // Menggunakan mysqli_real_escape_string() untuk menghindari SQL injection
        global $pesantiket;  // Pastikan kita menggunakan koneksi yang sudah ada
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

if ((isset($_GET['ID'])) && ($_GET['ID'] != "")) {
    $deleteSQL = sprintf("DELETE FROM pesantiket WHERE ID=%s", GetSQLValueString($_GET['ID'], "text"));

    // Menggunakan mysqli_query untuk eksekusi query
    $Result1 = mysqli_query($pesantiket, $deleteSQL) or die(mysqli_error($pesantiket));

    $deleteGoTo = "home_admin.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
        $deleteGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $deleteGoTo));
}

$colname_hapus_data = "-1";
if (isset($_GET['ID'])) {
    $colname_hapus_data = $_GET['ID'];
}

// Menggunakan mysqli_query untuk query
$query_hapus_data = sprintf("SELECT * FROM pesantiket WHERE ID = %s", GetSQLValueString($colname_hapus_data, "text"));
$hapus_data = mysqli_query($pesantiket, $query_hapus_data) or die(mysqli_error($pesantiket));
$row_hapus_data = mysqli_fetch_assoc($hapus_data);
$totalRows_hapus_data = mysqli_num_rows($hapus_data);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
</body>
</html>

<?php
mysqli_free_result($hapus_data);
?>
