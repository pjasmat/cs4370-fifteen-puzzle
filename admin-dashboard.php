<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit();
}

require_once 'db.php';

$query = "SELECT * FROM scores ORDER BY time_seconds ASC";
$result = $conn->query($query);
?>

<h2>Top Scores</h2>
<table>
    <tr>
        <th>Player</th>
        <th>Moves</th>
        <th>Time(s)</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['player_name'] ?></td>
            <td><?= $row['moves'] ?></td>
            <td><?= $row['time_seconds'] ?></td>
            <td><?= $row['date_played'] ?></td>
            <td>
                <form method="POST" action="delete-score.php">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
