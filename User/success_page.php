<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Successful - S&R Online Shop</title>
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

    <main class="container mx-auto px-4 py-10">
        <div class="bg-white rounded-xl shadow-md p-8 max-w-xl mx-auto text-center">
            <h1 class="text-3xl font-bold text-green-600 mb-4">🎉 Registration Successful!</h1>
            <p class="text-gray-700 mb-6">
                You are now a member of the S&R Online Shop. Enjoy exclusive member benefits and happy shopping!
            </p>
            <a href="dashboard.php" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-semibold px-5 py-2 rounded transition">
                Go to Homepage
            </a>
        </div>
    </main>

</body>
</html>
