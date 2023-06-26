<?php

// Check if the form is submitted
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $stmt = $pdo->prepare('INSERT INTO pupils (firstname, lastname, childBirthDay, 
        childHomeAddressStreet, childHomeAddressNumber, childHomeAddressCity, 
        childHomeAddressPostcode, legalRepresentativeFirstname, legalRepresentativeSurname, legalRepresentativeEmail, legalRepresentativePhone, legalRepresentativeHomeAddressStreet, 
        legalRepresentativeHomeAddressNumber, legalRepresentativeHomeAddressCity, legalRepresentativeHomeAddressPostcode, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

        // Bind the form data to the prepared statement
        $stmt->bindParam(1, $firstname);
        $stmt->bindParam(2, $lastname);
        $stmt->bindParam(3, $childBirthDay);
        $stmt->bindParam(4, $childHomeAddressStreet);
        $stmt->bindParam(5, $childHomeAddressNumber);
        $stmt->bindParam(6, $childHomeAddressCity);
        $stmt->bindParam(7, $childHomeAddressPostcode);
        $stmt->bindParam(8, $legalRepresentativeFirstname);
        $stmt->bindParam(9, $legalRepresentativeSurname);
        $stmt->bindParam(10, $legalRepresentativeEmail);
        $stmt->bindParam(11, $legalRepresentativePhone);
        $stmt->bindParam(12, $legalRepresentativeHomeAddressStreet);
        $stmt->bindParam(13, $legalRepresentativeHomeAddressNumber);
        $stmt->bindParam(14, $legalRepresentativeHomeAddressCity);
        $stmt->bindParam(15, $legalRepresentativeHomeAddressPostcode);
        $stmt->bindParam(16, $note);


        // Execute the prepared statement
        $stmt->execute();

        // Display success message
        // Execute the prepared statement
$stmt->execute();
include 'phpmailer.php';

// Redirect to the message.html page
header("Location: message.html");
exit();
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
}
?>
