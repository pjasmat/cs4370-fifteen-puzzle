<?php
session_start();
require_once 'db.php';

// Check admin logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

// Initialize variables
$userId = $_POST['id'] ?? $_GET['id'] ?? null;
$username = '';
$error = '';
$success = '';

// Fetch user data if ID is given
if ($userId) {
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        $username = $user['username'];
    } else {
        $error = "User not found.";
    }
    $stmt->close();
} else {
    $error = "No user ID specified.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $newUsername = trim($_POST['username']);
    $newPassword = $_POST['password'];

    if (empty($newUsername)) {
        $error = "Username cannot be empty.";
    } else {
        // Update username and optionally password
        if (!empty($newPassword)) {
            // Hash the new password
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE users SET username = ?, password_hash = ? WHERE id = ?");
            $stmt->bind_param("ssi", $newUsername, $passwordHash, $userId);
        } else {
            // Only update username
            $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
            $stmt->bind_param("si", $newUsername, $userId);
        }

        if ($stmt->execute()) {
            $success = "User updated successfully.";
            $username = $newUsername;
        } else {
            $error = "Failed to update user.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        form {
            width: 400px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        label, input {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        input[type="text"], input[type="password"] {
            padding: 8px;
            font-size: 1em;
        }
        button {
            padding: 10px 15px;
            font-size: 1em;
        }
        .message {
            width: 400px;
            margin: 20px auto;
            text-align: center;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Edit User</h2>

<?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="message"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if ($userId && !$error): ?>
    <form method="POST" action="edit-user.php?id=<?= $userId ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>

        <label for="password">New Password (leave blank to keep current):</label>
        <input type="password" id="password" name="password">

        <button type="submit" name="save">Save Changes</button>
    </form>
<?php endif; ?>

<p style="text-align:center;"><a href="admin-users.php">Back to User Management</a></p>

</body>
</html>
