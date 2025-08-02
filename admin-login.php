<?php
session_start();

$valid_user = "admin";
$valid_pass = "mypassword";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST['username'] === $valid_user && $_POST['password'] === $valid_pass) {
        $_SESSION['admin'] = true;
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "Invalid login!";
    }
}
?>
<form method="POST">
    <input name="username" placeholder="Username">
    <input name="password" type="password" placeholder="Password">
    <button type="submit">Login</button>
</form>
