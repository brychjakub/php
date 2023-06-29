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

    $stmt = $pdo->prepare('SELECT openPositions, startTime, endTime, bookingPeriod FROM events WHERE id = ?');
    $stmt->bindParam(1, $eventId);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        $openPositions = $event['openPositions'];

        // Generate reservation slots based on the number of open positions
        $startTime = strtotime($event['startTime']);
        $endTime = strtotime($event['endTime']);
        $bookingPeriod = $event['bookingPeriod'];

        $slots = array();
        $currentTime = $startTime;

        while ($currentTime < $endTime && count($slots) < $openPositions) {
            $slotTime = date('H:i', $currentTime);
            $slots[] = array(
                'time' => $slotTime,
                'name' => '',
                'birthdate' => '',
                'address' => ''
            );

            $currentTime = strtotime("+$bookingPeriod minutes", $currentTime);
        }

        // Handle form submission for each slot
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($slots as &$slot) {
                $slot['name'] = $_POST['name_' . $slot['time']];
                $slot['birthdate'] = $_POST['birthdate_' . $slot['time']];
                $slot['address'] = $_POST['address_' . $slot['time']];
            }
        }

        // Display the event details and reservation slots
        echo '<h2>Event Details</h2>';
        echo 'Event ID: ' . $eventId . '<br>';
        echo 'Start Time: ' . $event['startTime'] . '<br>';
        echo 'End Time: ' . $event['endTime'] . '<br>';
        echo 'Booking Period: ' . $event['bookingPeriod'] . ' minutes<br>';
        echo 'Open Positions: ' . $event['openPositions'] . '<br>';

        echo '<h2>Reservation Slots</h2>';
        echo '<form action="event_details.php?eventId=' . $eventId . '" method="post">';
        echo '<table>';
        echo '<tr><th>Time</th><th>Name</th><th>Birthdate</th><th>Address</th></tr>';
        foreach ($slots as $slot) {
            echo '<tr>';
            echo '<td>' . $slot['time'] . '</td>';
            echo '<td><input type="text" name="name_' . $slot['time'] . '" value="' . $slot['name'] . '"></td>';
            echo '<td><input type="text" name="birthdate_' . $slot['time'] . '" value="' . $slot['birthdate'] . '"></td>';
            echo '<td><input type="text" name="address_' . $slot['time'] . '" value="' . $slot['address'] . '"></td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '<input type="submit" value="Submit">';
        echo '</form>';
    } else {
        echo 'Event not found.';
    }

    // Close the database connection
    $pdo = null;
} catch (PDOException $e) {
    // Display error message
    echo 'Error: ' . $e->getMessage();
}
?>
