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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            background-color: #f4f4f9;
            padding: 40px;
            margin: 0;
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
        }

        label {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        label:hover {
            transform: scale(1.05);
        }

        img {
            border: 3px solid #ccc;
            border-radius: 12px;
            width: 120px;
            height: 120px;
            object-fit: cover;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s;
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked + img {
            border-color: #007bff;
        }

        button {
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Select a Background Image</h2>
    <form method="POST">
        <label>
            <input type="radio" name="bg" value="kuromi.png" required>
            <img src="kuromi.png">
        </label>
        <label>
            <input type="radio" name="bg" value="snorlax.jpeg">
            <img src="snorlax.jpeg">
        </label>
        <label>
            <input type="radio" name="bg" value="mymelody.png">
            <img src="mymelody.png">
        </label>
        <label>
            <input type="radio" name="bg" value="lumalee.jpeg">
            <img src="lumalee.jpeg">
        </label>
        <div style="width: 100%; text-align: center; margin-top: 20px;">
            <button type="submit">Start Game</button>
        </div>
    </form>
</body>
</html>
