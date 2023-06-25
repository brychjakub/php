<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and perform necessary validation
    // ...

    // Update the event details in the database
    $eventIdToUpdate = $_POST['eventIdToUpdate'];
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

        // Prepare the SQL statement to update the event data
        $stmt = $pdo->prepare('UPDATE events SET eventName = ?, startDate = ?, startTime = ?, endDate = ?, endTime = ?, bookingPeriod = ?, eventOpen = ? WHERE id = ?');

        // Bind the parameters to the prepared statement
        $stmt->bindParam(1, $eventName);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $startTime);
        $stmt->bindParam(4, $endDate);
        $stmt->bindParam(5, $endTime);
        $stmt->bindParam(6, $bookingPeriod);
        $stmt->bindParam(7, $eventOpen);
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
    $endDate = $event['endDate'];
    $endTime = $event['endTime'];
    $bookingPeriod = $event['bookingPeriod'];
    $eventOpen = $event['eventOpen'];
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
    <form action="save_event.php" method="post" id="event-create-form-id">
        <fieldset>
            <div class="field-group">
                <label for="eventName">Jméno události<span class="required">*</span></label>
                <input type="text" id="eventName" name="eventName" value="<?php echo $eventName; ?>">
                <div class="description">Např. 'Zápis do 1.B', 'Třídní schůzky 6. června 2016', atd.</div>
            </div>
            <div class="field-group">
                <label for="startDate">Datum začátku<span class="required">*</span></label>
                <input type="date" id="startDate" name="startDate" value="<?php echo $startDate; ?>">
                <div class="description">Začátek nesmí být v minulosti. Datum je ve formátu mm/dd/rrrr (např. 12/21/2012).</div>
            </div>
            <div class="field-group">
                <label for="startTime">Čas začátku<span class="required">*</span></label>
                <input type="text" id="startTime" name="startTime" value="<?php echo $startTime; ?>">
            </div>
            <div class="field-group">
                <label for="endDate">Datum konce<span class="required">*</span></label>
                <input type="date" id="endDate" name="endDate" value="<?php echo $endDate; ?>">
                <div class="description">Datum konce. Datum je ve formátu mm/dd/rrrr (např. 12/21/2012)</div>
            </div>
            <div class="field-group">
                <label for="endTime">Čas konce<span class="required">*</span></label>
                <input type="text" id="endTime" name="endTime" value="<?php echo $endTime; ?>">
            </div>
            <div class="field-group">
                <label for="bookingPeriod">Interval<span class="required">*</span></label>
                <input type="text" id="bookingPeriod" name="bookingPeriod" value="<?php echo $bookingPeriod; ?>">
                <div class="description">Interval (v minutách) určující frekvenci rezervačních oken</div>
            </div>
            <fieldset class="group">
                <legend>Otevřeno</legend>
                <div class="checkbox">
                    <input type="checkbox" name="eventOpen" id="eventOpen" <?php echo $eventOpen ? 'checked' : ''; ?>>
                    <label for="eventOpen"></label>
                </div>
                <div class="description">Uzavřené události se nezobrazují uživatelům a nepovolují vytvářet další rezervace</div>
            </fieldset>

            <!-- Hidden input to store the old event ID -->
            <input type="hidden" name="eventIdToDelete" value="<?php echo $eventId; ?>">
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
