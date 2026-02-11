<?php
// =========================================
// GUEST MIDDLEWARE - Only for non-logged-in users
// =========================================
// If user IS logged in, redirect to dashboard
if (isset($_SESSION["user"])) {
    header("Location: index.php?page=dashboard");
    exit;
}
?>
