<?php
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
            // Authentication successful, redirect to the desired page
            header('Location: ../events/event_list.html');
            exit();
        } else {
            // Authentication failed, display an error message
            $errorMessage = 'Invalid username or password';
        }
    } catch (PDOException $e) {
        // Display error message
        $errorMessage = 'Database error: ' . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
}
?>

<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <?php if (isset($errorMessage)) : ?>
        <p><font color="red"><?php echo $errorMessage; ?></font></p>
    <?php endif; ?>

    <h3>Login with Username and Password</h3>
    <form action="login.php" method="POST">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" value=""></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td colspan="2"><input name="submit" type="submit" value="Login"></td>
            </tr>
        </table>
    </form>
</body>
</html>
