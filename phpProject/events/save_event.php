<?php include '../login/auth.php'; ?>


<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $eventName = $_POST['eventName'];
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $bookingPeriod = $_POST['bookingPeriod'];
    $eventOpen = isset($_POST['eventOpen']) ? 1 : 0;

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

        // Prepare the SQL statement
        $stmt = $pdo->prepare('INSERT INTO events (eventName, startDate, startTime, endTime, bookingPeriod, eventOpen, openPositions) VALUES (?, ?, ?, ?, ?, ?, ?)');

        // Calculate the open positions
        $startDateTime = new DateTime($startDate . ' ' . $startTime);
        $endDateTime = new DateTime($startDate . ' ' . $endTime);
        $interval = $startDateTime->diff($endDateTime);
        $totalMinutes = ($interval->h * 60) + $interval->i;
        $openPositions = floor($totalMinutes / $bookingPeriod);

        // Bind the form data and calculated open positions to the prepared statement
        $stmt->bindParam(1, $eventName);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $startTime);
        $stmt->bindParam(4, $endTime);
        $stmt->bindParam(5, $bookingPeriod);
        $stmt->bindParam(6, $eventOpen);
        $stmt->bindParam(7, $openPositions);

        // Execute the prepared statement
        $stmt->execute();

        // Redirect to a certain HTML page
      // After inserting the event into the database
$eventId = $pdo->lastInsertId();
header('Location: event_details.php?eventId=' . $eventId);
exit();
       // Ensure no further code execution
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
}
?>
