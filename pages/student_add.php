<?php
$error = isset($_SESSION["add_error"]) ? $_SESSION["add_error"] : "";
unset($_SESSION["add_error"]);
?>

<div class="box">
    <h1>Add Student</h1>
    
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=student_add">
        <label>Full Name</label>
        <input type="text" name="name" required placeholder="John Doe">

        <label>Email Address</label>
        <input type="email" name="email" required placeholder="john@example.com">

        <label>Course</label>
        <input type="text" name="course" required placeholder="Computer Science">

        <button type="submit">Add Student</button>
        <a href="index.php?page=students" class="logout-btn btn-secondary" style="display:block; text-align:center; margin-top:10px;">Cancel</a>
    </form>
</div>
