<?php
include 'db.php'; // اتصال به دیتابیس

// اطلاعات کاربر جدید
$username = 'HadiMaleki'; // نام کاربری جدید
$password = 'Xlaa7092'; // رمز عبور جدید

// ایجاد کاربر جدید
if (createUser($username, $password)) {
    echo "User created successfully!";
} else {
    echo "Error creating user.";
}
?>