<?php
session_start();

// Add to Cart Logic
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = isset($_POST['product_quantity']) ? (int)$_POST['product_quantity'] : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product is already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += $product_quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity
        ];
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bread & Bakery - S&R Online Shop</title>
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
                <button class="bg-blue-500 hover:bg-blue-600 text-white rounded-r-md px-4 py-2 focus:outline-none">Search</button>
            </div>
            <a href="cart.php" class="text-white">Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a>
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


<!-- Back to Dashboard Button -->
<div class="container mx-auto px-4 mt-4">
    <a href="dashboard.php" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-semibold px-4 py-2 rounded">
        ← Back
    </a>
</div>

<section class="container mx-auto py-6 px-4">


    <section class="container mx-auto py-6 px-4">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Explore Our Bread & Bakery</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">

            <!-- Whole Wheat Bread -->
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
                <img src="https://imgs.search.brave.com/fBqIPDeN8gu3Ds2yTO9PdoxzN0vZXE_6tWkzPORwFso/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTU1/MTM2OTM3L3Bob3Rv/L3dob2xlLXdoZWF0/LWJyZWFkLXdpdGgt/c2VlZHMuanBnP3M9/NjEyeDYxMiZ3PTAm/az0yMCZjPWlsc0h2/OEZwdzNZMW9jMFFz/U1BET0Z6blVsX2F0/eW03N3B4MEQ0Z1gt/MEk9" alt="Whole Wheat Bread" class="rounded-md w-full h-40 object-cover mb-3">
                <h3 class="text-lg font-semibold text-gray-700 text-center">Whole Wheat Bread</h3>
                <p class="text-gray-500 mb-2">₱35.00</p>
                <button type="button" onclick="openModal('1', 'Whole Wheat Bread', '35.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                    Add to Cart
                </button>
            </div>

            <!-- Croissant -->
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
                <img src="https://imgs.search.brave.com/33AGzk7j-MEg4ldfcICoHhZNYGVhYkr766i31pJ6Sjo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzAwLzQ1Lzc4LzEy/LzM2MF9GXzQ1Nzgx/MjkwX1dha1N5VW9t/SEtURmswaVlwVHNk/c1ZLVnpaN1RrZ0I2/LmpwZw" alt="Croissant" class="rounded-md w-full h-40 object-cover mb-3">
                <h3 class="text-lg font-semibold text-gray-700 text-center">Croissant</h3>
                <p class="text-gray-500 mb-2">₱50.00</p>
                <button type="button" onclick="openModal('2', 'Croissant', '50.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                    Add to Cart
                </button>
            </div>

            <!-- Baguette -->
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
                <img src="https://imgs.search.brave.com/98UqRUuA3kx-j4Fb7q61EvUqnzF_sLiPdqK9EqGL2pg/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvNTA0/NDgyMjMzL3Bob3Rv/L2ZyZW5jaC1iYWd1/ZXR0ZXMuanBnP3M9/NjEyeDYxMiZ3PTAm/az0yMCZjPUdiRDhx/MVR3aVA0U29wSDZI/d0N4U3ZsYWQtUWlT/U2k3c0RqU0k3VHp6/MGM9" alt="Baguette" class="rounded-md w-full h-40 object-cover mb-3">
                <h3 class="text-lg font-semibold text-gray-700 text-center">Baguette</h3>
                <p class="text-gray-500 mb-2">₱40.00</p>
                <button type="button" onclick="openModal('3', 'Baguette', '40.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                    Add to Cart
                </button>
            </div>

            <!-- Banana Bread -->
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
                <img src="https://imgs.search.brave.com/9k_cshuQGBzITeaGJvAKOoZrdArKyztPsZVing-u_hc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzAwLzg3LzIyLzIx/LzM2MF9GXzg3MjIy/MTA5Xzh2NDVPa2ht/Rm9kWGFBaUpkN29t/dk55am1ITUN4OTd2/LmpwZw" alt="Banana Bread" class="rounded-md w-full h-40 object-cover mb-3">
                <h3 class="text-lg font-semibold text-gray-700 text-center">Banana Bread</h3>
                <p class="text-gray-500 mb-2">₱45.00</p>
                <button type="button" onclick="openModal('4', 'Banana Bread', '45.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                    Add to Cart
                </button>
            </div>

        </div>
    </section>

    <!-- Modal -->
    <div id="addToCartModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg w-80">
            <h2 class="text-lg font-semibold text-gray-800 mb-4" id="modalProductName">Product Name</h2>
            <form method="POST">
                <input type="hidden" name="product_id" id="modalProductId">
                <input type="hidden" name="product_name" id="modalProductNameInput">
                <input type="hidden" name="product_price" id="modalProductPrice">

                <label for="quantity" class="block text-sm text-gray-700 mb-2">Quantity:</label>
                <input type="number" name="product_quantity" id="productQuantity" value="1" min="1" class="w-full border border-gray-300 px-3 py-2 rounded-md mb-4">

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" name="add_to_cart" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        function openModal(id, name, price) {
            document.getElementById('modalProductId').value = id;
            document.getElementById('modalProductNameInput').value = name;
            document.getElementById('modalProductPrice').value = price;
            document.getElementById('modalProductName').textContent = name;
            document.getElementById('productQuantity').value = 1;
            document.getElementById('addToCartModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addToCartModal').classList.add('hidden');
        }
    </script>
</body>
</html>
