<?php
// Start the session
session_start();

// Include the database connection
include('../includes/db.php');

// Check if the staff is already logged in
if (isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true) {
    // Redirect to the admin dashboard if logged in
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM staff WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Fetch the staff details
        $staff = mysqli_fetch_assoc($result);

        // Verify the password using password_verify()
        if (password_verify($password, $staff['password'])) {
            // Set session variables for the staff
            $_SESSION['staff_logged_in'] = true;
            $_SESSION['staff_id'] = $staff['staff_id'];
            $_SESSION['staff_role'] = $staff['role'];

            // Redirect to the admin dashboard or the appropriate page
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
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
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Staff Login</h2>

        <!-- Display Error Message -->
        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

        <!-- Staff Login Form -->
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

</body>
</html>
