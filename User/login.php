<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    // If the email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_email, $db_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $db_password)) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $db_email;
            header('Location: dashboard.php'); // Redirect to dashboard
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Email not found!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Online Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #5A6866; /* Background color */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h2 {
            color: #333;
            font-weight: 600;
        }

        /* Login Container */
        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }

        /* Input Fields */
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #0066cc;
            outline: none;
        }

        /* Button Style */
        button {
            width: 100%;
            padding: 12px;
            background-color: #0066cc;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #004999;
        }

        /* Link Styles */
        .links {
            text-align: center;
            margin-top: 15px;
        }

        .links a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 600;
        }

        .links a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p class="links">Don’t have an account? <a href="register.php">Register for free</a></p>
</div>

</body>
</html>
