<?php
require_once('Connections/pesantiket.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Gunakan mysqli_real_escape_string() untuk melindungi input
    $id = mysqli_real_escape_string($pesantiket, $id);
    
    // Query untuk mengambil data berdasarkan ID tiket
    $query = sprintf("SELECT * FROM pesantiket WHERE ID = '%s'", $id);

    // Eksekusi query
    $result = mysqli_query($pesantiket, $query);
    
    if (!$result) {
        // Menangani error jika query gagal
        die("Error: " . mysqli_error($pesantiket));
    }

    // Ambil data dari hasil query
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        // Jika ID tidak ditemukan
        die("ID tiket tidak ditemukan.");
    }
} else {
    // Jika ID tidak ada dalam URL
    die("ID tiket tidak ditemukan.");
}

$print_time = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Tiket_TURMANUSIA2024</title>
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
  font-family: "Montserrat", sans-serif;
}

.container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin: 50px auto;
  padding: 20px;
  border: 2px solid #000;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  max-width: 1200px; 
}
.ticket-details {
	padding:30px 0 30px 20px;
    width: 50%;
    max-width: 300px;
}

.ticket-details p {
    font-family: "Montserrat", sans-serif;
    margin-bottom: 10px;
}

.ticket {
    width: 50%;
	padding-left:30px;
	padding-top:20px;
    border-collapse: collapse;
}

.ticket th, .ticket td {
  padding: 10px;
  text-align: left;
  vertical-align: top;
}

.ticket th {
  background-color: #f4f4f4;
  padding-left: 10px;
}

.ticket td {
  padding-bottom: 18px;
}

.style34 {
  font-size: 50px;
  font-weight: bold;
}

.style35 {
  font-size: 30px;
}

.style37 {
  font-size: 24px;
  font-weight: bold;
}

blockquote {
  font-family: "Montserrat", sans-serif;
  line-height:30px;
}

.style40 {font-size: 14; }
</style>
</head>

<body>
<p align="center"><strong>Tanggal Cetak Tiket:</strong> <?php echo $print_time; ?></p>

<div class="container">
  <div class="ticket-details">
    <p class="style37">T I K E T</p>
    <p class="style37">&nbsp;</p>
    <p class="style37">&nbsp;</p>
    <p class="style34">T U L U S <br>
      <span class="style35">TUR MANUSIA</span></p>
    <p>&nbsp;</p>
    <p>27 AGUSTUS 2024</p>
    <p>JAKARTA INTERNATIONAL EXPO (JIEXPO)</p>
  </div>

  <div class="ticket">
    <table>
      <tr>
        <td><span class="style40"><?php echo htmlspecialchars($row['ID']); ?></span></td>
      </tr>
      <tr>
        <td><span class="style40"><?php echo htmlspecialchars($row['Nama']); ?></span></td>
      </tr>
      <tr>
        <td><span class="style40"><?php echo htmlspecialchars($row['No_Telepon']); ?></span></td>
      </tr>
      <tr>
        <td>Rp. 200,000</td>
      </tr>
      <tr>
        <td><span class="style40"><?php echo htmlspecialchars($row['Tanggal_Pemesanan']); ?></span></td>
      </tr>
      <tr>
        <td>
          <div>
            <img src="bahan/barcode.gif" alt="Barcode Admin" width="118" height="109" align="left"></div></td>
      </tr>
    </table>
  </div>
</div>

<blockquote>
  <p><strong>*Tiket/ID tiket diperlihatkan kepada petugas</strong></p>
  <p><strong>*Transfer Pembayaran tiket: BRI No.Rekening: 08664435672228 A/N Vivi Ariani</strong></p>
  <p><strong>*Pembayaran yang terkonfirmasi status tiket akan berubah "Tiket sudah terpakai"</strong></p>
  <p><strong>*Informasi lebih lanjut hubungi: 084423145521</strong></p>
</blockquote>
</body>
</html>
