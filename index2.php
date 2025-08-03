<?php
require 'db.php';
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fifteen Puzzle - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to the Fifteen Puzzle Game!</h1>

    <?php if (isset($_SESSION['login_error'])): ?>
        <p style="color: red;"><?= $_SESSION['login_error'] ?></p>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label>Username: <input type="text" name="username" required></label><br><br>
        <label>Password: <input type="password" name="password" required></label><br><br>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>

    <footer>
        <a href="leaderboard.php">Leaderboard</a> |
        <a href="mystats.php">My Stats</a> |
        <a href="admin-login.php">Admin Panel</a>
    </footer>
</body>
</html>
