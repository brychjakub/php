<?php
session_start();

// Destroy the session and unset session variables
session_destroy();
$_SESSION = [];

// Redirect to the login page or any other desired location
header("Location: login.php");
exit();
?>
