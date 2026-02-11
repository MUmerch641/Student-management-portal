<?php
// Login Page
include "middleware/guest.php";  // <-- middleware: logged in users can't access

$error = "";
$success = "";

if (isset($_GET["success"])) {
    $success = "Account created! Please login.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST["email"];
    $password = $_POST["password"];

    if (file_exists("users.txt")) {
        $lines = file("users.txt");
        foreach ($lines as $line) {
            $data = explode("|", trim($line));
            if ($data[1] == $email && $data[2] == $password) {
                $_SESSION["user"] = $data[0];
                $_SESSION["email"] = $data[1];
                header("Location: index.php?page=dashboard");
                exit;
            }
        }
    }

    $error = "Wrong email or password!";
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
