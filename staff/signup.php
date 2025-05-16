<?php
session_start();
include('../includes/db.php');

if (isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "SELECT * FROM staff WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $error_message = "Email is already registered.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql_insert = "INSERT INTO staff (first_name, last_name, email, password, role) 
                       VALUES ('$first_name', '$last_name', '$email', '$hashed_password', '$role')";
        if (mysqli_query($conn, $sql_insert)) {
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
    <title>Staff Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Staff Registration</h2>

        <?php if (isset($error_message)): ?>
            <p class="bg-red-100 text-red-600 p-3 rounded mb-4 text-center"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <p class="bg-green-100 text-green-600 p-3 rounded mb-4 text-center"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="signup.php" class="space-y-4">
            <input type="text" name="first_name" placeholder="First Name" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input type="text" name="last_name" placeholder="Last Name" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input type="email" name="email" placeholder="Email" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input type="text" name="role" placeholder="Role (Admin/Manager/Employee)" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition duration-200">
                Register
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600 text-sm">
            Already have an account?
            <a href="login.php" class="text-blue-600 hover:underline">Login here</a>
        </p>
    </div>
</body>
</html>
