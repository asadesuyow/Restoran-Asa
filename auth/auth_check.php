<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['id_user']) || !isset($_SESSION['level'])) {
    header("Location: ../auth/index.php?pesan=tabrak");
    exit();
}

// Prevent caching of protected pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
?> 