<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // User is already logged in, redirect to the desired page
    header('Location: ../events/event_list.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username and password
    $submittedUsername = $_POST['username'];
    $submittedPassword = $_POST['password'];

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

        // Prepare the SQL statement to fetch the user record
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $submittedUsername);
        $stmt->execute();

        // Fetch the user record
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($submittedPassword, $user['password'])) {
            // Authentication successful, set the user's session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to the desired page
            header('Location: ../events/event_list.php');
            exit();
        } else {
            // Authentication failed, display an error message
            $errorMessage = 'Špatné jméno nebo heslo.';
        }
    } catch (PDOException $e) {
        // Display error message
        $errorMessage = 'Database error: ' . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
        <?php include '../sidebar_user.php'; ?>

   
    <form action="login.php" method="POST">
        <table>
            <tr>
                <td>Jméno:</td>
                <td><input type="username" name="username" value=""></td>
            </tr>
            <tr>
                <td>Heslo:</td>
                <td><input type="password" name="password"></td>
            </tr>
            <div class="buttons">
            <td colspan="2" style="text-align: center;"><button name="submit" type="submit" value="Login">Přihlásit se</button></td>
            </div>        </table>
            <?php if (isset($errorMessage)) : ?>
        <p style="text-align: center; color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    </form>
</body>
</html>
