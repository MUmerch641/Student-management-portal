<?php
$file = 'data/students.json';
$students = [];
if (file_exists($file)) {
    $data = file_get_contents($file);
    $students = json_decode($data, true) ?: [];
}

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>

<div class="box wide">
    <div class="portal-header">
        <h1>Student Portal</h1>
        <a href="index.php?page=student_add" class="logout-btn btn-sm" style="margin-top:0; background:#2ecc71;">+ Add Student</a>
    </div>

    <?php if ($msg == 'added'): ?>
        <div class="success">Student added successfully!</div>
    <?php elseif ($msg == 'updated'): ?>
        <div class="success">Student updated successfully!</div>
    <?php elseif ($msg == 'deleted'): ?>
        <div class="success">Student deleted successfully!</div>
    <?php endif; ?>

    <?php if (count($students) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['id']); ?></td>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <td><?php echo htmlspecialchars($student['course']); ?></td>
                        <td>
                            <div class="actions">
                                <a href="index.php?page=student_edit&id=<?php echo $student['id']; ?>" class="logout-btn btn-sm btn-warning" style="margin-top:0;">Edit</a>
                                <a href="index.php?page=student_delete&id=<?php echo $student['id']; ?>" class="logout-btn btn-sm btn-danger" style="margin-top:0;" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No students found. Add a student to get started.</p>
    <?php endif; ?>

    <div style="text-align:center; margin-top:20px;">
        <a href="index.php?page=dashboard" class="logout-btn btn-secondary">Back to Dashboard</a>
    </div>
</div>
