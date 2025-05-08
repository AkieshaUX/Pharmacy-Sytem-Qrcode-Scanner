<?php
session_start();

// Destroy the session
if (isset($_SESSION['admin_id'])) {
    $_SESSION = array();
    session_destroy();
}

// Send HTTP headers to prevent browser cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to index.php after logout
header("Location: ../index.php");
exit();
?>
