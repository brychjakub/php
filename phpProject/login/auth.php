<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to the login page
    header('Location: ../login/login.php');
    exit();
}

$_SESSION['last_activity'] = time();

?>


<script>
    var idleTime = 900; // 15 minutes (in seconds)
    var logoutUrl = '../login/logout.php'; // URL of the logout page

    function checkIdleTime() {
        var currentTime = new Date().getTime() / 1000; // Convert to seconds
        var lastActivity = <?php echo isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : 0; ?>;
        var elapsedTime = currentTime - lastActivity;

        if (elapsedTime > idleTime) {
            window.location.href = logoutUrl; // Redirect to logout page
        }
    }

    setInterval(checkIdleTime, 1000); // Check every second (adjust as needed)
</script>
