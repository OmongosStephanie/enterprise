<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>S&R Online Shop - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div class="logo text-2xl font-semibold">
                <span class="text-yellow-400">S & R</span> Online Shop
            </div>
            <div class="search flex items-center">
                <input type="text" placeholder="Search" class="w-64 px-4 py-2 rounded-l-md text-gray-800">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md">Search</button>
            </div>
            <div class="flex items-center gap-4">
                <p>
                    Welcome, 
                    <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Guest'; ?>!
                </p>
                <?php if (isset($_SESSION['email'])): ?>
                    <a href="logout.php" class="text-blue-400 hover:text-blue-600">Logout</a>
                <?php endif; ?>
                <a href="cart.php" class="text-white hover:text-yellow-300">
                    🛒
                </a>
                <a href="#" class="text-white hover:text-yellow-300 flex items-center gap-1">
                    Customer Service
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m7 10 5 5 5-5"/></svg>
                </a>
            </div>
        </div>
    </header>

    <nav class="bg-gray-700 py-3">
        <div class="container mx-auto px-4">
            <ul class="flex space-x-6 text-white">
                <li><a href="#" class="hover:text-yellow-300">Shop All Categories</a></li>
                <li><a href="#" class="hover:text-yellow-300">Groceries</a></li>
                <li><a href="#" class="hover:text-yellow-300">Fresh</a></li>
                <li><a href="#" class="hover:text-yellow-300">Beer, Wine & Spirits</a></li>
                <li><a href="#" class="hover:text-yellow-300">Personal Care</a></li>
                <li><a href="#" class="hover:text-yellow-300">Member's Value</a></li>
                <li><a href="#" class="hover:text-yellow-300">On Sale!</a></li>
                <li><a href="#" class="hover:text-yellow-300">Pizza.com</a></li>
                <li><a href="#" class="hover:text-yellow-300">Membership</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-4 text-sm text-gray-500">
        <span><a href="#" class="hover:text-yellow-300">Home</a></span> /
        <span><a href="#" class="hover:text-yellow-300">Shop All Categories</a></span> /
        <span>Groceries</span>
    </div>

    <section class="container mx-auto px-4 py-6 text-center">
    <h2 class="text-2xl font-semibold text-gray-800 mb-8">Explore Our Grocery Categories</h2>
    <div class="flex justify-center gap-8 flex-wrap">
        <!-- Beverages -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition w-64">
            <a href="beverages.php">
                <img src="https://imgs.search.brave.com/Ya8ons9Se8D2gLAdZuOvsyjeHRLni5KhaAqWx9_Nhzo/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzA3LzUxLzE2LzE3/LzM2MF9GXzc1MTE2/MTcxMl9neEpMaDFK/NFplRlkyTTIxRDZx/R0lZeGRRWGlJU0Vh/MS5qcGc" alt="Beverages" class="rounded-md w-full h-60 object-cover mb-4">
                <h3 class="text-center text-xl font-semibold">Beverages</h3>
            </a>
        </div>
        <!-- Bread and Bakery -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition w-64">
            <a href="bread-and-bakery.php">
                <img src="https://imgs.search.brave.com/DnEDm5AVnXbBAEV7P6hqpJluOwpF4hwXEJIKLsm3Xys/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/Zm9vZGFuZHdpbmUu/Y29tL3RobWIvTWly/TVJkdlN3NU1BazdL/WFg0NXBHOGhVSFpr/PS8xNTAweDAvZmls/dGVyczpub191cHNj/YWxlKCk6bWF4X2J5/dGVzKDE1MDAwMCk6/c3RyaXBfaWNjKCkv/YmVzdC1icmVhZC1v/c29uby1GVC1CTE9H/MDIyMi1lM2U3MmY0/MTJiYzA0YThlYTMz/N2VlNzAzMTA4MTg3/NS5qcGc" alt="Bread and Bakery" class="rounded-md w-full h-60 object-cover mb-4">
                <h3 class="text-center text-xl font-semibold">Bread and Bakery</h3>
            </a>
        </div>
    </div>
</section>

</body>
</html>
