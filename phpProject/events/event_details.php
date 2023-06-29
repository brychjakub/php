<?php
// Database configuration
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'first_db';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the event details from the database
    $eventId = $_GET['eventId']; // Assuming the event ID is passed through the URL

    // Fetch event details
    $stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?');
    $stmt->bindParam(1, $eventId);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        $openPositions = $event['openPositions'];
        $startTime = strtotime($event['startTime']);
        $endTime = strtotime($event['endTime']);
        $bookingPeriod = $event['bookingPeriod'];
        
        $slots = array();
        $currentTime = $startTime;
        
        while ($currentTime < $endTime) {
            $slotTime = date('H:i', $currentTime);
            $slots[] = array(
                'time' => $slotTime,
                'pupils' => array()
            );
        
            $currentTime = strtotime("+$bookingPeriod minutes", $currentTime);
        }

        // Fetch reservation slots for the event
        $stmt = $pdo->prepare('SELECT * FROM reservations WHERE eventID = ?');
        $stmt->bindParam(1, $eventId);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare an array to store the pupil details
        $pupils = array();

        // Loop through the reservations and fetch the corresponding pupil details
        foreach ($reservations as $reservation) {
            $pupilId = $reservation['pupilID'];

            // Fetch pupil details
            $stmt = $pdo->prepare('SELECT * FROM pupils WHERE id = ?');
            $stmt->bindParam(1, $pupilId);
            $stmt->execute();
            $pupil = $stmt->fetch(PDO::FETCH_ASSOC);

            // Find the corresponding time slot for the reservation
            $slotIndex = array_search($reservation['time'], array_column($slots, 'time'));

            // Add the pupil details to the corresponding time slot
            if ($slotIndex !== false) {
                $slots[$slotIndex]['pupils'][] = $pupil;
            }
        }

        // Display the event details
        echo '<h2>Detaily události</h2>';
        echo '<p>Název: ' . $event['eventName'] . '</p>';
        echo '<p>Čas začátku: ' . $event['startTime'] . '</p>';
        echo '<p>Čas konce: ' . $event['endTime'] . '</p>';

        // Display the reservation slots and corresponding pupil details
        echo '<h2>Rezervační časy</h2>';
        foreach ($slots as $index => $slot) {
            echo '<div class="slot">';
            echo '<h3>'  . $slot['time'] . '</h3>';

            if (!empty($slot['pupils'])) {
                echo '<table>';
                echo '<tr><th>Jméno</th><th>Datum narození</th><th>Adresa</th><th>Jméno zákonného zástupce</th><th>E-mail</th><th>Telefon</th></tr>';

                foreach ($slot['pupils'] as $pupil) {
                    echo '<tr>';
                    echo '<td>' . $pupil['firstname'] . ' ' . $pupil['lastname'] . '</td>';
                    echo '<td>' . $pupil['childBirthDay'] . '</td>';
                    echo '<td>' . $pupil['childHomeAddressStreet'] . ' ' . $pupil['childHomeAddressNumber'] . ', ' . $pupil['childHomeAddressCity'] . ' ' . $pupil['childHomeAddressPostcode'] . '</td>';
                    echo '<td>' . $pupil['legalRepresentativeFirstname'] .  ' ' . $pupil['legalRepresentativeSurname'] . '</td>';
                    echo '<td>' . $pupil['legalRepresentativeEmail'] . '</td>';
                    echo '<td>' . $pupil['legalRepresentativePhone'] . '</td>';
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo '<p>Zatím nikdo 😢</p>';
            }

            echo '</div>';
        }
    } else {
        echo 'Událost nebyla nalezena.';
    }

    // Close the database connection
    $pdo = null;
} catch (PDOException $e) {
    // Display error message
    echo 'Chyba: ' . $e->getMessage();
}
?>