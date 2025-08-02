<?php
require 'db.php'; // 🔌 Connect to the database

// ✅ 1. Get submitted form data
$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$is_active = isset($_POST['is_active']) ? 1 : 0;  // checkbox is only sent if checked

// ✅ 2. Validate input
if (!$id || trim($name) === '') {
    die("Missing required fields.");
}

// ✅ 3. Update database
$stmt = $conn->prepare("UPDATE background_images SET name = ?, is_active = ? WHERE id = ?");
$stmt->bind_param("sii", $name, $is_active, $id);

if ($stmt->execute()) {
    // ✅ 4. Redirect back to admin page after success
    header("Location: admin-backgrounds.php");
    exit();
} else {
    echo "Error updating background: " . $stmt->error;
}
?>
