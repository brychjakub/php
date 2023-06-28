<?php
if (empty($_GET['edit']) && empty($_POST['eventIdToUpdate'])) {
    // Redirect to the event list page
    header('Location: event_list.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Update the event details in the database
    $eventIdToUpdate = $_POST['eventIdToUpdate'];
    $eventName = $_POST['eventName'];
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $bookingPeriod = $_POST['bookingPeriod'];
    $eventOpen = isset($_POST['eventOpen']) ? 1 : 0;
    
    // Count the open positions based on start time, end time, and booking period
    $openPositions = calculateOpenPositions($startTime, $endTime, $bookingPeriod);
    
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

        // Prepare the SQL statement to update the event data
        $stmt = $pdo->prepare('UPDATE events SET eventName = ?, startDate = ?, startTime = ?, endTime = ?, bookingPeriod = ?, eventOpen = ?, openPositions = ? WHERE id = ?');

        // Bind the parameters to the prepared statement
        $stmt->bindParam(1, $eventName);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $startTime);
        $stmt->bindParam(4, $endTime);
        $stmt->bindParam(5, $bookingPeriod);
        $stmt->bindParam(6, $eventOpen);
        $stmt->bindParam(7, $openPositions);
        $stmt->bindParam(8, $eventIdToUpdate);

        // Execute the prepared statement
        $stmt->execute();

        // Close the database connection
        $pdo = null;
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Redirect to the event list page or a success page
    header('Location: event_list.php');
    exit();
} else {
    // Retrieve the event details from the database based on the event ID
    $eventId = $_GET['edit'];

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

        // Prepare the SQL statement to fetch the event details
        $stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?');

        // Bind the event ID to the prepared statement
        $stmt->bindParam(1, $eventId);

        // Execute the prepared statement
        $stmt->execute();

        // Fetch the event details
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            // Redirect to the event list page
            header('Location: event_list.php');
            exit();
        }

        // Close the database connection
        $pdo = null;
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Assign the retrieved event details to variables
    $eventId = $event['id'];
    $eventName = $event['eventName'];
    $startDate = $event['startDate'];
    $startTime = $event['startTime'];
    $endTime = $event['endTime'];
    $bookingPeriod = $event['bookingPeriod'];
    $eventOpen = $event['eventOpen'];
}

/**
 * Calculate the number of open positions based on start time, end time, and booking period.
 * 
 * @param string $startTime The start time of the event in the format hh:mm
 * @param string $endTime The end time of the event in the format hh:mm
 * @param int $bookingPeriod The booking period in minutes
 * @return int The number of open positions
 */
function calculateOpenPositions($startTime, $endTime, $bookingPeriod) {
    $start = strtotime($startTime);
    $end = strtotime($endTime);
    $interval = $bookingPeriod * 60; // Convert minutes to seconds

    $openPositions = 0;
    $current = $start;
    while ($current < $end) {
        $openPositions++;
        $current += $interval;
    }

    return $openPositions;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rezervace CMcZŠ</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body class="container">
    <div class="sidebar">
        <ul>
            <li><a href="create_event.html">Vytvořit událost</a></li>
            <li><a href="event_list.php">Události</a></li>
            <li><a href="../questions/questions.html">Dotazník</a></li>
        </ul>
    </div>
    <h2>Vytvoř novou událost</h2>
    <form action="edit_event.php" method="post" id="event-create-form-id">
        <fieldset>
            <div class="field-group">
                <label for="eventName">Jméno události</label>
                <input type="text" id="eventName" name="eventName" value="<?php echo $eventName; ?>" required>
                <div class="description">Např. 'Zápis do 1.B'.</div>
            </div>
            <div class="field-group">
                <label for="startDate">Datum začátku</label>
                <input type="date" id="startDate" name="startDate" value="<?php echo $startDate; ?>" required>
                <div class="description">Začátek nesmí být v minulosti. Datum je ve formátu mm/dd/rrrr (např. 12/21/2012).</div>
            </div>
            <div class="field-group">
                <label for="startTime">Čas začátku</label>
                <input type="text" id="startTime" name="startTime" value="<?php echo $startTime; ?>" required>
            </div>
            
            <div class="field-group">
                <label for="endTime">Čas konce</label>
                <input type="text" id="endTime" name="endTime" value="<?php echo $endTime; ?>" required>
            </div>
            <div class="field-group">
                <label for="bookingPeriod">Interval</label>
                <input type="text" id="bookingPeriod" name="bookingPeriod" pattern="\d+" value="<?php echo $bookingPeriod; ?>" required>
                <div class="description">Interval (v minutách) určující frekvenci rezervačních oken</div>
            </div>
            <fieldset class="group">
                <legend>Otevřeno pro veřejnost?</legend>
                <div class="checkbox">
                    <input type="checkbox" name="eventOpen" id="eventOpen" <?php echo $eventOpen ? 'checked' : ''; ?>>
                    <label for="eventOpen"></label>
                </div>
                <div class="description">Uzavřené události se nezobrazují uživatelům a nepovolují vytvářet další rezervace</div>
            </fieldset>

            <!-- Hidden input to store the old event ID -->
            <input type="hidden" name="eventIdToUpdate" value="<?php echo $eventId; ?>">
        </fieldset>
        <div class="buttons-container">
            <div class="buttons">
                <input type="submit" value="Uložit">
                <a href="event_list.php">Zrušit</a>
            </div>
        </div>
    </form>
</body>
</html>
