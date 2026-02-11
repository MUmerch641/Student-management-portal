<?php
// Logout - destroy session and go to login
session_destroy();
header("Location: index.php?page=login");
exit;
?>
