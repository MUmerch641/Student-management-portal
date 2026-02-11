<?php
// Contact Form Page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST["name"];
    $email   = $_POST["email"];
    $message = $_POST["message"];
}
?>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
    <div class="box" style="text-align:center;">
        <h2>Form Submitted Successfully! ✅</h2>
        <p><b>Name:</b> <?php echo $name; ?></p>
        <p><b>Email:</b> <?php echo $email; ?></p>
        <p><b>Message:</b> <?php echo $message; ?></p>
        <br><a href="index.php">Go Back to Form</a>
    </div>
<?php } else { ?>
    <div class="box">
        <h1>Contact Us</h1>

        <form method="POST" action="index.php?page=contact">
            <label>Name:</label>
            <input type="text" name="name">

            <label>Email:</label>
            <input type="email" name="email">

            <label>Message:</label>
            <textarea name="message"></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>
<?php } ?>
