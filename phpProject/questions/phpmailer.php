//anything missing?

<?php
require 'C:\xampp\htdocs\vendor\phpmailer/src/PHPMailer.php';
require 'C:\xampp\htdocs\vendor\phpmailer/src/SMTP.php';
require 'C:\xampp\htdocs\vendor\phpmailer/src/Exception.php';

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
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

// Set email subject
$mail->Subject = 'Confirmation Email';

// Set email body
$mail->Body = 'This is the content of the confirmation email.';

// Set recipient(s)
$mail->addAddress('brychjakub@gmail.com.com', 'Recipient Name');


// Send the email
if ($mail->send()) {
    echo 'Confirmation email sent successfully.';
} else {
    echo 'Error sending confirmation email: ' . $mail->ErrorInfo;
}
?>
