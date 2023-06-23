<?php
include_once 'db_connect.php';

try {
    // Check if the users table exists
    $stmt = $pdo->query("SELECT 1 FROM users LIMIT 1");

    if ($stmt === false) {
        // Table doesn't exist, create the users table
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";

        $pdo->exec($sql);
        echo "Table 'users' created successfully!";
    }

    // Check if the user 'kuba' already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => 'admin']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // User doesn't exist, insert the new user record
        $username = 'admin';
        $password = '';

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user record into the table
        $insertStmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $insertStmt->execute(['username' => $username, 'password' => $hashedPassword]);

        echo "User 'kuba' created successfully!";
    } else {
        echo "User 'kuba' already exists!";
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

$pdo = null;
?>
