<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Access denied.");
}

require_once 'db.php';

$id = $_POST['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM scores WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: admin-dashboard.php");
exit();
