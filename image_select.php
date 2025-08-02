<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bg'])) {
    $_SESSION['background'] = $_POST['bg'];
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Select Puzzle Background</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        form {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }
        label {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }
        img {
            border: 2px solid #ccc;
            padding: 4px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Select a Background Image</h2>
    <form method="POST">
        <label><input type="radio" name="bg" value="kuromi.png" required><img src="kuromi.png" width="100"></label>
        <label><input type="radio" name="bg" value="snorlax.jpeg"><img src="snorlax.jpeg" width="100"></label>
        <label><input type="radio" name="bg" value="mymelody.png"><img src="mymelody.png" width="100"></label>
        <label><input type="radio" name="bg" value="lumalee.jpeg"><img src="lumalee.jpeg" width="100"></label>
        <div style="width: 100%; text-align: center; margin-top: 20px;">
            <button type="submit">Start Game</button>
        </div>
    </form>
</body>
</html>
