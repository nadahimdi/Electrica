<?php
// Start the session
session_start();

// Destroy the session data
session_destroy();

// Redirect to the home page after logout
header("Location: Home.php");
exit();
?>
