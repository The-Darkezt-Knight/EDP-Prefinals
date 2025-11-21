<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();

    // boi pang demo lang ni nga page isli lang
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .dashboard {
            text-align: center;
            background: white;
            padding: 60px 40px;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .user-info {
            margin-bottom: 30px;
        }

        .user-info h1 {
            font-size: 36px;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .user-info p {
            font-size: 16px;
            color: #666;
        }

        .logout-btn {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .logout-btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="user-info">
            <h1><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
            <p>Welcome to your dashboard</p>
        </div>
        <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>