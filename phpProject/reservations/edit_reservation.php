<?php
if (empty($_GET['edit']) && empty($_POST['reservationIdToUpdate'])) {
    // Redirect to the reservation admin page
     header('Location: reservation_admin.php');
     exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Update the reservation details in the database
    $reservationIdToUpdate = $_POST['reservationIdToUpdate'];
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
    $eventDate = $_POST['eventDate'];
    

    // Database configuration
    $dbHost     = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';  // Your database password
    $dbName     = 'first_db';  // Your database name

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to update the reservation data
        $stmt = $pdo->prepare('UPDATE pupils SET firstname = ?, lastname = ?, childBirthDay = ?, childHomeAddressStreet = ?, childHomeAddressNumber = ?, childHomeAddressCity = ?, childHomeAddressPostcode = ?, legalRepresentativeFirstname = ?, legalRepresentativeSurname = ?, legalRepresentativeEmail = ?, legalRepresentativePhone = ?, legalRepresentativeHomeAddressStreet = ?, legalRepresentativeHomeAddressNumber = ?, legalRepresentativeHomeAddressCity = ?, legalRepresentativeHomeAddressPostcode = ?, note = ?, eventDate = ? WHERE id = ?');

        // Bind the parameters to the prepared statement
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
        $stmt->bindParam(17, $eventDate);
        $stmt->bindParam(18, $reservationIdToUpdate);

        // Execute the prepared statement
        $stmt->execute();

        // Retrieve the event ID based on the event date
        $eventDateFormatted = date('Y-m-d', strtotime($eventDate));
        $eventQuery = $pdo->prepare('SELECT id FROM events WHERE startDate = ?');
        $eventQuery->bindParam(1, $eventDateFormatted);
        $eventQuery->execute();
        $event = $eventQuery->fetch(PDO::FETCH_ASSOC);
        if ($event) {
            $eventId = $event['id'];
        
            // Update the event ID in the reservations table
            $updateStmt = $pdo->prepare('UPDATE reservations SET eventID = ? WHERE pupilID = ?');
            $updateStmt->bindParam(1, $eventId);
            $updateStmt->bindParam(2, $reservationIdToUpdate);
            $updateStmt->execute();
        } else {
            echo "No event found for the provided date.";
        }
        try {
            $updateStmt->execute();
        } catch (PDOException $e) {
            // Display error message
            echo 'Update Error: ' . $e->getMessage();
        }
        // Close the database connection
        $pdo = null;
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Redirect to the reservation admin page or a success page
     header('Location: reservation_admin.php');
     exit();
} else {
    // Retrieve the reservation details from the database based on the reservation ID
    $reservationId = $_GET['edit'];

    // Database configuration
    $dbHost     = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';  // Your database password
    $dbName     = 'first_db';  // Your database name

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to fetch the reservation details
        $stmt = $pdo->prepare('SELECT * FROM pupils WHERE id = ?');

        // Bind the reservation ID to the prepared statement
        $stmt->bindParam(1, $reservationId);

        // Execute the prepared statement
        $stmt->execute();

        // Fetch the reservation details
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            // Redirect to the reservation admin page
            header('Location: reservation_admin.php');
           exit();
        }

        // Close the database connection
        $pdo = null;
    } catch (PDOException $e) {
        // Display error message
        echo 'Error: ' . $e->getMessage();
    }

    // Assign the retrieved reservation details to variables
    $reservationId = $reservation['id'];
    $firstname = $reservation['firstname'];
    $lastname = $reservation['lastname'];
    $childBirthDay = $reservation['childBirthDay'];
    $childHomeAddressStreet = $reservation['childHomeAddressStreet'];
    $childHomeAddressNumber = $reservation['childHomeAddressNumber'];
    $childHomeAddressCity = $reservation['childHomeAddressCity'];
    $childHomeAddressPostcode = $reservation['childHomeAddressPostcode'];
    $legalRepresentativeFirstname = $reservation['legalRepresentativeFirstname'];
    $legalRepresentativeSurname = $reservation['legalRepresentativeSurname'];
    $legalRepresentativeEmail = $reservation['legalRepresentativeEmail'];
    $legalRepresentativePhone = $reservation['legalRepresentativePhone'];
    $legalRepresentativeHomeAddressStreet = $reservation['legalRepresentativeHomeAddressStreet'];
    $legalRepresentativeHomeAddressNumber = $reservation['legalRepresentativeHomeAddressNumber'];
    $legalRepresentativeHomeAddressCity = $reservation['legalRepresentativeHomeAddressCity'];
    $legalRepresentativeHomeAddressPostcode = $reservation['legalRepresentativeHomeAddressPostcode'];
    $note = $reservation['note'];
    $eventDate = $reservation['eventDate'];
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="../styles.css">
    <script src="../questions/questions.js"></script>

</head>
<body class="container">
<?php include '../header.php'; ?>

    <?php include '../sidebar.php'; ?>
    <h2>Edit Reservation</h2>
    <form action="edit_reservation.php" method="post" id="reservation-edit-form-id">
    <h3>Podrobnosti dítěte</h3>

    <fieldset>

            <!-- Include your form fields here -->
            <div class="field-group">
                <label for="firstname">Jméno<span class="required">*</span></label>
                <input class="text" type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" required>
                <div class="description">Jméno (Dítě)</div>
            </div>

            <div class="field-group">
                <label for="lastname">Příjmení<span class="required">*</span></label>
                <input class="text" type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" required>
                <div class="description">Příjmení (Dítě)</div>
            </div>

            <div class="field-group">
                <label for="childBirthDay">Narození<span class="required">*</span></label>
                <input class="text" type="text" id="childBirthDay" name="childBirthDay" value="<?php echo $childBirthDay; ?>" required>
                <div class="description">Narození (Dítě). Datum je ve formátu dd.mm.rrrr</div>
            </div>

            <div class="field-group">
                <label for="childHomeAddressStreet">Ulice<span class="required">*</span></label>
                <input class="text" type="text" id="childHomeAddressStreet" name="childHomeAddressStreet" value="<?php echo $childHomeAddressStreet; ?>" required>
                <div class="description">Ulice (Dítě)</div>
            </div>

            <div class="field-group">
                <label for="childHomeAddressNumber">Orientační číslo<span class="required">*</span></label>
                <input class="text" type="text" id="childHomeAddressNumber" name="childHomeAddressNumber" value="<?php echo $childHomeAddressNumber; ?>" required>
                <div class="description">Orientační číslo (Dítě)</div>
            </div>

            <div class="field-group">
                <label for="childHomeAddressCity">Město<span class="required">*</span></label>
                <input class="text" type="text" id="childHomeAddressCity" name="childHomeAddressCity" value="<?php echo $childHomeAddressCity; ?>" required>
                <div class="description">Město (Dítě)</div>
            </div>

            <div class="field-group">
                <label for="childHomeAddressPostcode">PSČ<span class="required">*</span></label>
                <input class="text" type="text" id="childHomeAddressPostcode" name="childHomeAddressPostcode" value="<?php echo $childHomeAddressPostcode; ?>" required>
                <div class="description">PSČ (Dítě)</div>
            </div>
            </fieldset>

            <h3>Podrobnosti zákonného zástupce</h3>
            <fieldset class="group">
                <legend><span>Shodné bydliště</span></legend>
                <div class="checkbox">
                    <input class="checkbox" type="checkbox" name="sameAddress" id="sameAddress" onclick="copyChildAddress()">
                    <label for="sameAddress">&nbsp;</label>
                </div>
                <div class="description">Zákonný zástupce má shodné bydliště jako dítě</div>
            </fieldset>

            <fieldset>
                <div class="field-group">
                    <label for="legalRepresentativeFirstname">Jméno<span class="required">*</span></label>
                    <input class="text" type="text" id="legalRepresentativeFirstname" name="legalRepresentativeFirstname" value="<?php echo $legalRepresentativeFirstname; ?>" required>
                    <div class="description">Jméno (Zákonný zástupce)</div>
                </div>

                <div class="field-group">
                    <label for="legalRepresentativeSurname">Příjmení<span class="required">*</span></label>
                    <input class="text" type="text" id="legalRepresentativeSurname" name="legalRepresentativeSurname" value="<?php echo $legalRepresentativeSurname; ?>" required>
                    <div class="description">Příjmení (Zákonný zástupce)</div>
                </div>

                <div class="field-group">
                    <label for="legalRepresentativeEmail">E-mail<span class="required">*</span></label>
                    <input class="text" type="text" id="legalRepresentativeEmail" name="legalRepresentativeEmail" value="<?php echo $legalRepresentativeEmail; ?>" required>
                    <div class="description">E-mail (Zákonný zástupce)</div>
                </div>

                <div class="field-group">
                    <label for="legalRepresentativePhone">Telefon<span class="required">*</span></label>
                    <input class="text" type="text" id="legalRepresentativePhone" name="legalRepresentativePhone" value="<?php echo $legalRepresentativePhone; ?>" required>
                    <div class="description">Telefon (Zákonný zástupce)</div>
                </div>

                <div class="field-group">
                    <label for="legalRepresentativeHomeAddressStreet">Ulice<span class="required">*</span></label>
                    <input class="text" type="text" id="legalRepresentativeHomeAddressStreet" name="legalRepresentativeHomeAddressStreet" value="<?php echo $legalRepresentativeHomeAddressStreet; ?>" required>
                    <div class="description">Ulice (Zákonný zástupce)</div>
                </div>

                <div class="field-group">
                    <label for="legalRepresentativeHomeAddressNumber">Orientační číslo<span class="required">*</span></label>
                    <input class="text" type="text" id="legalRepresentativeHomeAddressNumber" name="legalRepresentativeHomeAddressNumber" value="<?php echo $legalRepresentativeHomeAddressNumber; ?>" required>
                    <div class="description">Orientační číslo (Zákonný zástupce)</div>
                </div>

                <div class="field-group">
                    <label for="legalRepresentativeHomeAddressCity">Město<span class="required">*</span></label>
                    <input class="text" type="text" id="legalRepresentativeHomeAddressCity" name="legalRepresentativeHomeAddressCity" value="<?php echo $legalRepresentativeHomeAddressCity; ?>" required>
                    <div class="description">Město (Zákonný zástupce)</div>
                </div>

                <div class="field-group">
                    <label for="legalRepresentativeHomeAddressPostcode">PSČ<span class="required">*</span></label>
                    <input class="text" type="text" id="legalRepresentativeHomeAddressPostcode" name="legalRepresentativeHomeAddressPostcode" value="<?php echo $legalRepresentativeHomeAddressPostcode; ?>" required>
                    <div class="description">PSČ (Zákonný zástupce)</div>
                </div>

                
                <div class="field-group">
                            <label for="note">Čas rezervace</label>
                            <?php
                        if (isset($_GET['slotTime'])) {
                            $slotTime = $_GET['slotTime'];
                        } else {
                            $slotTime = '';
                        }
                        ?>

                            <input class="text" type="text" name="note" readonly value="<?php echo $slotTime ? $slotTime : $note; ?>">
                            
                </div>
               <div class="field-group">
<label for="eventDate">Datum rezervace</label>
<textarea class="textarea" id="eventDate" name="eventDate" readonly><?php echo isset($_GET['startDate']) ? date('d.m.Y', strtotime($_GET['startDate'])) : ''; ?></textarea>
</div>
<a href="edit_time.php?edit=<?php echo $reservation['id']; ?>">
                            <span class="icon-edit">změnit čas a datum</span>
                            </a>
            </fieldset>
            <input type="hidden" name="reservationIdToUpdate" value="<?php echo $reservationId; ?>">
        <div class="buttons-container">
            <div class="buttons">
                <input type="submit" value="Uložit">
                <a href="reservation_admin.php">Zrušit</a>
            </div>
        </div>
    </form>
    <footer>
        <?php include '../footer.php'; ?>
    </footer>
</body>
</html>