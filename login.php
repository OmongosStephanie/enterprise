<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Online Shop</title>
    <style>
        body {
            background-color: #5d6d6d;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background-color: #eee;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }
        input[type="email"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-btn {
            background-color: #0047AB;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            width: 90%;
            cursor: pointer;
        }
        .login-btn:hover {
            background-color: #003080;
        }
        .links {
            margin-top: 15px;
            font-size: 14px;
        }
        .links a {
            color: #0047AB;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <img src="logo.png" alt="Logo" width="80">
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <div class="links">
            <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" name="login" class="login-btn">Login</button>
    </form>
    <div class="links">
        Don’t have an account yet? <a href="register.php">Register for free</a>
    </div>
</div>

</body>
</html>
