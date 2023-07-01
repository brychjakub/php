<?php
// Check if the form is submitted
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
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

        // Get the form data
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $childBirthDay = $_POST['childBirthDay'];
        $childHomeAddressStreet = $_POST['childHomeAddressStreet'];
        $childHomeAddressNumber = $_POST['childHomeAddressNumber'];
        $childHomeAddressCity = $_POST['childHomeAddressCity'];
        $childHomeAddressPostcode = $_POST['childHomeAddressPostcode'];
        $legalRepresentativeFirstname = $_POST['legalRepresentativeFirstname'];
        $legalRepresentativeSurname = $_POST['legalRepresentativeSurname'];
        $legalRepresentativeEmail = $_POST['legalRepresentativeEmail'];
        $legalRepresentativePhone = $_POST['legalRepresentativePhone'];
        $legalRepresentativeHomeAddressStreet = $_POST['legalRepresentativeHomeAddressStreet'];
        $legalRepresentativeHomeAddressNumber = $_POST['legalRepresentativeHomeAddressNumber'];
        $legalRepresentativeHomeAddressCity = $_POST['legalRepresentativeHomeAddressCity'];
        $legalRepresentativeHomeAddressPostcode = $_POST['legalRepresentativeHomeAddressPostcode'];
        $note = $_POST['note'];
        $eventDate = $_POST['eventDate'];

        // Check if the pupil already exists
        $checkPupilStmt = $pdo->prepare('SELECT COUNT(*) AS pupilCount FROM pupils WHERE firstname = ? AND lastname = ? AND childBirthDay = ?');
        $checkPupilStmt->bindParam(1, $firstname);
        $checkPupilStmt->bindParam(2, $lastname);
        $checkPupilStmt->bindParam(3, $childBirthDay);
        $checkPupilStmt->execute();
        $pupilCountResult = $checkPupilStmt->fetch(PDO::FETCH_ASSOC);
        $pupilCount = $pupilCountResult['pupilCount'];

        if ($pupilCount > 0) {
            // Redirect to the "sorry.html" page
            header('Location: sorry.php');
            exit();
        }

        // Get the event ID and slot time from the URL query parameters
        $eventId = $_GET['eventId'];
        $slotTime = $_GET['slotTime'];

        // Prepare the SQL statement to insert pupil data
        $pupilStmt = $pdo->prepare('INSERT INTO pupils (firstname, lastname, childBirthDay, childHomeAddressStreet, childHomeAddressNumber, childHomeAddressCity, childHomeAddressPostcode, legalRepresentativeFirstname, legalRepresentativeSurname, legalRepresentativeEmail, legalRepresentativePhone, legalRepresentativeHomeAddressStreet, legalRepresentativeHomeAddressNumber, legalRepresentativeHomeAddressCity, legalRepresentativeHomeAddressPostcode, note, eventDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

        // Bind the pupil form data to the prepared statement
        $pupilStmt->bindParam(1, $firstname);
        $pupilStmt->bindParam(2, $lastname);
        $pupilStmt->bindParam(3, $childBirthDay);
        $pupilStmt->bindParam(4, $childHomeAddressStreet);
        $pupilStmt->bindParam(5, $childHomeAddressNumber);
        $pupilStmt->bindParam(6, $childHomeAddressCity);
        $pupilStmt->bindParam(7, $childHomeAddressPostcode);
        $pupilStmt->bindParam(8, $legalRepresentativeFirstname);
        $pupilStmt->bindParam(9, $legalRepresentativeSurname);
        $pupilStmt->bindParam(10, $legalRepresentativeEmail);
        $pupilStmt->bindParam(11, $legalRepresentativePhone);
        $pupilStmt->bindParam(12, $legalRepresentativeHomeAddressStreet);
        $pupilStmt->bindParam(13, $legalRepresentativeHomeAddressNumber);
        $pupilStmt->bindParam(14, $legalRepresentativeHomeAddressCity);
        $pupilStmt->bindParam(15, $legalRepresentativeHomeAddressPostcode);
        $pupilStmt->bindParam(16, $note);
        $pupilStmt->bindParam(17, $eventDate);

        // Execute the pupil prepared statement
        $pupilStmt->execute();

        // Get the ID of the newly inserted pupil
        $pupilId = $pdo->lastInsertId();

        // Get the current reservation number for the same slot time
        $maxReservationNumberStmt = $pdo->prepare('SELECT MAX(reservationNumber) AS maxReservationNumber FROM reservations WHERE eventID = ? AND time = ?');
        $maxReservationNumberStmt->bindParam(1, $eventId);
        $maxReservationNumberStmt->bindParam(2, $slotTime);
        $maxReservationNumberStmt->execute();
        $maxReservationNumberResult = $maxReservationNumberStmt->fetch(PDO::FETCH_ASSOC);
        $currentReservationNumber = $maxReservationNumberResult['maxReservationNumber'] ?? 0;

        // Increment the reservation number by 1
        $newReservationNumber = $currentReservationNumber + 1;

        // Prepare the SQL statement to insert reservation data
        $reservationStmt = $pdo->prepare('INSERT INTO reservations (eventID, time, pupilID, reservationNumber) VALUES (?, ?, ?, ?)');

        // Bind the reservation data to the prepared statement
        $reservationStmt->bindParam(1, $eventId);
        $reservationStmt->bindParam(2, $slotTime);
        $reservationStmt->bindParam(3, $pupilId);
        $reservationStmt->bindParam(4, $newReservationNumber);

        // Execute the reservation prepared statement
        $reservationStmt->execute();

        // Close the database connection
        $pdo = null;

        // Redirect to the success page or any other desired page
        header('Location: message.html');
        include 'phpmailer.php';
        exit();
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }
}
?>
