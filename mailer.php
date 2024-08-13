<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("include/initialize.php");
require ('admin/vendors/PHPMailer/src/Exception.php');
require ('admin/vendors/PHPMailer/src/PHPMailer.php');
require ('admin/vendors/PHPMailer/src/SMTP.php');
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Username = smtp_username;
$mail->Password = smtp_password;
$mail->Host = smtp_host;
$mail->Port = smtp_port;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->isHTML(true);
return $mail;
?>