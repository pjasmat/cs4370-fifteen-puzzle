<?php
// Check if the admin is logged in

require 'db.php'; // connects to the database

// ✅ 1. Get background ID from the URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die("No background ID provided.");
}

// ✅ 2. Fetch background details from DB
$stmt = $conn->prepare("SELECT * FROM background_images WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$background = $result->fetch_assoc();

if (!$background) {
    die("Background not found.");
}
?>

<!-- ✅ 3. Show Edit Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Background</title>
</head>
<body>
    <h2>Edit Background</h2>
    
    <form method="POST" action="update-background.php">
        <!-- Hidden ID field -->
        <input type="hidden" name="id" value="<?= $background['id'] ?>">

        <!-- Background Name -->
        <label>Background Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($background['name']) ?>" required><br><br>

        <!-- Active Checkbox -->
        <label>
            <input type="checkbox" name="is_active" value="1" <?= $background['is_active'] ? 'checked' : '' ?>>
            Active
        </label><br><br>

        <button type="submit">Update</button>
    </form>

    <p><a href="admin-backgrounds.php">Back to Backgrounds</a></p>
</body>
</html>
