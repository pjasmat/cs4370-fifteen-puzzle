<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

$message = '';
$error = '';

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/backgrounds/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']);
        $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        $targetPath = $uploadDir . $safeName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $imageName = trim($_POST['image_name']) ?: $originalName;
            $stmt = $conn->prepare("INSERT INTO background_images (file_path, image_name) VALUES (?, ?)");
            $stmt->bind_param('ss', $targetPath, $imageName);

            if ($stmt->execute()) {
                $message = "Image uploaded successfully.";
            } else {
                $error = "Failed to save image info to database.";
                unlink($targetPath);
            }
            $stmt->close();
        } else {
            $error = "Failed to move uploaded file.";
        }
    } else {
        $error = "No image uploaded or upload error.";
    }
}

// Fetch all images
$result = $conn->query("SELECT * FROM background_images ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Background Images</title>
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin: auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 150px;
            height: auto;
        }
        form {
            margin: 20px auto;
            width: 400px;
            padding: 15px;
            border: 1px solid #ccc;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
        button {
            padding: 8px 12px;
        }
        .message {
            width: 400px;
            margin: 10px auto;
            color: green;
            text-align: center;
        }
        .error {
            width: 400px;
            margin: 10px auto;
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Manage Background Images</h2>

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<!-- Upload New Image -->
<form method="POST" enctype="multipart/form-data">
    <label for="image_name">Image Name (optional):</label>
    <input type="text" name="image_name" id="image_name" placeholder="Friendly name">

    <label for="image">Select Image to Upload:</label>
    <input type="file" name="image" id="image" accept="image/*" required>

    <button type="submit" name="upload">Upload Image</button>
</form>


<!-- List of Images -->
<table>
    <tr>
        <th>Preview</th>
        <th>Name</th>
        <th>File Path</th>
        <th>Active</th>
        <th>Uploaded At</th>
        <th>Actions</th>
    </tr>
    <?php while ($img = $result->fetch_assoc()): ?>
    <tr>
        <td><img src="<?= htmlspecialchars($img['file_path']) ?>" alt="<?= htmlspecialchars($img['image_name']) ?>"></td>
        <td><?= htmlspecialchars($img['image_name']) ?></td>
        <td><?= htmlspecialchars($img['file_path']) ?></td>
        <td><?= $img['is_active'] ? 'Yes' : 'No' ?></td>
        <td><?= $img['uploaded_at'] ?></td>
        <td>
            <form method="POST" action="edit-background.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $img['id'] ?>">
                <button type="submit">Edit</button>
            </form>
            <form method="POST" action="delete-background.php" style="display:inline;" onsubmit="return confirm('Delete this image?');">
                <input type="hidden" name="id" value="<?= $img['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
