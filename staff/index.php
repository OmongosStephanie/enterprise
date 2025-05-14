<?php
// Start the session
session_start();

// Redirect admin if already logged in
if (isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true) {
    header('Location: index.php');
    exit();
}

// Redirect regular user if already logged in
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up / Sign In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            padding: 20px;
        }
        .welcome {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
        }
        .action-links {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }
        .card {
            background-color: white;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
            text-align: center;
            width: 220px;
            transition: 0.3s ease;
        }
        .card a {
            text-decoration: none;
            color: #2c3e50;
            font-size: 20px;
            font-weight: bold;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to Our Platform</h1>
</header>

<div class="container">
    <div class="welcome">
        <p>Welcome! Please choose an option to continue:</p>
    </div>

    <div class="action-links">
        <div class="card">
            <a href="login.php">🔑 Sign In</a>
        </div>
        <div class="card">
            <a href="signup.php">✍️ Sign Up</a>
        </div>
    </div>
</div>

</body>
</html>
