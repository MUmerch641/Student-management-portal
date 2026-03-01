<?php
$file = 'data/students.json';
$students = [];
if (file_exists($file)) {
    $students = json_decode(file_get_contents($file), true) ?: [];
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$student = null;
$student_index = -1;

foreach ($students as $index => $s) {
    if ($s['id'] == $id) {
        $student = $s;
        $student_index = $index;
        break;
    }
}

$error = isset($_SESSION["edit_error"]) ? $_SESSION["edit_error"] : "";
unset($_SESSION["edit_error"]);
?>

<div class="box">
    <h1>Edit Student</h1>
    
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=student_edit&id=<?php echo $id; ?>">
        <label>Full Name</label>
        <input type="text" name="name" required value="<?php echo htmlspecialchars($student['name']); ?>">

        <label>Email Address</label>
        <input type="email" name="email" required value="<?php echo htmlspecialchars($student['email']); ?>">

        <label>Course</label>
        <input type="text" name="course" required value="<?php echo htmlspecialchars($student['course']); ?>">

        <button type="submit" style="background: #f39c12;">Update Student</button>
        <a href="index.php?page=students" class="logout-btn btn-secondary" style="display:block; text-align:center; margin-top:10px;">Cancel</a>
    </form>
</div>
