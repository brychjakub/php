<?php
include_once 'db_connect.php';

try {
    // SQL statement to create a table
    $sql = "CREATE TABLE Users (
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL
    )";

    // Use exec() because no results are returned
    $pdo->exec($sql);
    echo "Table Users created successfully";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$pdo = null;
?>
