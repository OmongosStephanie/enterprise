<?php
session_start();
session_destroy();
header('Refresh: 2; url=index.php?logged_out=1');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - S&R Online Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-md text-center max-w-sm w-full">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">You have successfully logged out!</h2>
        <p class="text-gray-600 mb-4">Redirecting you back to the login page...</p>
        <div class="flex justify-center mb-4">
            <div class="animate-ping h-3 w-3 rounded-full bg-yellow-400"></div>
        </div>
        <p class="text-gray-500 text-sm">If you are not redirected in a few seconds, <a href="index.php">click here</a>.</p>
    </div>
</body>
</html>
