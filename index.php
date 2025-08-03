<?php
session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

if (!isset($_SESSION['moves'])) {
    $_SESSION['moves'] = 0;
}


function initializeBoard() {
    $tiles = range(1, 15);
    shuffle($tiles);
    $tiles[] = 0;
    $_SESSION['board'] = array_chunk($tiles, 4);
    $_SESSION['moves'] = 0;
}

function displayBoard() {
    $bg = isset($_SESSION['background']) ? $_SESSION['background'] : 'forest.jpg';
    echo '<form method="POST" action="move.php">';
    echo '<table>';
    foreach ($_SESSION['board'] as $i => $row) {
        echo '<tr>';
        foreach ($row as $j => $tile) {
            if ($tile === 0) {
                echo '<td class="empty"></td>';
            } else {
                $tileIndex = $tile - 1;
                $correctRow = floor($tileIndex / 4);
                $correctCol = $tileIndex % 4;
                $x = -($correctCol * 100);
                $y = -($correctRow * 100);
                echo "<td><button style='background-image:url($bg); background-position: {$x}px {$y}px;' type='submit' name='tile' value='{$i},{$j}'>$tile</button></td>";
            }
        }
        echo '</tr>';
    }
    echo '</table></form>';
    echo '<form method="GET"><button class="reset" name="reset" value="1">Restart</button></form>';
    echo '<form method="GET" action="image_select.php" style="margin-top: 10px;"><button type="submit">Change Background</button></form>';


    $elapsed = time() - $_SESSION['start_time'];
    echo "<p>Moves: {$_SESSION['moves']} | Time: {$elapsed} seconds</p>";


}

if (!isset($_SESSION['background'])) {
    header("Location: image_select.php");
    exit;
}

if (!isset($_SESSION['board']) || isset($_GET['reset'])) {
    initializeBoard();
    $_SESSION['moves'] = 0;
    $_SESSION['start_time'] = time();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fifteen Puzzle</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php displayBoard(); ?>
<form method="POST" action="logout.php" style="text-align: right; margin: 10px;">
        <button type="submit" style="padding: 8px 15px; background-color: #7f74ff; border: none; border-radius: 8px; color: white; cursor: pointer;">
            Logout
        </button>
    </form>
    <a href="index2.php" class="home-button">🏠 Return to Homepage</a>
</body>
</html>
