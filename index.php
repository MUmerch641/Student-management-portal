<?php
// =========================================
// SIMPLE ROUTER - All URLs come here first
// =========================================
session_start();

// Get page from URL — works with both /login AND ?page=login
$url = trim($_SERVER["REQUEST_URI"], "/");   // e.g. "login" or "index.php?page=login"
$url = explode("?", $url)[0];               // remove query string → "login" or "index.php"

if (isset($_GET["page"])) {
    $page = $_GET["page"];                   // ?page=login style
} elseif ($url != "" && $url != "index.php") {
    $page = $url;                            // /login style
} else {
    $page = "login";                       // default = login
}

// Logout doesn't need HTML
if ($page == "logout") {
    include "pages/logout.php";
    exit;
}

// Handle Form Submissions BEFORE HTML is rendered
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($page == "signup") {
        include "middleware/guest.php";
        $name     = $_POST["name"];
        $email    = $_POST["email"];
        $password = $_POST["password"];
        $error = "";

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
        } else {
            $_SESSION["signup_error"] = $error;
        }
    } elseif ($page == "login") {
        include "middleware/guest.php";
        $email    = $_POST["email"];
        $password = $_POST["password"];
        $error = "Wrong email or password!";

        if (file_exists("users.txt")) {
            $lines = file("users.txt");
            foreach ($lines as $line) {
                $data = explode("|", trim($line));
                if ($data[1] == $email && trim($data[2]) == $password) {
                    $_SESSION["user"] = $data[0];
                    $_SESSION["email"] = $data[1];
                    header("Location: index.php?page=dashboard");
                    exit;
                }
            }
        }
        $_SESSION["login_error"] = $error;
    } elseif ($page == "student_add") {
        include "middleware/auth.php";
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $course = trim($_POST["course"]);

        if (empty($name) || empty($email) || empty($course)) {
            $_SESSION["add_error"] = "All fields are required!";
        } else {
            $file = 'data/students.json';
            $students = file_exists($file) ? json_decode(file_get_contents($file), true) ?: [] : [];
            $newId = 1;
            if (count($students) > 0) {
                $last_student = end($students);
                $newId = $last_student['id'] + 1;
            }

            $students[] = [
                'id' => $newId,
                'name' => $name,
                'email' => $email,
                'course' => $course
            ];
            file_put_contents($file, json_encode($students, JSON_PRETTY_PRINT));
            header("Location: index.php?page=students&msg=added");
            exit;
        }
    } elseif ($page == "student_edit") {
        include "middleware/auth.php";
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $course = trim($_POST["course"]);

        if (empty($name) || empty($email) || empty($course)) {
            $_SESSION["edit_error"] = "All fields are required!";
        } else {
            $file = 'data/students.json';
            $students = file_exists($file) ? json_decode(file_get_contents($file), true) ?: [] : [];
            
            foreach ($students as $index => $s) {
                if ($s['id'] == $id) {
                    $students[$index]['name'] = $name;
                    $students[$index]['email'] = $email;
                    $students[$index]['course'] = $course;
                    break;
                }
            }
            file_put_contents($file, json_encode($students, JSON_PRETTY_PRINT));
            header("Location: index.php?page=students&msg=updated");
            exit;
        }
    }
}

// Handle GET-based purely logical redirects (like delete)
if ($page == "student_delete") {
    include "middleware/auth.php";
    $file = 'data/students.json';
    $students = file_exists($file) ? json_decode(file_get_contents($file), true) ?: [] : [];
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    $students = array_filter($students, function($s) use ($id) {
        return $s['id'] != $id;
    });
    
    file_put_contents($file, json_encode(array_values($students), JSON_PRETTY_PRINT));
    header("Location: index.php?page=students&msg=deleted");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My PHP App</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #eef2f7;
        .navbar {
            background: #2c3e50;
            padding: 15px 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            width: 100%;
        }
        .navbar a {
            color: #ecf0f1;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .navbar a:hover {
            background: #34495e;
            text-decoration: none;
        }
        .navbar .active {
            background: #3498db;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding-top: 60px; /* space for navbar */
        }
        .box {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
        }
        h2 { text-align: center; color: #333; margin-bottom: 15px; }
        label {
            font-weight: 600;
            color: #444;
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #3498db;
        }
        textarea { height: 100px; resize: vertical; }
        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: opacity 0.3s;
        }
        button:hover { background: #2980b9; }
        .error {
            background: #ffe0e0;
            color: #c0392b;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .success {
            background: #e0ffe0;
            color: #27ae60;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        p { text-align: center; margin-top: 18px; color: #666; font-size: 14px; }
        a { color: #3498db; font-weight: 600; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .logout-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 35px;
            background: #e74c3c;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }
        .logout-btn:hover { background: #c0392b; }
        .box.wide { width: 800px; max-width: 95%; }
        .portal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-sm { padding: 8px 15px; font-size: 14px; width: auto; display: inline-block; text-align: center; text-decoration: none; }
        .btn-secondary { background: #95a5a6; }
        .btn-secondary:hover { background: #7f8c8d; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .btn-warning { background: #f39c12; }
        .btn-warning:hover { background: #e67e22; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #e0e0e0; }
        th, td { padding: 12px; text-align: left; font-size: 14px; }
        th { background-color: #f8f9fa; color: #333; font-weight: 600; }
        tr:nth-child(even) { background-color: #fdfdfd; }
        .actions { display: flex; gap: 5px; }
    </style>
</head>
<body>

<div class="navbar">
    <?php if (isset($_SESSION["user"])): ?>
        <a href="index.php?page=dashboard" class="<?php echo ($page == 'dashboard') ? 'active' : ''; ?>">Dashboard</a>
        <a href="index.php?page=students" class="<?php echo ($page == 'students' || strpos($page, 'student_') !== false) ? 'active' : ''; ?>">Student Portal</a>
        <a href="index.php?page=logout">Logout</a>
    <?php else: ?>
        <a href="index.php?page=login" class="<?php echo ($page == 'login') ? 'active' : ''; ?>">Login</a>
        <a href="index.php?page=signup" class="<?php echo ($page == 'signup') ? 'active' : ''; ?>">Sign Up</a>
    <?php endif; ?>
</div>

<div class="container">
<?php
// Route to the correct page
if ($page == "signup") {
    include "pages/signup.php";
} elseif ($page == "login") {
    include "pages/login.php";
} elseif ($page == "dashboard") {
    include "middleware/auth.php";   // <-- middleware checks login first!
    include "pages/dashboard.php";
} elseif ($page == "students") {
    include "middleware/auth.php";
    include "pages/students.php";
} elseif ($page == "student_add") {
    include "middleware/auth.php";
    include "pages/student_add.php";
} elseif ($page == "student_edit") {
    include "middleware/auth.php";
    include "pages/student_edit.php";
} elseif ($page == "student_delete") {
    include "middleware/auth.php";
    include "pages/student_delete.php";
} else {
    echo "<div class='box'><h1>404 - Page Not Found</h1></div>";
}
?>
</div>

</body>
</html>
