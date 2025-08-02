<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'player';

    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, email, role) VALUES (?, ?, ?, ?)");
    
    try {
        $stmt->execute([$username, $password, $email, $role]);
        echo "Registration successful!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
