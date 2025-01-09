<?php
require_once('Connections/pesantiket.php');

// Fungsi untuk generate ID acak
function generateRandomID($name) {
    $inisial_nama = strtoupper(substr($name, 0, 3)); 
    $angka_acak = rand(1000, 9999); 
    return "TCKT_" . $inisial_nama . "_" . $angka_acak;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['Nama'];
    $no_telepon = $_POST['No_Telepon'];
    $harga = $_POST['Harga'];

    // Generate ID tiket
    $id = generateRandomID($nama);
    $tanggal_pesanan = date("Y-m-d H:i:s");
    $status = 'Tiket Belum Terpakai';

    // Menggunakan mysqli_real_escape_string untuk menangani input dengan aman
    $id = mysqli_real_escape_string($pesantiket, $id);
    $nama = mysqli_real_escape_string($pesantiket, $nama);
    $no_telepon = mysqli_real_escape_string($pesantiket, $no_telepon);
    $harga = mysqli_real_escape_string($pesantiket, $harga);
    $tanggal_pesanan = mysqli_real_escape_string($pesantiket, $tanggal_pesanan);
    $status = mysqli_real_escape_string($pesantiket, $status);

    // Membuat query untuk memasukkan data
    $insertSQL = sprintf("INSERT INTO pesantiket (ID, Nama, No_Telepon, Harga, Tanggal_Pemesanan, Status) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
                         $id,
                         $nama,
                         $no_telepon,
                         $harga,
                         $tanggal_pesanan,
                         $status);

    // Menjalankan query
    $result = mysqli_query($pesantiket, $insertSQL);

    if ($result) {
        // Redirect jika data berhasil dimasukkan
        header("Location: tiket.php?no_telepon=$no_telepon");
        exit();
    } else {
        // Menangani error jika query gagal
        die("Error: " . mysqli_error($pesantiket));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pesan Tiket</title>
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
  background:url(bahan/pesan-background.jpg)no-repeat center center fixed;
  background-size: cover;
}

.header {
  background-color: #000000;
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
  color: #FFFFFF;
}

.header a:hover {
  color: #CCCCCC;
}

.style3 {
  font-size: 14px;
}
.form{
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 80px;
  background: rgba(0, 0, 0, 0.8);
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 90%;
  padding: 50px;
  box-sizing: border-box;
  color: #FFFFFF;
}
.login-image {
  flex: 1;
  text-align: left; 
}

.login-image p {
  margin: 0; 
  font-size: 33px; 
}

.login-form {
  flex: 2;
  padding-left: 80px;
}

.login-form h1 {
  font-size: 24px;
  text-align: center;
  color: #333;
  font-weight: bold;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
}

.form-actions {
  text-align: center;
}

.form-actions input[type="submit"] {
  background-color: #042CE3;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  width: 100%;
  transition: background-color 0.3s;
}

.form-actions input[type="submit"]:hover {
  background-color: #666666;
}

.style7 {
	font-size: 12px;
	color: #CCCCCC;
}
</style>
<script type="text/javascript">
function confirmSubmission() {
  return confirm('Apakah data anda sudah benar dan ingin memesan tiket?');
}
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

<div class="form">
  <div class="login-image">
    <p><strong>PEMESANAN TIKET KONSER</strong></p>
    <p>&nbsp;</p>
    <span class="style3">Lengkapi data di samping dengan benar untuk menuju pengunduhan tiket dan konfirmasi pembayaran.</span>
  </div>
  <div class="login-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onSubmit="return confirmSubmission();">
      <div class="form-group">
        <label for="Nama">Nama Lengkap</label>
        <input id="Nama" name="Nama" type="text" required />
      </div>
      <div class="form-group">
        <label for="No_Telepon">Nomor Telepon <span class="style7">*(nomor yang dapat di hubungi / nomor WhatsApp)</span></label>
        <input id="No_Telepon" name="No_Telepon" type="text" required />
      </div>
      <div class="form-group">
        <label for="Harga">Harga <span class="style7">*(pembayaran di lokasi/transfer)</span></label>
        <input id="Harga" name="Harga" type="text" value="Rp.200,000" readonly />
      </div>
      <div class="form-actions">
        <input type="submit" value="Pesan Tiket" />
      </div>
    </form>
  </div>
</div>
</body>
</html>
