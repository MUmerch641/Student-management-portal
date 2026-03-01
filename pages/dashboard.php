<!-- Dashboard Page (protected by auth middleware in index.php) -->
<div class="box" style="text-align:center;">
    <h1>Dashboard</h1>
    <p><b>Welcome,</b> <?php echo $_SESSION["user"]; ?>!</p>
    <p><b>Email:</b> <?php echo $_SESSION["email"]; ?></p>

    <a href="index.php?page=students" class="logout-btn" style="background: #3498db;">Manage Students</a>
    <a href="index.php?page=logout" class="logout-btn">Logout</a>
</div>
