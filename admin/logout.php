<?php
session_start();

// Remove only specific session variables
unset($_SESSION['user_id']);
unset($_SESSION['username']);

// Optional: regenerate session ID for security
session_regenerate_id(true);

header("Location: login.php");
exit();
?>