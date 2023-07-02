<?php include '../login/auth.php'; ?>

<?php
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

    // Prepare the SQL statement to fetch events
    $stmt = $pdo->prepare('SELECT * FROM events');

    // Execute the prepared statement
    $stmt->execute();

    // Fetch all events
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Display error message
    echo 'Error: ' . $e->getMessage();
}

// Close the database connection
$pdo = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rezervace CMcZŠ</title>
    <link rel="stylesheet" href="../styles.css">
    
    
</head>
<body>

<?php include '../sidebar.php'; ?>

        <div class="reservation-container">
        <h2>Všechny akce, tu vaši vyberete kliknutím na název</h2>
            <table>
                <thead>
                    <tr>
                        <th>Název</th>
                        <th>Kdy</th>
                        <th>Úprava</th>
                        <th>Smazat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                        <td><a href="event_details.php?eventId=<?php echo $event['id']; ?>"><?php echo $event['eventName']; ?></a></td>
        <td><?php echo date('d.m.Y', strtotime($event['startDate'])); ?> , <?php echo date('H:i', strtotime($event['startTime'])); ?> - <?php echo date('H:i', strtotime($event['endTime'])); ?></td>
        <td>
            <a href="edit_event.php?edit=<?php echo $event['id']; ?>">
                <span class="icon-edit">✏️</span>
            </a>
        </td>
       
        <td>
            <a href="delete_event.php?delete=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?');">
                <span class="icon-delete">🗑️</span>
            </a>
        </td>
    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        <?php include '../footer.php'; ?>
    </footer>
</body>
</html>
