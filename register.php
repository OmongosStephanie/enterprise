<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <style>
        body {
            background-color: #4e5e5c;
            font-family: Arial, sans-serif;
            color: #000;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
        }
        input[type=text], input[type=email], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #aaa;
            border-radius: 5px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #aaa;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background-color: blue;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<form method="POST" action="register.php">
    <h2>Create Account</h2>

    <input type="text" name="firstname" placeholder="First Name" required>
    <input type="text" name="lastname" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="contact" placeholder="Contact Number" required>
    <textarea name="address" placeholder="Address" required></textarea>

    <button class="btn" type="submit" name="submit">Create Account</button>

    <div class="login-link">
        Already have an account? <a href="login.php"><strong>Login</strong></a>
    </div>
</form>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = htmlspecialchars($_POST['firstname']);
    $lname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contact = htmlspecialchars($_POST['contact']);
    $address = htmlspecialchars($_POST['address']);

    // You can save this data to a database here
    echo "<p style='text-align:center; color: green;'>Account created successfully for $fname $lname!</p>";
}
?>
