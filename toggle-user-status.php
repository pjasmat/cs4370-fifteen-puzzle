<?php
session_start();
require_once 'db.php';

// Make sure only admin can do this
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

// Check if form sent the required values
if (isset($_POST['id']) && isset($_POST['new_status'])) {
    $userId = intval($_POST['id']);
    $newStatus = intval($_POST['new_status']);

    // Update the user's status in the database
    $stmt = $conn->prepare("UPDATE users SET is_active = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStatus, $userId);

    if ($stmt->execute()) {
        // Success
        $_SESSION['message'] = "User status updated.";
    } else {
        // Failure
        $_SESSION['error'] = "Failed to update user status.";
    }

    $stmt->close();
}

// Redirect back to the admin user page
header("Location: admin-users.php");
exit;
?>
