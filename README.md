# Student-Portal-Manager (PHP)

A minimalistic, lightweight PHP-based Student Portal showcasing User Authentication and CRUD operations via file-based storage mapping. Designed securely with session middlewares and integrated header routing.

## 🚀 Demo
[View Application Demo](https://drive.google.com/file/d/1c1t9LRw50Ttfv6gHeWSEKwq56_UpLf9F/view)

## 📌 Features
- **User Authentication:** 
  - Login & Sign Up capabilities. 
  - Restricts application views using `include "middleware/auth.php"`.
- **Student Data CRUD:** 
  - Create (Add Student mapping courses/emails).
  - Read (View full table in portal view).
  - Update (Edit existing ID nodes). 
  - Delete (JS-protected row deletion mapping).
- **JSON File-Store Architecture:** 
  - Utilizes `data/students.json` for mapping. Zero-config server footprint. DB-less implementation.
- **Top Navigation Routing:**
  - Modern PHP routing architecture within an independent `index.php` shell view.

## 🛠 Tech Stack
- **Server:** PHP 
- **Database/Storage:** Flat text handling via `.json` and `.txt`.
- **Frontend UI:** Vanilla CSS + HTML5 layout integrated tightly into PHP blocks.

## 💻 Usage

### 1. Start Local PHP Server
In your local directory containing `index.php`, start the built-in server:
```bash
php -S localhost:8000
```
### 2. View in Browser
Open: [http://localhost:8000](http://localhost:8000)

### 3. Log In Strategy
The app reads registered logins from `users.txt`.
You can optionally register a brand **new account** through the `Sign Up` route!

---

### Folder Architecture
```
/
├── data/
│   └── students.json       # Array store for CRM
├── middleware/
│   ├── auth.php            # Security block for logged-in only areas
│   └── guest.php           # Security block preventing auth'd users viewing login
├── pages/
│   ├── dashboard.php       
│   ├── login.php           # Login form template
│   ├── logout.php          # Session destruction 
│   ├── signup.php          # Account creation template
│   ├── student_*.php       # CRUD Logic mappings
├── index.php               # Front Controller routing and UI Shell
└── users.txt               # Stored login auth tokens
```