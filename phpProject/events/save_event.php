<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $eventName = $_POST['eventName'];
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endDate = $_POST['endDate'];
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
        $stmt = $pdo->prepare('INSERT INTO events (eventName, startDate, startTime, endDate, endTime, bookingPeriod, eventOpen) VALUES (?, ?, ?, ?, ?, ?, ?)');

        // Bind the form data to the prepared statement
        $stmt->bindParam(1, $eventName);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $startTime);
        $stmt->bindParam(4, $endDate);
        $stmt->bindParam(5, $endTime);
        $stmt->bindParam(6, $bookingPeriod);
        $stmt->bindParam(7, $eventOpen);

        // Execute the prepared statement
        $stmt->execute();

        // Redirect to a certain HTML page
    header('Location: event_list.php');
    exit(); // Ensure no further code execution
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
}
?>
