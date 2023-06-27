<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Event Reservation</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body class="container">
    <h1>Event Reservation</h1>

    <?php
    // Retrieve the event details from the database
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

        // Retrieve the event information
        $stmt = $pdo->query('SELECT * FROM events');
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the event exists and there are open positions
        if ($event && $event['openPositions'] > 0) {
            $openPositions = $event['openPositions'];

            // Display the available positions
            echo '<h2>Available Positions: ' . $openPositions . '</h2>';

            // Check if the user clicked the reservation button
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservePosition'])) {
                // Perform the reservation process here
                // Update the database, handle the reservation logic, etc.
                // ...

                // Decrease the open positions count by 1
                $openPositions--;

                // Update the event information in the database
                $stmt = $pdo->prepare('UPDATE events SET openPositions = ?');
                $stmt->bindParam(1, $openPositions);
                $stmt->execute();

                echo '<p>Reservation Successful! You have reserved a position.</p>';
            } else {
                // Display the reservation form
                echo '<form action="" method="POST">';
                echo '<input type="submit" name="reservePosition" value="Reserve Position">';
                echo '</form>';
            }
        } else {
            echo '<p>No available positions at the moment. Please check again later.</p>';
        }

        // Close the database connection
        $pdo = null;
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }
    ?>

    <p><a href="event_list.php">Back to Event List</a></p>
</body>
</html>
