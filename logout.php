<?php
session_start(); // Start the session

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the home page or login page after logout
header("Location: index.php");  // You can change this to 'login.php' if you want to redirect to the login page
exit();  // Ensures the script stops after the redirect
?>
