<?php
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\SMTP.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Instantiate PHPMailer
$mail = new PHPMailer(true);

// Enable verbose debug output (optional)
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

// Set the mailer to use SMTP
$mail->isSMTP();

// Configure SMTP settings
$mail->Host       = 'smtp.office365.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'brych@cmczs.cz';
$mail->Password   = 'Iphone4S';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS encryption
$mail->Port       = 587;

// Set email subject
$mail->Subject = 'Confirmation Email';

// Set email body
$mail->Body = 'Dobrý den, mé jméno je Jakub a toto je potvrzovací email.

děkuji za váš čas a přeji hezký den';

// Set recipient(s)
$mail->addAddress('brych@cmczs.cz', 'Recipient Name');

$mail->CharSet = 'UTF-8';

$mail->ContentType = 'text/html; charset=UTF-8';

// Send the email
if ($mail->send()) {
    echo 'Confirmation email sent successfully.';
} else {
    echo 'Error sending confirmation email: ' . $mail->ErrorInfo;
}
?>
