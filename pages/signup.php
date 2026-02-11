<?php
// Signup Page
include "middleware/guest.php";  // <-- middleware: logged in users can't access

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST["name"];
    $email    = $_POST["email"];
    $password = $_POST["password"];

    if (file_exists("users.txt")) {
        $lines = file("users.txt");
        foreach ($lines as $line) {
            $data = explode("|", trim($line));
            if ($data[1] == $email) {
                $error = "This email is already registered!";
            }
        }
    }

    if ($error == "") {
        $user = $name . "|" . $email . "|" . $password . "\n";
        file_put_contents("users.txt", $user, FILE_APPEND);
        header("Location: index.php?page=login&success=1");
        exit;
    }
}
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
