<?php
// =========================================
// AUTH MIDDLEWARE - Checks if user is logged in
// =========================================
// If user is NOT logged in, redirect to login page
if (!isset($_SESSION["user"])) {
    header("Location: index.php?page=login");
    exit;
}
?>
