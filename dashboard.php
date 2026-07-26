<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header('Location: index.php');
    exit;
}
require_once 'db.php';

// Fetch sample apps
$stmt = $pdo->prepare('SELECT * FROM apps WHERE client_id = ? OR client_id IS NULL');
$stmt->execute([$_SESSION['user_id']]);
$apps = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #0f172a; color: #f8fafc; margin: 0; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; padding-bottom: 15px; }
        .menu-icon { font-size: 24px; cursor: pointer; }
        .section { background: #1e293b; padding: 20px; border-radius: 8px; margin-top: 20px; }
        .app-box { background: #334155; padding: 15px; border-radius: 6px; margin: 10px 0; cursor: pointer; display: inline-block; text-decoration: none; color: #fff; }
        .app-box:hover { background: #475569; }
    </style>
</head>
<body>
    <div class="header">
        <span class="menu-icon">[&lt;_&gt;]</span>
        <span>Welcome, <?= htmlspecialchars($_SESSION['email']) ?> | <a href="logout.php" style="color:#ef4444;">Logout</a></span>
    </div>

    <div class="section">
        <h3>Today SMS</h3>
        <p>No new messages received today.</p>
    </div>

    <div class="section">
        <h3>[App]</h3>
        <p>Click an app to open its details page:</p>
        <?php foreach($apps as $app): ?>
            <a href="app_detail.php?id=<?= $app['id'] ?>" class="app-box">
                [ <?= htmlspecialchars($app['app_name']) ?> ]
            </a>
        <?php endforeach; ?>
    </div>
</body>
</html>
