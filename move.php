<?php
session_start();

function findEmpty() {
    foreach ($_SESSION['board'] as $i => $row) {
        foreach ($row as $j => $tile) {
            if ($tile == 0) return [$i, $j];
        }
    }
    return null;
}

function isAdjacent($i1, $j1, $i2, $j2) {
    $_SESSION['moves']++;
    return (abs($i1 - $i2) + abs($j1 - $j2)) === 1;
}

if (isset($_POST['tile'])) {
    list($row, $col) = explode(',', $_POST['tile']);
    $row = (int)$row;
    $col = (int)$col;

    list($emptyRow, $emptyCol) = findEmpty();

    if (isAdjacent($row, $col, $emptyRow, $emptyCol)) {
        $_SESSION['board'][$emptyRow][$emptyCol] = $_SESSION['board'][$row][$col];
        $_SESSION['board'][$row][$col] = 0;
        $_SESSION['moves']++;
    }
}

header("Location: index.php");
exit;
