<?php
session_start();

// Destroy all session data
$_SESSION = array();
session_destroy();

// Redirect to login page or homepage after logout
header("Location: index.php");
exit();
