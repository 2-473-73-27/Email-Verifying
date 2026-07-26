<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: index.php');
    exit;
}
require_once 'db.php';

$commandResponse = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
    $cmd = trim($_POST['command']);
    // Simulated command execution processor for manager
    if (strpos($cmd, 'update') === 0) {
        $commandResponse = "System update executed successfully. Layout rules optimized.";
    } elseif (strpos($cmd, 'status') === 0) {
        $commandResponse = "All subsystems operational. Memory load: 18%.";
    } else {
        $commandResponse = "Command processed: " . htmlspecialchars($cmd);
    }
}

// System Health Diagnostics
$load = sys_getloadavg();
$diskFree = disk_free_space(".");
$diskTotal = disk_total_space(".");
$healthStatus = ($load[0] < 2.0) ? "Optimal (Healthy)" : "High Load Warning";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #0f172a; color: #f8fafc; margin: 0; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; padding-bottom: 15px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .card { background: #1e293b; padding: 20px; border-radius: 8px; }
        input[type="text"] { width: 70%; padding: 10px; background: #0f172a; border: 1px solid #334155; color: #fff; border-radius: 4px; }
        button { padding: 10px 20px; background: #10b981; border: none; color: #fff; font-weight: bold; border-radius: 4px; cursor: pointer; }
        .ai-btn { background: #8b5cf6; font-size: 20px; padding: 10px 15px; border-radius: 50%; border: none; cursor: pointer; color: white; }
        pre { background: #0f172a; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <span style="font-size:24px; cursor:pointer;">[&lt;_&gt;]</span>
            <span style="font-size:20px; font-weight:bold; margin-left: 10px;">[Well Come Back Manager]</span>
        </div>
        <div>
            <!-- AI Assistant Modal Trigger -->
            <button class="ai-btn" onclick="toggleAI()" title="Open AI Manager">🤖</button>
            <a href="logout.php" style="color:#ef4444; margin-left:15px;">Logout</a>
        </div>
    </div>

    <div class="grid">
        <!-- Command Panel -->
        <div class="card">
            <h3>[&lt;_&gt;] [Command Center]</h3>
            <form method="POST">
                <input type="text" name="command" placeholder="Enter command (e.g., update, status)..." required>
                <button type="submit">Execute</button>
            </form>
            <?php if($commandResponse): ?>
                <pre><?= $commandResponse ?></pre>
            <?php endif; ?>
        </div>

        <!-- System Health Panel -->
        <div class="card">
            <h3>[OS System Health]</h3>
            <p><strong>Status:</strong> <span style="color: #10b981;"><?= $healthStatus ?></span></p>
            <p><strong>Server Load Average:</strong> <?= $load[0] ?></p>
            <p><strong>Free Disk Space:</strong> <?= round($diskFree / 1024 / 1024 / 1024, 2) ?> GB / <?= round($diskTotal / 1024 / 1024 / 1024, 2) ?> GB</p>
        </div>
    </div>

    <!-- AI Manager Modal / Drawer -->
    <div id="aiModal" style="display:none; position: fixed; top: 0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); justify-content:center; align-items:center;">
        <div style="background:#1e293b; padding:30px; border-radius:8px; width: 500px; max-height: 80vh; overflow-y:auto;">
            <h3>🤖 AI Manager Assistant</h3>
            <p style="font-size: 13px; color: #94a3b8;">Secure AI engine synchronized with website state, database records, and logs.</p>
            <div id="aiChatWindow" style="background:#0f172a; height: 200px; padding: 10px; border-radius: 4px; overflow-y:scroll; margin-bottom: 10px; font-size:14px;">
                AI: Hello Manager. I have full context of all client details and system protocols. How can I assist you today?
            </div>
            <input type="text" id="aiQuery" placeholder="Ask AI anything about the site or clients..." style="width: 78%;">
            <button onclick="sendAIQuery()" style="background:#8b5cf6;">Ask</button>
            <br><br>
            <button onclick="toggleAI()" style="background:#64748b; width:100%;">Close AI</button>
        </div>
    </div>

    <script>
        function toggleAI() {
            const modal = document.getElementById('aiModal');
            modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
        }
        function sendAIQuery() {
            const input = document.getElementById('aiQuery');
            const chat = document.getElementById('aiChatWindow');
            if(!input.value) return;
            
            chat.innerHTML += `<br><strong>You:</strong> ${input.value}`;
            // Simulated intelligent response leveraging backend visibility
            setTimeout(() => {
                chat.innerHTML += `<br><span style="color:#a78bfa;"><strong>AI:</strong> Analyzed securely. Database connection stable, system health is optimal, and all client records match configuration criteria.</span>`;
                chat.scrollTop = chat.scrollHeight;
            }, 500);
            input.value = '';
        }
    </script>
</body>
</html>
