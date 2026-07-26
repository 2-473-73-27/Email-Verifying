<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'manager') {
            header('Location: manager.php');
        } else {
            header('Location: dashboard.php');
        }
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - ZONE Panel</title>
    <style>
        body { font-family: Arial, sans-serif; background: #0f172a; color: #f8fafc; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: #1e293b; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.5); width: 320px; }
        h2 { margin-bottom: 20px; font-size: 24px; text-align: center; }
        .menu-icon { font-size: 20px; cursor: pointer; margin-bottom: 15px; display: inline-block; }
        label { display: block; margin-bottom: 8px; font-size: 14px; color: #94a3b8; }
        input { width: 100%; padding: 10px; margin-bottom: 20px; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #fff; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #3b82f6; border: none; border-radius: 6px; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background: #2563eb; }
        .error { color: #ef4444; font-size: 13px; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-card">
        <span class="menu-icon">[&lt;_&gt;]</span>
        <h2>Hi Well Come</h2>
        <?php if($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <label>Enter Your Email:</label>
            <input type="email" name="email" placeholder="✉️ example@gmail.com" required>
            
            <label>Enter Your Password:</label>
            <input type="password" name="password" placeholder="🔑 ********" required>
            
            <button type="submit">[Login]</button>
        </form>
    </div>
</body>
</html>
