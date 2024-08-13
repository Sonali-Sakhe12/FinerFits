<?php
require_once("include/initialize.php");
if(isset($_POST['btnReset'])){
    $token = $_POST["token"];
    $token_hash = hash("sha256", $token);
    $db = new Database();
    $sql = $db->conn->prepare("SELECT * FROM tblcustomer WHERE reset_token = ?");
    $sql->bind_param("s",$token_hash);
    $sql->execute();
    $result = $sql->get_result();
    $user = $result->fetch_assoc();
    if ($user === null) {
        message("Token not found.", "error");
        redirect(web_root."login.php"); 
        exit;
    }
    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        message("Token has expired.", "error");
        redirect(web_root."login.php"); 
        exit;
    }
    $password_hash=hash("sha256",$_POST["user_password"]);
    $sql = $db->conn->prepare("UPDATE tblcustomer SET CPASSWORD = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE CUSTOMERID = ?");
    $sql->bind_param("si",$password_hash, $user["CUSTOMERID"]);
    $sql->execute();
    message("Password reset successfully.", "error");
    redirect(web_root."login.php"); 
    exit;
} 
$token = $_GET["token"];
$token_hash = hash("sha256", $token);
$db = new Database();
$sql = $db->conn->prepare("SELECT * FROM tblcustomer WHERE reset_token = ?");
$sql->bind_param("s",$token_hash);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();
if($user === null){
    message("Token not found.", "error");
    redirect(web_root."login.php"); 
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    message("Token has expired.", "error");
    redirect(web_root."login.php"); 
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reset Password @ FinerFits</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="#" name="keywords">
<meta content="#" name="description">
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="style.css">
    <style>
    header .header{
  background-color: #fff;
  height: 45px;
}
header a img{
  width: 134px;
margin-top: 4px;
}
.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.login-page .form .login{
  margin-top: -31px;
margin-bottom: 26px;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background-color: #328f8a;
  background-image: linear-gradient(45deg,blue,white);
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
}
.form button:disabled {
  background-image: linear-gradient(45deg,grey,white);
  
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: white;
  text-decoration: none;
}

.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}

body {
  background-color: white;
  background-image: linear-gradient(45deg,white,white);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
</head>
  <body>
    <div class="login-page">
      <div class="form" >
        <div class="login">
          <div class="login-header">
            <h4>RESET PASSWORD</h4>
            <p>Please enter your new password.</p>
          </div>
        </div>
        <form class="login-form" method="POST">

          <?php
            echo "<script>console.log(".check_message().")</script>";
          ?> 
          <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
          <input type="password" name="user_password" placeholder="New Password" required/>
          <input type="password" name="user_confirm_password" placeholder="New Password" required/>
          <button type="submit" name="btnReset" id="btnReset" disabled>Reset</button>
        </form>
      </div>
    </div>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    <script>
        const newPasswordInput = document.getElementsByName("user_password")[0];
        const confirmPasswordInput = document.getElementsByName("user_confirm_password")[0];
        const resetButton =document.getElementById('btnReset')
        newPasswordInput.addEventListener("input", function () {
            if (newPasswordInput.value.trim() == "") {
                newPasswordInput.focus();
                resetButton.disabled=true;
            } else {
                resetButton.disabled=!(newPasswordInput.value.trim() !== "" && confirmPasswordInput.value.trim()!=="" && newPasswordInput.value === confirmPasswordInput.value);
            }
        });
        confirmPasswordInput.addEventListener("input", function () {
            if (confirmPasswordInput && newPasswordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.focus();
                resetButton.disabled=true
            } else {
                resetButton.disabled=!(newPasswordInput.value.trim() !== "" && confirmPasswordInput.value.trim()!=="" && newPasswordInput.value === confirmPasswordInput.value);
            }
        });
    </script>
</body>

</html>


