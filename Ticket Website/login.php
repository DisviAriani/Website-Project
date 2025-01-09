<?php
require_once('Connections/login.php'); // Koneksi ke database

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        // Menggunakan mysqli_real_escape_string untuk sanitasi input
        global $login;  // Memastikan variabel koneksi tersedia
        $theValue = mysqli_real_escape_string($login, $theValue);

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

if (!isset($_SESSION)) {
    session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

$loginError = false;

$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

if (isset($_POST['email'])) {
    $loginUsername = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberMe']); 
    $MM_fldUserAuthorization = "";
    $MM_redirectLoginSuccess = "home_admin.php";
    $MM_redirectLoginFailed = "login.php";
    $MM_redirecttoReferrer = false;

    // Tidak perlu lagi menggunakan mysql_select_db(), cukup dengan koneksi mysqli
    // Query login dengan sanitasi input menggunakan GetSQLValueString
    $LoginRS__query = sprintf("SELECT Email, Password FROM login WHERE Email=%s AND Password=%s",
        GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));

    // Eksekusi query menggunakan mysqli_query
    $LoginRS = mysqli_query($login, $LoginRS__query) or die(mysqli_error($login));

    // Mengecek apakah user ditemukan
    $loginFoundUser = mysqli_num_rows($LoginRS);
    if ($loginFoundUser) {
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = $MM_fldUserAuthorization;

        if ($rememberMe) {
            setcookie('email', $loginUsername, time() + (86400 * 30), "/");
            setcookie('password', $password, time() + (86400 * 30), "/");
        } else {
            setcookie('email', '', time() - 3600, "/");
            setcookie('password', '', time() - 3600, "/");
        }

        if (isset($_SESSION['PrevUrl']) && false) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }
        header("Location: " . $MM_redirectLoginSuccess);
    } else {
        $loginError = true;
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Admin</title>
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
  height: 100%;
  display: flex;
  justify-content: center;
  background:url(bahan/login-background.jpg)no-repeat center center fixed;
  background-size:cover;
  align-items: center;
  font-family: "Montserrat", sans-serif;
}
.login-container {
  margin-top: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.8);
  border-radius: 8px;
  width: 900px;
  padding: 50px;
  box-sizing: border-box;
}

.login-image {
  flex: 1;
 
}

.login-image img {
  width: 300px;
  height: auto;
}

.login-form {
  flex: 2;
  padding-left: 100px;
}

.login-form h1 {
  font-size: 20px;
  text-align: center;
  color:#FFFFFF;
  margin-bottom:20px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  color:#FFFFFF;
  font-size:14px;
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
  margin-top: 20px;
}

.form-actions input[type="submit"] {
  background-color: #042CE3;
  color:#FFFFFF;
  border: none;
  padding: 10px 20px;
  width: 100%;
  border-radius: 4px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s;
  
}

.form-actions input[type="submit"]:hover {
  background-color:#999999;
}

.error-message {
  color: #e74c3c;
  font-size: 14px;
  text-align: center;
  margin-top: 10px;
  font-weight: bold;
}

.remember-me {
  display: flex;
  align-items: center;
  margin-top: 10px;
}

.remember-me input[type="checkbox"] {
  margin-right: 10px;
}

.remember-me label {
  font-size: 14px;
  color:#FFFFFF;
 
}
.style3 {
color:#000000;

}
.style8 {

	font-weight: bold;
	font-size: 24px;
}

</style>
</head>
<body>
<div class="login-container">
  <div class="login-image">
    <p align="center"><img src="bahan/account-security_11135274.png" width="188" height="192"></p>
  </div>
  <div class="login-form">
    <h1>Masuk sebagai Admin</h1>
    <div class="error-message">
      <?php if ($loginError) { ?>*Email atau Password salah<?php } ?>
    </div>
    <form id="form1" name="form1" method="POST" action="<?php echo htmlspecialchars($loginFormAction); ?>">
      <div class="form-group">
        <label for="email">Email</label>
        <input name="email" type="text" id="email" value="<?php echo htmlspecialchars($email); ?>" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input name="password" type="password" id="password" value="<?php echo htmlspecialchars($password); ?>" required />
      </div>
      <div class="remember-me">
        <input type="checkbox" id="rememberMe" name="rememberMe" <?php echo isset($_COOKIE['email']) ? 'checked' : ''; ?> />
        <label for="rememberMe">Remember Me</label>
      </div>
      <div class="form-actions">
        <input type="submit" name="login" id="login" value="Login"/>
      </div>
    </form>
  </div>
</div>
</body>
</html>
