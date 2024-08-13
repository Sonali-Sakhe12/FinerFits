<?php
require_once("include/initialize.php");

if(isset($_SESSION["USER"])){
  redirect(web_root);
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Forgot Password @ FinerFits</title>
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
  cursor: pointer;
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
            <h4>FORGOT PASSWORD</h4>
            <p>Please enter your email.</p>
          </div>
        </div>
        <form class="login-form" method="POST">
          <?php
            echo "<script>console.log(".check_message().")</script>";
          ?> 
          <input type="email" name="user_email" placeholder="Enter Email.." required/>
          <button type="submit" name="btnLogin">Send</button>
        </form>
      </div>
    </div>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
</body>

</html>

<?php 

if(isset($_POST['btnLogin'])){
  $email = trim($_POST['user_email']);
  
   if ($email == '') {
        
      message("Invalid Email!", "error");
      redirect(web_root."forgotPassword.php");
         
    } else {  
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:d",time() + 60 * 30);
        $db = new Database();
        $sql = $db->conn->prepare("UPDATE tblcustomer SET reset_token = ?, reset_token_expires_at = ? WHERE EMAILADD = ?");
        $sql->bind_param("sss",$token_hash, $expiry, $email);
        $sql->execute();
        if($db->conn->affected_rows){
            $mail = require "mailer.php";
            $mail->setFrom(smtp_username);
            $mail->addAddress($email);     
            $mail->Subject = 'Reset Password';
            $site_host=site_host;
            $mail->Body = "
            <!DOCTYPE html>
            <html lang=\"en\">

            <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>Password Reset</title>
            <style>
                body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                }

                .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                h2 {
                color: #333333;
                }

                p {
                color: #666666;
                }

                .btn {
                display: inline-block;
                padding: 10px 20px;
                text-decoration: none;
                background-color: #3498db;
                color: #ffffff;
                border-radius: 5px;
                }

                .footer {
                margin-top: 20px;
                padding-top: 10px;
                border-top: 1px solid #cccccc;
                text-align: center;
                }
            </style>
            </head>

            <body>
            <div class=\"container\">
                <h2>Password Reset</h2>
                <p>Hello,</p>
                <p>We received a request to reset your password. If you did not make this request, please ignore this email.</p>
                <p>To reset your password, click the button below:</p>
                <p><a class=\"btn\" href=\"$site_host/resetPassword.php?token=$token\">Reset Password</a></p>
                <p>If the button above does not work, you can copy and paste the following link into your browser:</p>
                <p>$site_host/resetPassword.php?token=$token</p>
                <p>This link will expire in 30 minutes.</p>
                <p>If you did not request a password reset or have any concerns, please contact our support team.</p>
                <div class=\"footer\">
                <p>Thank you,</p>
                <p>FinerFits</p>
                </div>
            </div>
            </body>
            </html>
            ";
            try {
                $mail->send();
            } catch (Exception $e){
                message("Message could not be sent! Please contact customer support. Mailer error:{$mail->ErrorInfo}", "error");
                redirect(web_root."login.php"); 
            }
        }
        message("Message sent! Please check your inbox.", "error");
        redirect(web_root."login.php"); 
 }
 } 
 ?> 




