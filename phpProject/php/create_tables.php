<?php
include_once 'db_connect.php';

try {
    // SQL statement to create a table
    $sql = "CREATE TABLE Users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    // Use exec() because no results are returned
    $pdo->exec($sql);
    echo "Table Users created successfully";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$pdo = null;
?>
