<?php
// Database configuration
$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = '';  // Your database password
$dbName     = 'first_db';  // Your database name

$search = $_GET['search'] ?? '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement
    $query = 'SELECT * FROM pupils';
    $params = [];

    if ($search !== '') {
        $query .= ' WHERE firstname LIKE ? OR lastname LIKE ?';
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    $stmt = $pdo->prepare($query);

    // Execute the prepared statement
    $stmt->execute($params);

    // Fetch all pupils as an associative array
    $pupils = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Pupils List</title>
    <link rel="stylesheet" href="../styles.css">
</head>


    <?php include '../sidebar_user.php'; ?>
   
    <body class="container">
    <header>

<div class="search-container">
    <form method="get" action="">
        <input type="text" name="search" value="<?= htmlentities($search) ?>" placeholder="Zadejte jméno">
        <button type="submit">hledat
        </button>
    </form>
</div>
</header>



    <h2>Všechny registrace</h2>
    <div class="reservation-container">
        <?php if (!empty($pupils)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Jméno</th>
                       
                        <th>Kdy</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($pupils as $pupil) : ?>
                        <tr>
                        <td><?php echo substr($pupil['firstname'], 0, 1) . '.' . ' ' . $pupil['lastname'];; ?></td>
                          
                            <td><?php echo $pupil['note'] . ' ' . $pupil['eventDate']; ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No pupils found.</p>
        <?php endif; ?>
    </div>
     <footer>
        <?php include '../footer.php'; ?>
    </footer>
</body>
</html>
