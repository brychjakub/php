<?php
require_once 'C:\xampp\htdocs\vendor\autoload.php'; 
use Dompdf\Dompdf;

$eventId = $_POST['eventId'];

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'first_db';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch event details
    $stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?');
    $stmt->bindParam(1, $eventId);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Handle case when event not found
    if (!$event) {
        echo 'Event not found.';
        exit;
    }

    // Fetch reservation slots for the event
    $stmt = $pdo->prepare('SELECT * FROM reservations WHERE eventID = ?');
    $stmt->bindParam(1, $eventId);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch pupil details for each reservation
    foreach ($reservations as $index => $reservation) {
        $pupilId = $reservation['pupilID'];

        $stmt = $pdo->prepare('SELECT * FROM pupils WHERE id = ?');
        $stmt->bindParam(1, $pupilId);
        $stmt->execute();
        $pupil = $stmt->fetch(PDO::FETCH_ASSOC);

        $reservations[$index]['pupil'] = $pupil;
    }

    // Close the database connection
    $pdo = null;

    // Generate HTML content
    // NOTE: It's crucial to sanitize output for any user-generated content to prevent potential XSS attacks
    $htmlContent = ''; 

    $htmlContent .= '<h2>Detaily události</h2>';
    $htmlContent .= '<p>Název: ' . htmlspecialchars($event['eventName']) . '</p>';
    $htmlContent .= '<p>Datum: ' . date('d.m.Y', strtotime($event['startDate'])) . '</p>';
    $htmlContent .= '<p>Čas začátku: ' . $event['startTime'] . '</p>';
    $htmlContent .= '<p>Čas konce: ' . $event['endTime'] . '</p>';

    // Loop through reservations and generate HTML content
    foreach ($reservations as $reservation) {
        $htmlContent .= '<div class="slot">';
        $htmlContent .= '<h2>Registrovaní na ' . htmlspecialchars($reservation['time']) . '</h2>';

        if (!empty($reservation['pupil'])) {
            $pupil = $reservation['pupil'];
            $htmlContent .= '<p>';
            $htmlContent .= 'Jméno: ' . htmlspecialchars($pupil['firstname']) . ' ' . htmlspecialchars($pupil['lastname']) . '<br>';
            $htmlContent .= 'Datum narození: ' . htmlspecialchars($pupil['childBirthDay']) . '<br>';
            $htmlContent .= 'Adresa: ' . htmlspecialchars($pupil['childHomeAddressStreet']) . ', ' . htmlspecialchars($pupil['childHomeAddressCity']) . ', ' . htmlspecialchars($pupil['childHomeAddressPostcode']) . '<br>';
            $htmlContent .= 'Jméno zákonného zástupce: ' . htmlspecialchars($pupil['legalRepresentativeFirstname']) . ' ' . htmlspecialchars($pupil['legalRepresentativeSurname']) . '<br>';
            $htmlContent .= 'E-mail: ' . htmlspecialchars($pupil['legalRepresentativeEmail']) . '<br>';
            $htmlContent .= 'Telefon: ' . htmlspecialchars($pupil['legalRepresentativePhone']);
            $htmlContent .= '</p>';
        } else {
            $htmlContent .= '<p style="text-align: center;">Zatím nikdo 😢</p>';
        }

        $htmlContent .= '</div>';
    }
    $dompdf = new Dompdf();
    $dompdf->loadHtml($htmlContent);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('filename.pdf');

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
