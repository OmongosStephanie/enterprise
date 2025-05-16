<?php
// Start the session
session_start();

// Include the database connection
include('../includes/db.php');

// Check if the staff is already logged in
if (isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM staff WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $staff = mysqli_fetch_assoc($result);

        if (password_verify($password, $staff['password'])) {
            $_SESSION['staff_logged_in'] = true;
            $_SESSION['staff_id'] = $staff['staff_id'];
            $_SESSION['staff_role'] = $staff['role'];

            header("Location: dashboard.php"); // Redirect to dashboard on success
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
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Staff Login</title>
<style>
    /* Reset and base */
    * {
        box-sizing: border-box;
    }
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg,rgb(218, 221, 231),rgb(230, 228, 233));
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #333;
    }
    .login-wrapper {
        background: #fff;
        padding: 40px 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }
    .login-wrapper h2 {
        margin-bottom: 25px;
        color: #4a4a4a;
        font-weight: 700;
        letter-spacing: 1.5px;
    }
    form {
        display: flex;
        flex-direction: column;
    }
    input[type="email"],
    input[type="password"] {
        padding: 14px 18px;
        margin-bottom: 20px;
        border: 1.8px solid #ddd;
        border-radius: 10px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }
    input[type="email"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color:rgb(220, 223, 238);
        box-shadow: 0 0 8px rgba(211, 214, 223, 0.5);
    }
    button {
        padding: 14px 20px;
        background-color: #667eea;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color:rgb(219, 220, 228);
    }
    .error-message {
        color: #e74c3c;
        margin-bottom: 20px;
        font-weight: 600;
        font-size: 14px;
    }
    .signup-link {
        margin-top: 20px;
        font-size: 15px;
        color: #666;
    }
    .signup-link a {
        color:rgb(213, 215, 228);
        text-decoration: none;
        font-weight: 600;
        margin-left: 6px;
        transition: color 0.3s ease;
    }
    .signup-link a:hover {
        color:rgb(233, 234, 240);
    }
</style>
</head>
<body>

<div class="login-wrapper">
    <h2>Staff Login</h2>

    <?php if (isset($error_message)): ?>
        <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php" autocomplete="off">
        <input type="email" name="email" placeholder="Email address" required autofocus />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Log In</button>
    </form>

    <div class="signup-link">
        Don't have an account?
        <a href="signup.php">Sign up here</a>
    </div>
</div>

</body>
</html>
