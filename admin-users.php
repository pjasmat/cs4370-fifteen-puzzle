<?php
session_start();
require_once 'db.php';

// Make sure only admin can access this page
if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - User Management</title>
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

        button {
            padding: 5px 10px;
            margin: 2px;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Registered Users</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= $row['is_active'] ? 'Active' : 'Inactive' ?></td>
        <td>
            <!-- Edit User Button -->
            <form method="POST" action="edit-user.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit">Edit</button>
            </form>

            <!-- Toggle Active/Inactive Button -->
            <form method="POST" action="toggle-user-status.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="hidden" name="new_status" value="<?= $row['is_active'] ? 0 : 1 ?>">
                <button type="submit">
                    <?= $row['is_active'] ? 'Deactivate' : 'Activate' ?>
                </button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
