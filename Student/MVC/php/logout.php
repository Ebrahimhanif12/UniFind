<?php
session_start();

// 1. Remove all session variables (User ID, Name, Role, etc.)
session_unset();

// 2. Destroy the session itself
session_destroy();

// 3. Redirect to the Login Page
header("Location: ../html/login.php");
exit();
?>