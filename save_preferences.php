<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Not logged in.");
}

$user_id = $_SESSION['user_id'];
$theme = $_POST['theme'];

$stmt = $pdo->prepare("REPLACE INTO preferences (user_id, theme) VALUES (?, ?)");
$stmt->execute([$user_id, $theme]);

echo "Preferences saved!";
?>
