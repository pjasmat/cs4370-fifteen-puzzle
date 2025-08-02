<?php
require 'db.php'; // Database connection

// Fetch top players sorted by highest score (descending) and best time (ascending)
$query = "
    SELECT player_name, total_games, best_time, highest_score 
    FROM player_stats 
    ORDER BY highest_score DESC, best_time ASC
    LIMIT 10"; // Show top 10 players

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Leaderboard - Fifteen Puzzle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f4f6f8;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 70%;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 20px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        caption {
            caption-side: bottom;
            margin-top: 10px;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>

    <h1>Fifteen Puzzle Leaderboard</h1>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Player Name</th>
                <th>Total Games</th>
                <th>Best Time (sec)</th>
                <th>Highest Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                $rank = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $rank++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['player_name']) . "</td>";
                    echo "<td>" . intval($row['total_games']) . "</td>";
                    echo "<td>" . number_format($row['best_time'], 2) . "</td>";
                    echo "<td>" . intval($row['highest_score']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No player data found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
