<?php
require 'db.php'; // Connect to DB

// 1. Make sure we received an ID via POST
if (!isset($_POST['id'])) {
    die("❌ Missing background ID.");
}

$id = intval($_POST['id']); // sanitize

// 2. Get the filename from the database
$stmt = $conn->prepare("SELECT file_name FROM background_images WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Background not found.");
}

$row = $result->fetch_assoc();
$filename = $row['file_name'];

// 3. Delete the file from the server
$filepath = 'uploads/' . $filename;
if (file_exists($filepath)) {
    unlink($filepath); // deletes file
}

// 4. Delete the record from the database
$stmt = $conn->prepare("DELETE FROM background_images WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin-backgrounds.php?deleted=1");
    exit();
} else {
    die("❌ Failed to delete from database: " . $stmt->error);
}
?>
