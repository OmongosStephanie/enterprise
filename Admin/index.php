<?php
// Start the session
session_start();

// Check if the user is already logged in (admin or user)
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // If logged in as admin, redirect to the admin dashboard
    
}

// If logged in as a user (if you have user sessions), redirect them to a different page
// Example: if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
//    header('Location: user_dashboard.php');
//    exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up / Sign In</title>
    <link rel="stylesheet" href="css/style.css">
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
        }
        .card {
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
            text-align: center;
            width: 200px;
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