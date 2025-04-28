<?php
// Start session
session_start();

// Check if user is already logged in
if (isset($_SESSION['level']) && $_SESSION['level'] != "") {
    // If logged in, redirect to appropriate dashboard
    header("Location: dashboard/index.php");
    exit();
} else {
    // If not logged in, redirect to login page
    header("Location: auth/index.php");
    exit();
}
?>