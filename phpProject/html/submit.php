<?php

// Check if the form is submitted
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

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
        $stmt = $pdo->prepare('INSERT INTO users (firstname, lastname) VALUES (?, ?)');

        // Bind the form data to the prepared statement
        $stmt->bindParam(1, $firstname);
        $stmt->bindParam(2, $lastname);

        // Execute the prepared statement
        $stmt->execute();

        // Display success message
        echo 'Data saved successfully!';
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
}
?>
