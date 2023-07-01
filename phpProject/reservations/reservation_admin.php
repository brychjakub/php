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
<body class="container">

    <?php include '../sidebar.php'; ?>
   
<header>
 <div class="search-container">
    <form method="get" action="">
        <input type="text" name="search" value="<?= htmlentities($search) ?>" placeholder="Zadejte jméno">
        <button type="submit">Hledat</button>
    </form>
</div> 
</header>


    <h2>Všichni žáci</h2>

    <div class="page-container">
        <?php if (!empty($pupils)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Jméno</th>
                        <th>Příjmení</th>
                        <th>Datum narození</th>
                        <th>Adresa</th>
                        <th>Zákonný zástupce</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Kdy</th>
                        <th>Úpravy</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pupils as $pupil) : ?>
                        <tr>
                            <td><?php echo $pupil['firstname']; ?></td>
                            <td><?php echo $pupil['lastname']; ?></td>
                            <td><?php echo $pupil['childBirthDay']; ?></td>
                            <td><?php echo $pupil['childHomeAddressStreet'] . ' ' . $pupil['childHomeAddressNumber'] . ', ' . $pupil['childHomeAddressCity'] . ' ' . $pupil['childHomeAddressPostcode']; ?></td>
                            <td><?php echo $pupil['legalRepresentativeFirstname'] . ' ' . $pupil['legalRepresentativeSurname']; ?></td>
                            <td><?php echo $pupil['legalRepresentativeEmail']; ?></td>
                            <td><?php echo $pupil['legalRepresentativePhone']; ?></td>
                            <td><?php echo $pupil['note'] . ' ' . $pupil['eventDate']; ?></td>
                            <td>
                                <a href="edit_reservation.php?edit=<?php echo $pupil['id'] . '&startDate=' . $pupil['eventDate']; ?>">
                                    <span class="icon-edit">✏️</span>
                                </a>
                                <a href="delete_reservation.php?delete=<?php echo $pupil['id']; ?>" onclick="return confirm('Are you sure you want to delete this pupil?');">
                                    <span class="icon-delete">🗑️</span>
                                </a>
                            </td>
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
