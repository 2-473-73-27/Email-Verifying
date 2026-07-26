<?php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
require_once 'db.php';

$app_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM apps WHERE id = ?');
$stmt->execute([$app_id]);
$app = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App Details</title>
    <style>
        body { font-family: Arial, sans-serif; background: #0f172a; color: #f8fafc; padding: 40px; }
        .card { background: #1e293b; padding: 30px; border-radius: 8px; max-width: 600px; margin: auto; }
        a { color: #3b82f6; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <?php if($app): ?>
            <h2>[ Show App Name: <?= htmlspecialchars($app['app_name']) ?> ]</h2>
            <p><strong>Description:</strong> <?= htmlspecialchars($app['app_description']) ?></p>
            <br>
            <a href="dashboard.php">(Show All Apps)</a>
        <?php else: ?>
            <p>App not found.</p>
            <a href="dashboard.php">Back to Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>
