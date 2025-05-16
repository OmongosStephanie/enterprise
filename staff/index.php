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
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome • Sign In / Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        /* Hero Section */
        .hero {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 40px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .action-buttons a {
            background-color: #e74c3c;
            color: white;
            font-size: 18px;
            padding: 15px 40px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .action-buttons a:hover {
            background-color: #c0392b;
        }

        /* Features Section */
        .features {
            display: flex;
            justify-content: center;
            padding: 50px 20px;
            background-color: #ecf0f1;
            flex-wrap: wrap;
        }

        .feature-card {
            background-color: white;
            border: 1px solid #ddd;
            margin: 20px;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            width: 250px;
            transition: all 0.3s ease;
        }

        .feature-card h3 {
            margin-bottom: 20px;
        }

        .feature-card p {
            font-size: 16px;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Call to Action Section */
        .cta {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 60px 20px;
        }

        .cta h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .cta button {
            background-color: #e74c3c;
            color: white;
            font-size: 18px;
            padding: 15px 40px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cta button:hover {
            background-color: #c0392b;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
        }

        @media (max-width: 600px) {
            .feature-card {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome to Our Platform</h1>
        <p>Your one-stop solution for secure and efficient service access.</p>
        <div class="action-buttons">
            <a href="login.php">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="feature-card">
            <h3>Quick Access</h3>
            <p>Sign in to manage your dashboard and access all features quickly.</p>
        </div>
        <div class="feature-card">
            <h3>New Here?</h3>
            <p>Register a new account in just a few simple steps.</p>
        </div>
        <div class="feature-card">
            <h3>Secure Sessions</h3>
            <p>We ensure your account is protected with session management.</p>
        </div>
    </section>
    

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Our Platform. All rights reserved.</p>
    </footer>

</body>
</html>
