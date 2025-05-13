<?php
session_start();

// Replace 'root' with your actual MySQL username, and '' (empty string) with your password
$mysqli = new mysqli("localhost", "root", "", "online_shop");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $membership_plan = $_POST['membership_plan'];

    // Check if email is already registered
    $stmt_check = $mysqli->prepare("SELECT * FROM memberships WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Set session error message
        $_SESSION['error'] = "Email is already registered!";
        // Redirect to membership.php
        header("Location: membership.php");
        exit();
    } else {
        // Proceed with registration logic
        $stmt_insert = $mysqli->prepare("INSERT INTO memberships (name, email, password, membership_plan) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("ssss", $name, $email, $password, $membership_plan);
        $stmt_insert->execute();

        // Redirect to a success page or the login page
        header("Location: success_page.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register for Membership - S&R Online Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div class="text-2xl font-semibold">
                <span class="text-yellow-400">S & R</span> Online Shop
            </div>
            <div class="flex items-center gap-4">
                <p>
                    Welcome,
                    <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Guest'; ?>!
                </p>
                <?php if (isset($_SESSION['email'])): ?>
                    <a href="logout.php" class="text-blue-400 hover:text-blue-600">Logout</a>
                <?php endif; ?>
                <a href="cart.php" class="text-white hover:text-yellow-300">🛒</a>
            </div>
        </div>
    </header>

    <section class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Become a Member</h1>
        <p class="text-gray-700 mb-6">
            Complete the form below to join the S&R Membership program and start enjoying the benefits today!
        </p>

        <!-- Membership Signup Form -->
        <form action="membership.php" method="POST" class="bg-white rounded-xl shadow-md p-6 w-full max-w-xl mx-auto">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">Full Name</label>
                <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">Email Address</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="mb-6">
                <label for="membership_plan" class="block text-gray-700 font-semibold">Choose Membership Plan</label>
                <select id="membership_plan" name="membership_plan" class="w-full border border-gray-300 rounded-md p-2" required>
                    <option value="basic">Basic - ₱199.99</option>
                    <option value="premium">Premium - ₱499.99</option>
                    <option value="vip">VIP - ₱999.99</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-semibold px-5 py-2 rounded transition">
                Register for Membership
            </button>
        </form>
    </section>
</body>
</html>
