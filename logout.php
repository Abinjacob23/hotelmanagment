<?php
session_start(); // Start the session

// Unset all of the session variables
$_SESSION = [];

// If you want to destroy the session entirely
session_destroy();

// Redirect to the login page or home page
header("Location: index.html");
exit();
?>
