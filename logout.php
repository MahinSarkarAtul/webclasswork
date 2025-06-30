<?php
session_start();

// Clear all session data
$_SESSION = array();
session_destroy();

// Prevent caching of this page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page after logout
header("Location: index.php");
exit();
?>
