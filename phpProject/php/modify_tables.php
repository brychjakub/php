<?php
include_once 'db_connect.php';

try {
    // SQL statement to add a new column
    $sql = "ALTER TABLE Users DROP COLUMN email VARCHAR(50)";

    // Use exec() because no results are returned
    $pdo->exec($sql);
    echo "Table Users modified successfully";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$pdo = null;
?>
