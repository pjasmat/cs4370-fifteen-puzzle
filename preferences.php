<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

require 'db_connect.php';

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM preferences WHERE user_id = ?");
$stmt->execute([$user_id]);
$pref = $stmt->fetch();
?>

<form method="POST" action="save_preferences.php">
    <label for="theme">Theme:</label>
    <select name="theme">
        <option value="light" <?= ($pref && $pref['theme'] == 'light') ? 'selected' : '' ?>>Light</option>
        <option value="dark" <?= ($pref && $pref['theme'] == 'dark') ? 'selected' : '' ?>>Dark</option>
    </select>
    <button type="submit">Save</button>
</form>
