<?php
session_start();
include '../includes/db.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admins WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Admin Login</h2>

        <?php if (isset($error)): ?>
            <div class="mb-4 text-red-600 text-sm text-center font-medium bg-red-100 p-2 rounded">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" required
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="password" name="password" placeholder="Password" required
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="submit" name="login" value="Login"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded cursor-pointer">
        </form>

        <div class="text-center mt-4 text-sm text-gray-600">
            Don't have an account? <a href="signup.php" class="text-blue-600 hover:underline">Sign up here</a>
        </div>
    </div>

</body>
</html>
