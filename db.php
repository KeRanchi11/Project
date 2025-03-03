<?php
// اطلاعات اتصال به دیتابیس
$host = 'localhost';
$db   = 'tablosa4_gallery';
$user = 'root';
$pass = '';

// اتصال به دیتابیس
$conn = new mysqli($host, $user, $pass, $db);

// بررسی خطاهای اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تابع برای بررسی اعتبار کاربر
function authenticateUser($username, $password) {
    global $conn;

    // استفاده از prepared statements برای جلوگیری از حملات تزریق SQL
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // بررسی رمز عبور با استفاده از password_verify
        if (password_verify($password, $user['password'])) {
            return $user; // احراز هویت موفق
        }
    }

    return false; // احراز هویت ناموفق
}

// تابع برای ایجاد کاربر جدید
function createUser($username, $password) {
    global $conn;

    // هش کردن رمز عبور
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // استفاده از prepared statements برای جلوگیری از حملات تزریق SQL
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        return true; // ایجاد کاربر موفق
    } else {
        return false; // ایجاد کاربر ناموفق
    }
}
?>