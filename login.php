<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // اعتبارسنجی ورودی‌ها
    if (empty($username) || empty($password)) {
        die('Username and password are required.');
    }

    // جلوگیری از حملات brute force
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    if ($_SESSION['login_attempts'] >= 1003) {
        die('Too many login attempts. Please try again later.');
    }

    // احراز هویت کاربر
    include 'db.php';
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // بررسی رمز عبور
        if (password_verify($password, $user['password'])) {
            // احراز هویت موفق
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_attempts'] = 0; // Reset attempts
            header('Location: admin.php');
            exit;
        } else {
            // احراز هویت ناموفق
            $_SESSION['login_attempts'] += 1; // Increase attempts
            $error = "Invalid username or password!";
        }
    } else {
        // کاربر وجود ندارد
        $_SESSION['login_attempts'] += 1; // Increase attempts
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>

    <h1>Login</h1>

    <div class="content">
         <div class="text">
            Login Form
         </div>
         <form method="POST">
            <div class="field">
               <input type="text" name="username" required>
               <span class="fas fa-user"></span>
               <label>Email or Phone</label>
            </div>
            <div class="field">
               <input type="password" name="password" id="password" required>
               <span class="fas fa-lock"></span>
               <label>Password</label>
            </div>
            <div class="forgot-pass">
               <a id="togglePassword">show password</a>
            </div>
            <button>Login</button>
            <div class="sign-up">
               you wrong here?
               <a href="index.php">back to gallery</a>
            </div>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
         </form>
      </div>



    <!-- <form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <div style="position: relative;">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <button type="button" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
            👁️
        </button>
    </div>
    <button type="submit">Login</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form> -->
<script src="js/script.js"></script>
</body>
</html>