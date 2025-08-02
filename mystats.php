<?php
session_start();
require 'db.php';

// 1. Check if player is logged in
if (!isset($_SESSION['player_name'])) {
    // Not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

$playerName = $_SESSION['player_name'];

// 2. Fetch player stats
$stmt = $conn->prepare("SELECT total_games, best_time, highest_score FROM player_stats WHERE player_name = ?");
$stmt->bind_param("s", $playerName);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Stats - Fifteen Puzzle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            padding: 40px;
            max-width: 600px;
            margin: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .stats-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .stat {
            margin-bottom: 20px;
            font-size: 1.2rem;
            color: #555;
        }
        .stat span {
            font-weight: bold;
            color: #222;
        }
        .no-stats {
            text-align: center;
            color: #999;
            font-style: italic;
        }
        a.logout {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #007BFF;
            text-decoration: none;
        }
        a.logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>My Fifteen Puzzle Stats</h1>

    <div class="stats-box">
        <?php if ($stats): ?>
            <div class="stat">Total Games Played: <span><?= intval($stats['total_games']) ?></span></div>
            <div class="stat">Best Completion Time: <span><?= number_format($stats['best_time'], 2) ?> seconds</span></div>
            <div class="stat">Highest Score: <span><?= intval($stats['highest_score']) ?></span></div>
        <?php else: ?>
            <p class="no-stats">No stats found for your account yet.</p>
        <?php endif; ?>
    </div>

    <a class="logout" href="logout.php">Log Out</a>

</body>
</html>
