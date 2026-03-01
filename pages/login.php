<?php
// Login Page
include "middleware/guest.php";  // <-- middleware: logged in users can't access

$error = isset($_SESSION["login_error"]) ? $_SESSION["login_error"] : "";
unset($_SESSION["login_error"]); // clear it after reading

$success = "";
if (isset($_GET["success"])) {
    $success = "Account created! Please login.";
}
?>

<div class="box">
    <h1>Login</h1>

    <?php if ($success != "") { ?>
        <p class="success"><?php echo $success; ?></p>
    <?php } ?>

    <?php if ($error != "") { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="index.php?page=login">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="index.php?page=signup">Sign Up</a></p>
</div>
