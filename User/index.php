<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S&R Online Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div class="logo text-2xl font-semibold">
                <span class="text-yellow-400">S & R</span> Online Shop
            </div>
            <div class="search flex items-center">
                <input type="text" placeholder="Search" class="w-64 px-4 py-2 rounded-l-md focus:outline-none text-gray-800">
                <button class="bg-blue-500 hover:bg-blue-600 text-white rounded-r-md px-4 py-2 focus:outline-none">
                    Search
                </button>
            </div>
            <div class="account flex items-center gap-4">
                <a href="register.php" class="text-white hover:text-yellow-300">Sign In / Register</a>
                <a href="#" class="text-white hover:text-yellow-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 0 0 0 2-2V6l-3-4z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </a>
            </div>
            <div class="customer-service text-sm">
                <a href="#" class="text-white hover:text-yellow-300 flex items-center gap-1">
                    Customer Service
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m7 10 5 5 5-5"></path></svg>
                </a>
            </div>
        </div>
    </header>

    <nav class="bg-gray-700 py-3">
        <div class="container mx-auto px-4">
            <ul class="flex space-x-6">
                <li><a href="#" class="text-white hover:text-yellow-300">Shop All Categories</a></li>
                <li><a href="#" class="text-white hover:text-yellow-300">Groceries</a></li>
                <li><a href="#" class="text-white hover:text-yellow-300">Fresh</a></li>
                <li><a href="#" class="text-white hover:text-yellow-300">Beer, Wine & Spirits</a></li>
                <li><a href="#" class="text-white hover:text-yellow-300">Personal Care</a></li>
                <li><a href="#" class="text-white hover:text-yellow-300">Member's Value</a></li>
                <li><a href="#" class="text-white hover:text-yellow-300">On Sale!</a></li>
                <li><a href="#" class="text-white hover:text-yellow-300">Pizza.com</a></li>
                <li><a href="#" class="text-white hover:text-yellow-300">Membership</a></li>
            </ul>
        </div>
    </nav>

    <section class="container mx-auto py-6 px-4 text-center">
    <h2 class="text-2xl font-semibold text-gray-800 mb-8">Explore Our Grocery Categories</h2>
    <div class="flex flex-wrap justify-center gap-8">
        <!-- Beverages -->
        <div class="category-card bg-white rounded-lg shadow-lg p-8 flex flex-col items-center justify-center hover:shadow-2xl transition-shadow duration-300 cursor-pointer w-64" onclick="openLoginModal('Beverages')">
            <img src="https://imgs.search.brave.com/Ya8ons9Se8D2gLAdZuOvsyjeHRLni5KhaAqWx9_Nhzo/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzA3LzUxLzE2LzE3/LzM2MF9GXzc1MTE2/MTcxMl9neEpMaDFK/NFplRlkyTTIxRDZx/R0lZeGRRWGlJU0Vh/MS5qcGc" alt="Beverages" class="rounded-md w-full h-60 object-cover mb-4">
            <h3 class="text-xl font-semibold text-gray-700 text-center">Beverages</h3>
        </div>

        <!-- Bread & Bakery -->
        <div class="category-card bg-white rounded-lg shadow-lg p-8 flex flex-col items-center justify-center hover:shadow-2xl transition-shadow duration-300 cursor-pointer w-64" onclick="openLoginModal('Bread & Bakery')">
            <img src="https://imgs.search.brave.com/DnEDm5AVnXbBAEV7P6hqpJluOwpF4hwXEJIKLsm3Xys/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/Zm9vZGFuZHdpbmUu/Y29tL3RobWIvTWly/TVJkdlN3NU1BazdL/WFg0NXBHOGhVSFpr/PS8xNTAweDAvZmls/dGVyczpub191cHNj/YWxlKCk6bWF4X2J5/dGVzKDE1MDAwMCk6/c3RyaXBfaWNjKCkv/YmVzdC1icmVhZC1v/c29uby1GVC1CTE9H/MDIyMi1lM2U3MmY0/MTJiYzA0YThlYTMz/N2VlNzAzMTA4MTg3/NS5qcGc" alt="Bread & Bakery" class="rounded-md w-full h-60 object-cover mb-4">
            <h3 class="text-xl font-semibold text-gray-700 text-center">Bread & Bakery</h3>
        </div>
    </div>
</section>


    <!-- Modal for Login/SignIn -->
    <div id="loginModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-80 relative mx-auto">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sign In</h2>
            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 mb-4 rounded-md border border-gray-300" required>
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 mb-4 rounded-md border border-gray-300" required>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Login</button>
            </form>
            <p class="text-center mt-4">Don't have an account? <a href="register.php" class="text-blue-500">Register here</a></p>
            <button onclick="closeLoginModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">X</button>
        </div>
    </div>

    <script>
        function openLoginModal(category) {
            console.log('Category clicked:', category);
            document.getElementById('loginModal').classList.remove('hidden');
        }
        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }
    </script>
</body>
</html>
