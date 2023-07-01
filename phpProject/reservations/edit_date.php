<?php
// Check if the edit value and event ID are present in the URL
if (isset($_GET['edit']) && isset($_GET['eventID'])) {
    // Retrieve the edit value and event ID from the URL
    $editValue = $_GET['edit'];
    $eventID = $_GET['eventID'];

    // Database configuration
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';  // Your database password
    $dbName = 'first_db';  // Your database name

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to update the event ID in the reservations table
        $stmt = $pdo->prepare('UPDATE reservations SET eventID = ? WHERE pupilID = ?');

        // Bind the parameters to the prepared statement
        $stmt->bindParam(1, $eventID);
        $stmt->bindParam(2, $editValue);

        // Execute the prepared statement
        $stmt->execute();

        // Close the database connection
        $pdo = null;

        // Redirect to the reservation admin page or a success page
        header('Location: reservation_admin.php');
        exit();
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Redirect to the reservation admin page
    echo $_GET['edit'];
    echo $_GET['eventID'];
    exit();
}
?>
