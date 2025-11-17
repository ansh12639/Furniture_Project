<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

header("Location: http://localhost/furniture_Project/"); // Redirect to login page
exit();
?>
