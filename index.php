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
                <!-- Updated link to register.php -->
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

    <div class="container mx-auto py-4 px-4 text-gray-500 text-sm">
        <span><a href="#" class="hover:text-yellow-300">Home</a></span> /
        <span><a href="#" class="hover:text-yellow-300">Shop All Categories</a></span> /
        <span>Groceries</span>
    </div>
    
<section class="container mx-auto py-6 px-4">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Explore Our Grocery Categories</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        <!-- Category 1: Beverages -->
        <div class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow duration-200">
            <img src="https://via.placeholder.com/150" alt="Beverages" class="rounded-md mb-2">
            <h3 class="text-lg font-semibold text-gray-700">Beverages</h3>
        </div>
        <!-- Category 2: Bread & Bakery -->
        <div class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow duration-200">
            <img src="https://via.placeholder.com/150" alt="Bread & Bakery" class="rounded-md mb-2">
            <h3 class="text-lg font-semibold text-gray-700">Bread & Bakery</h3>
        </div>
        <!-- Category 3: Pantry Items -->
        <div class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow duration-200">
            <img src="https://via.placeholder.com/150" alt="Pantry Items" class="rounded-md mb-2">
            <h3 class="text-lg font-semibold text-gray-700">Pantry Items</h3>
        </div>
        <!-- Category 4: Eggs & Chilled Products -->
        <div class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow duration-200">
            <img src="https://via.placeholder.com/150" alt="Eggs & Chilled Products" class="rounded-md mb-2">
            <h3 class="text-lg font-semibold text-gray-700">Eggs & Chilled Products</h3>
        </div>
        <!-- Category 5: Fresh Meat, Produce & Seafood -->
        <div class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow duration-200">
            <img src="https://via.placeholder.com/150" alt="Fresh Meat, Produce & Seafood" class="rounded-md mb-2">
            <h3 class="text-lg font-semibold text-gray-700">Fresh Meat, Produce & Seafood</h3>
        </div>
        <!-- Category 6: Frozen Products -->
        <div class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center hover:shadow-lg transition-shadow duration-200">
            <img src="https://via.placeholder.com/150" alt="Frozen Products" class="rounded-md mb-2">
            <h3 class="text-lg font-semibold text-gray-700">Frozen Products</h3>
        </div>
    </div>
</section>
