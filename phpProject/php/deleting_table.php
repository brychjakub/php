<?php
include_once 'db_connect.php';

try {
    // SQL statement to drop the users table
    $sql = "DROP TABLE IF EXISTS users";

    // Use exec() because no results are returned
    $pdo->exec($sql);
    echo "Table 'users' deleted successfully";
} catch(PDOException $e) {
    echo "Error deleting table: " . $e->getMessage();
}

$pdo = null;
?>