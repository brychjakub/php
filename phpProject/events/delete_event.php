<?php
// ...

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $eventId = $_GET['delete'];

    include_once '../php/db_connect.php';


    try {
        // Prepare the SQL statement to delete the event
        $stmt = $pdo->prepare('DELETE FROM events WHERE id = ?');

        // Bind the event ID to the prepared statement
        $stmt->bindParam(1, $eventId);

        // Execute the prepared statement
        $stmt->execute();

        // Redirect to the event list page after deletion
        header('Location: event_list.php');
        exit();
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
}
?>
