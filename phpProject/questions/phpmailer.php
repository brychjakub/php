<?php
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\SMTP.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Database credentials
$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = '';  // your db password
$dbName     = 'first_db';    // your db name

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the last inserted row from the pupils table
    $sql = "SELECT legalRepresentativeEmail, firstname, lastname, childBirthDay, childHomeAddressStreet, childHomeAddressNumber, childHomeAddressCity, childHomeAddressPostcode, legalRepresentativeFirstname, legalRepresentativeSurname, legalRepresentativePhone, legalRepresentativeHomeAddressStreet, legalRepresentativeHomeAddressNumber, legalRepresentativeHomeAddressCity, legalRepresentativeHomeAddressPostcode, note, eventDate FROM pupils ORDER BY id DESC LIMIT 1";
    $stmt = $conn->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

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

    $mail->setFrom('brych@cmczs.cz', 'Jakub');

    $mail->Subject = 'Potvrzení zápisu';

    // Set email body
    $mail->Body = 'Dobrý den,

    toto jsou informace, které jste použili během zápisu.
    
    Jméno: ' . $firstname . '
    Příjmení: ' . $lastname . '
    Datum narození: ' . $childBirthDay . '
    Adresa dítěte: ' . $childHomeAddressStreet . ' ' . $childHomeAddressNumber . ', ' . $childHomeAddressCity . ', ' . $childHomeAddressPostcode . '
    Jméno zákonného zástupce: ' . $legalRepresentativeFirstname . ' ' . $legalRepresentativeSurname . '
    Email zákonného zástupce: ' . $legalRepresentativeEmail . '
    Telefon zákonného zástupce: ' . $legalRepresentativePhone . '
    Adresa zákonného zástupce: ' . $legalRepresentativeHomeAddressStreet . ' ' . $legalRepresentativeHomeAddressNumber . ', ' . $legalRepresentativeHomeAddressCity . ', ' . $legalRepresentativeHomeAddressPostcode . '
    K zápisu přijďte: ' . $eventDate . ' ' . $note . ' 
    
    Děkujeme za váš čas.
    
    S pozdravem,
    Jakub';


    // Set recipient(s)
    $mail->addAddress($row['legalRepresentativeEmail'], 'Recipient Name');

    $mail->CharSet = 'UTF-8';
    $mail->ContentType = 'text/plain'; // Sending as plain text

    // Send the email
    if ($mail->send()) {
        echo 'Confirmation email sent successfully to ' . $row['legalRepresentativeEmail'] . '.';
    } else {
        echo 'Error sending confirmation email to ' . $row['legalRepresentativeEmail'] . ': ' . $mail->ErrorInfo;
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
