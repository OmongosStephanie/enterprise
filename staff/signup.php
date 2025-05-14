<?php
// Start the session
session_start();

// Include the database connection
include('../includes/db.php');

// Check if the staff is already logged in
if (isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true) {
    // Redirect to the admin dashboard if logged in
    header("Location: admin_dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if the email already exists
    $sql = "SELECT * FROM staff WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $error_message = "Email is already registered.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new staff into the database
        $sql_insert = "INSERT INTO staff (first_name, last_name, email, password, role) 
                       VALUES ('$first_name', '$last_name', '$email', '$hashed_password', '$role')";

        if (mysqli_query($conn, $sql_insert)) {
            // Redirect to login page after successful registration
            $success_message = "Registration successful. You can now log in.";
            header("Location: login.php?message=" . urlencode($success_message));
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            padding: 20px;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container button:hover {
            background-color: #34495e;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
        }
        .success-message {
            color: green;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Staff Registration</h2>

        <!-- Display Error or Success Message -->
        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        if (isset($success_message)) {
            echo "<p class='success-message'>$success_message</p>";
        }
        ?>

        <!-- Staff Registration Form -->
        <form method="POST" action="signup.php">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="role" placeholder="Role (Admin/Manager/Employee)" required>
            <button type="submit">Register</button>
        </form>

        <!-- Link to Login page -->
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>

</body>
</html>
