<?php
// Database connection
$servername = "localhost"; // or your server name
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "online_shop"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password and confirm password check
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, contact_number, address, email, birthday, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $first_name, $last_name, $contact_number, $address, $email, $birthday, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header('Location: login.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration - Online Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #5A6866; /* Updated background color */
            margin: 0;
            padding: 0;
        }
        h2 {
            color: #333;
            font-weight: 600;
        }

        /* Registration Container */
        .registration-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            margin: 50px auto;
        }

        /* Input Fields */
        input[type="text"], input[type="email"], input[type="date"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="password"]:focus {
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
            .registration-container {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

<div class="registration-container">
    <h2>Create Account</h2>
    <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="text" name="contact_number" placeholder="Contact Number" required><br>
        <input type="text" name="address" placeholder="Address" required><br>
        <input type="email" name="email" placeholder="Email Address" required><br>
        <input type="date" name="birthday" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <button type="submit">Create Account</button>
    </form>
    <p class="links">Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
