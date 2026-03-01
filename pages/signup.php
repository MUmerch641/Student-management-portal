<?php
// Signup Page
include "middleware/guest.php";  // <-- middleware: logged in users can't access

$error = isset($_SESSION["signup_error"]) ? $_SESSION["signup_error"] : "";
unset($_SESSION["signup_error"]);
?>

<div class="box">
    <h1>Sign Up</h1>

    <?php if ($error != "") { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="index.php?page=signup">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="index.php?page=login">Login</a></p>
</div>
