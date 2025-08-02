<?php
session_start();
require 'db.php'; // contains $conn = new mysqli(...)

// Step 1: Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $displayName = $_POST['display_name'];
    $file = $_FILES['background_image'];

    // Step 2: Validate upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("❌ File upload error.");
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("❌ Only JPG, PNG, and GIF images are allowed.");
    }

    // Optional: limit file size to 5MB
    if ($file['size'] > 5 * 1024 * 1024) {
        die("❌ Image too large (limit: 5MB).");
    }

    // Step 3: Move file to uploads folder
    $uploadsDir = 'uploads/';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true); // create folder if missing
    }

    $uniqueName = uniqid() . '_' . basename($file['name']);
    $targetPath = $uploadsDir . $uniqueName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        die("❌ Failed to move uploaded file.");
    }

    // Step 4: Insert into database
    $stmt = $conn->prepare("INSERT INTO background_images (file_name, display_name, is_active, upload_date) VALUES (?, ?, 1, NOW())");
    $stmt->bind_param("ss", $uniqueName, $displayName);
    
    if ($stmt->execute()) {
        header("Location: admin-backgrounds.php?success=1");
        exit();
    } else {
        die("❌ Failed to save to database: " . $stmt->error);
    }
} else {
    echo "⛔ Invalid request method.";
}
?>
