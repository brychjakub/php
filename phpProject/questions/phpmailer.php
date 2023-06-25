<?php
require 'path/to/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

// Set SMTP settings
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';  // Replace with the SMTP server address provided by Microsoft
$mail->Port = 587;  // Replace with the SMTP port number provided by Microsoft
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = 'your-email@example.com';  // Replace with your email address
$mail->Password = 'your-email-password';  // Replace with your email password

// Set email content
$mail->setFrom('your-email@example.com', 'Your Name');
$mail->addAddress('recipient@example.com', 'Recipient Name');
$mail->Subject = 'Subject of the Email';
$mail->Body = 'Email body content';

// Send the email
if (!$mail->send()) {
    echo 'Error sending email: ' . $mail->ErrorInfo;
} else {
    echo 'Email sent successfully!';
}
?>
