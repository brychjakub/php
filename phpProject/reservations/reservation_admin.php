<?php
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

    // Prepare the SQL statement
    $stmt = $pdo->prepare('SELECT * FROM pupils');

    // Execute the prepared statement
    $stmt->execute();

    // Fetch all reservations as an associative array
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Reservations List</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        .edit-link,
        .delete-link {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f2f2f2;
            color: #333;
            text-decoration: none;
            border-radius: 3px;
        }
        .delete-link {
            margin-left: 5px;
            background-color: #ffcccc;
        }
    </style>
</head>
<body class="container">
    <h2>Reservations List</h2>
    <?php if (!empty($reservations)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Child Birthday</th>
                    <th>Child Address</th>
                    <th>Legal Representative</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) : ?>
                    <tr>
                        <td><?php echo $reservation['firstname']; ?></td>
                        <td><?php echo $reservation['lastname']; ?></td>
                        <td><?php echo $reservation['childBirthDay']; ?></td>
                        <td><?php echo $reservation['childHomeAddressStreet'] . ' ' . $reservation['childHomeAddressNumber'] . ', ' . $reservation['childHomeAddressCity'] . ' ' . $reservation['childHomeAddressPostcode']; ?></td>
                        <td><?php echo $reservation['legalRepresentativeFirstname'] . ' ' . $reservation['legalRepresentativeSurname']; ?></td>
                        <td><?php echo $reservation['legalRepresentativeEmail']; ?></td>
                        <td><?php echo $reservation['legalRepresentativePhone']; ?></td>
                        <td><?php echo $reservation['note']; ?></td>
                        <td>
                            <a href="edit_reservation.php?edit=<?php echo $reservation['id']; ?>">
                            <span class="icon-edit">✏️</span>
                            </a>
                            <a href="delete_reservation.php?delete=<?php echo $reservation['id']; ?>" onclick="return confirm('Are you sure you want to delete this reservation?');">
    <span class="icon-delete">🗑️</span>
</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No reservations found.</p>
    <?php endif; ?>
</body>
</html>
