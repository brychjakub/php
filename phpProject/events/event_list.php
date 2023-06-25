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
<body class="container">
    <div  class="sidebar">

    <ul>
        <li><a href="create_event.html">Vytvořit událost</a></li>
        <li><a href="event_list.php">Události</a></li>
        <li><a href="../questions/questions.html">Dotazník</a></li>
    </ul>
    </div>
    <section>
        <h2>Seznam událostí</h2>
        <table>
            <thead>
                <tr>
                    <th id="event-name">Název</th>
                    <th id="event-date">Vytvořeno</th>
                    <th id="event-edit">Úprava</th>
                    <th id="event-state">Stav</th>
                    <th id="event-delete">Smazat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td headers="event-name"><a href="/admin/event/<?php echo $event['id']; ?>/overview/view"><?php echo $event['eventName']; ?></a></td>
                        <td headers="event-date"><?php echo $event['startDate']; ?> - <?php echo $event['endDate']; ?></td>
                        
                        <td headers="event-edit">
                            <a href="edit_event.php?edit=<?php echo $event['id']; ?>/view">
                                <span class="icon-edit">✏️</span>
                            </a>
                        </td>
                        <td headers="event-state">
                            <?php echo ($event['eventOpen'] ? 'Otevřeno' : 'Uzavřeno'); ?>
                        </td>
                        <td headers="event-delete">
                            <a href="delete_event.php?delete=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?');">
                                <span class="icon-delete">🗑️</span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <!-- ... Rest of your HTML code ... -->
</body>
</html>
