<?php
// Check if the user is logged out
if (isset($_GET['logout'])) {
    echo "<p><font color='green'>You have been logged out</font></p>";
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the username and password (you can replace this with your own validation logic)
    if ($username === 'admin' && $password === 'password') {
        // Redirect to the success page
        header("Location: success.php");
        exit();
    } else {
        // Display error message
        echo "<p><font color='red'>Invalid username or password</font></p>";
    }
}
?>

<html>
<head>
    <title>Login Page</title>
</head>
<body onload="document.f.username.focus();">
    <h3>Login with Username and Password</h3>
    <form name="f" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <table>
            <tr>
                <td>User:</td>
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
