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
    $page = "contact";                       // default = contact
}

// Logout doesn't need HTML
if ($page == "logout") {
    include "pages/logout.php";
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
    </style>
</head>
<body>

<?php
// Route to the correct page
if ($page == "contact") {
    include "pages/contact.php";
} elseif ($page == "signup") {
    include "pages/signup.php";
} elseif ($page == "login") {
    include "pages/login.php";
} elseif ($page == "dashboard") {
    include "middleware/auth.php";   // <-- middleware checks login first!
    include "pages/dashboard.php";
} else {
    echo "<div class='box'><h1>404 - Page Not Found</h1></div>";
}
?>

</body>
</html>
