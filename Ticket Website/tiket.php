<?php
require_once('Connections/pesantiket.php');
session_start();

if (isset($_GET['no_telepon'])) {
    $no_telepon = $_GET['no_telepon'];

    // Gunakan mysqli_real_escape_string() untuk melindungi input
    $no_telepon = mysqli_real_escape_string($pesantiket, $no_telepon);

    // Query untuk mengambil data berdasarkan no_telepon
    $query = sprintf("SELECT * FROM pesantiket WHERE No_Telepon = '%s'", $no_telepon);
    
    // Eksekusi query
    $result = mysqli_query($pesantiket, $query);
    
    if (!$result) {
        // Menangani error jika query gagal
        die("Error: " . mysqli_error($pesantiket));
    }

    // Ambil data dari hasil query
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        // Jika data tidak ditemukan
        $_SESSION['not_found'] = true;
        header('Location: cari_tiket.php');
        exit();
    }
} else {
    // Jika no_telepon tidak ada dalam URL
    $_SESSION['not_found'] = true;
    header('Location: cari_tiket.php');
    exit();
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detail Tiket</title>
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
  background:url(bahan/Snapinsta.app_368192932_3591669771091280_1034198150418802813_n_1080.jpg) no-repeat center center fixed;
  background-size: cover;
}

.header {
  background-color: #000;
  padding: 7px 0;
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  display: none; 
}

.header.show {
  display: block; 
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

.table-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 80%;
  padding: 20px;
  margin: 50px auto;
  background-color: rgba(0, 0, 0, 0.8);
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.table-left {
  flex: 1;
  flex-basis: 40%;
  text-align: left;
  color: #fff;
}

.table-right {
  flex: 2;
  flex-basis: 50%;
  color: #fff;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  color: #fff;
}

.table-container table {
  width: 100%;
  border-collapse: collapse;
}

.table-container td {
  padding: 10px;
  text-align: left;
  color: #fff;
}

.table-container input[type="text"] {
  width: calc(100% - 20px);
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  color: #333;
}

.table-container input[type="text"].no-background {
  background-color: transparent;
  border: none;
  padding: 0;
  width: auto;
  color: #fff;
}

.status-tiket {
  padding: 10px;
  border-radius: 4px;
  color: #fff;
  font-weight: bold;
  text-align: left;
  margin-bottom: 20px;
  font-family: "Courier New", Courier, monospace;
}

.status-belum-terpakai {
  background-color: #042CE3;
}

.status-sudah-terpakai {
  background-color: green;
}

.button {
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  text-decoration: none;
  display: block;
  text-align: center;
  width: 100%;
  box-sizing: border-box;
}

.button-red {
  background-color: #FF0000;
  font-weight: bold;
  font-family: "Montserrat", sans-serif;
}

.button-red:hover {
  background-color: #CC0000;
}

.style27 {
  font-size: 40px;
  font-weight: bold;
  padding-bottom: 10px;
}

.style28 {
  font-size: 14px;
}
</style>
<script>
function openPrintWindow(url) {
  var printWindow = window.open(url, 'Print');
  printWindow.onbeforeunload = function() {
    window.location.href = 'pesan_tiket.php'; 
  };
  printWindow.onafterprint = function() {
    printWindow.close();
  };
  printWindow.print();
}

document.addEventListener('DOMContentLoaded', function() {
  var statusTiket = "<?php echo $row['Status']; ?>";
  var header = document.querySelector('.header');
  if (statusTiket === 'Tiket Sudah Terpakai') {
    header.classList.add('show');
  } else {
    header.classList.remove('show');
  }
});
</script>

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

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
<p>&nbsp; </p>
<p>&nbsp; </p>

<div class="table-container">
  <div class="table-left">
    <p class="style27">DETAIL</p>
    <p class="style27">TIKET ANDA</p>
    <p class="style3 style28">&nbsp;</p>
    <p class="style3 style28">Informasi tiket Anda dapat dilihat di sebelah kanan.</p>
    <p class="style3 style28"><br>Silahkan unduh tiket anda sekarang sebagai e-tiket </p>
    <p class="style3 style28">yang <strong>WAJIB</strong> diperlihatkan kepada petugas pada saat penukaran tiket fisik</p>
    <p class="style3 style28">&nbsp;</p>
    <p class="style3 style28">Detail konfimasi pembayaran ada pada tiket.</p>
  </div>
  <div class="table-right">
    <div class="status-tiket <?php echo ($row['Status'] === 'Tiket Belum Terpakai') ? 'status-belum-terpakai' : 'status-sudah-terpakai'; ?>">
      <?php echo htmlspecialchars($row['Status']); ?>
    </div>
    <table>
      <tr>
        <td width="50%"><span>ID</span></td>
        <td width="50%"><strong><?php echo htmlspecialchars($row['ID']); ?></strong></td>
      </tr>
      <tr>
        <td width="50%"><span>Nama</span></td>
        <td width="50%"><strong><?php echo htmlspecialchars($row['Nama']); ?></strong></td>
      </tr>
      <tr>
        <td width="50%"><span>No Telepon</span></td>
        <td width="50%"><strong><?php echo htmlspecialchars($row['No_Telepon']); ?></strong></td>
      </tr>
      <tr>
        <td width="50%"><span>Harga</span></td>
        <td width="50%"><input type="text" class="no-background" value="Rp. 200,000" readonly /></td>
      </tr>
      <tr>
        <td width="50%"><span>Tanggal Pemesanan</span></td>
        <td width="50%"><strong><?php echo htmlspecialchars($row['Tanggal_Pemesanan']); ?></strong></td>
      </tr>
    </table>
    <div class="button-container" style="text-align: center; margin-top: 20px;">
      <?php if ($row['Status'] === 'Tiket Belum Terpakai'): ?>
      <button class="button button-red" onClick="openPrintWindow('cetak_tiket.php?id=<?php echo htmlspecialchars($row['ID']); ?>')">
        Unduh Tiket
      </button>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
