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
    <title>Beverages - S&R Online Shop</title>
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
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Explore Our Beverages</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">

            <!-- Coca-Cola -->
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
                <img src="https://imgs.search.brave.com/9Y6xC6W-UcL7pNVMiFcxScUDo_Bsawb_X4MuovU1zZs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA0LzM4LzY2Lzc0/LzM2MF9GXzQzODY2/NzQzMF95U2hxTW1Y/QXVIZWpsaEo5OW5S/dWJwZXhBbDE4cmZR/Zy5qcGc" alt="Soda" class="rounded-md w-full h-40 object-cover mb-3">
                <h3 class="text-lg font-semibold text-gray-700 text-center">Coca-Cola</h3>
                <p class="text-gray-500 mb-2">₱40.00</p>
                <button type="button" onclick="openModal('1', 'Coca-Cola', '40.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                    Add to Cart
                </button>
            </div>

            <!-- Tropicana -->
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
                <img src="https://imgs.search.brave.com/jdwga8zn-romqmvz6cSDrwKq9ieFKQUr0U6yTJ1OKEg/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pNS53/YWxtYXJ0aW1hZ2Vz/LmNvbS9zZW8vVHJv/cGljYW5hLVB1cmUt/UHJlbWl1bS1Pcmln/aW5hbC1Tb21lLVB1/bHAtMTAwLU9yYW5n/ZS1KdWljZS00Ni1m/bC1vei1Cb3R0bGVf/MzExNGJhMTktOWNk/Yy00MDM0LTg3ZmYt/NGE2OTU4MDUwNzg5/LmE4MDhlMjZmODk2/N2U1YWFkMTU3OWZj/MTAyNjM4YTc2Lmpw/ZWc_b2RuSGVpZ2h0/PTU4MCZvZG5XaWR0/aD01ODAmb2RuQmc9/RkZGRkZG" alt="Juice" class="rounded-md w-full h-40 object-cover mb-3">
                <h3 class="text-lg font-semibold text-gray-700 text-center">Tropicana Orange Juice</h3>
                <p class="text-gray-500 mb-2">₱60.00</p>
                <button type="button" onclick="openModal('2', 'Tropicana Orange Juice', '60.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                    Add to Cart
                </button>
            </div>
            <!-- Pepsi -->
        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
            <img src="https://imgs.search.brave.com/-jD_DT006zNLvrDulhzCZ8tVBwBMB65c07HSOlYZxf8/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvMTIz/NzA2MzAwMC9waG90/by9hLXBob3RvLW9m/LXBlcHNpLWJvdHRs/ZXMtc2Vlbi1kaXNw/bGF5ZWQtaW4tYS1z/dG9yZS5qcGc_cz02/MTJ4NjEyJnc9MCZr/PTIwJmM9MlZvZ0JY/Tl9WUy1DWjBYMVVv/alJENlhOZndlNmRD/TDNBR0oybXNydjNv/MD0" alt="Pepsi" class="rounded-md w-full h-40 object-cover mb-3">
            <h3 class="text-lg font-semibold text-gray-700 text-center">Pepsi</h3>
            <p class="text-gray-500 mb-2">₱55.00</p>
            <button type="button" onclick="openModal('3', 'Pepsi', '55.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                Add to Cart
            </button>
        </div>

        <!-- Sprite -->
        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
            <img src="https://imgs.search.brave.com/e0ujq3SLmOVrsr76UgpUh7aDomXRaPhGT5Ss8eMBtIg/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvNTEz/OTMyNzI0L3Bob3Rv/L3Nwcml0ZS1jYW4t/YW5kLXBsYXN0aWMt/Ym90dGxlLmpwZz9z/PTYxMng2MTImdz0w/Jms9MjAmYz12QW5r/cTdBUEVQZzdmSXFl/MFVRUlAweGwyM1ZE/NXZ5cWJMM0RaUm9D/R1JZPQ" alt="Sprite" class="rounded-md w-full h-40 object-cover mb-3">
            <h3 class="text-lg font-semibold text-gray-700 text-center">Sprite</h3>
            <p class="text-gray-500 mb-2">₱25.00</p>
            <button type="button" onclick="openModal('4', 'Sprite', '25.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                Add to Cart
            </button>
        </div>

        <!-- 7UP -->
        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
            <img src="https://imgs.search.brave.com/V5LfcmFJ9dSINddJ1cbZY9j8pIEuQbo8dGC-klwfsCg/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvNTMx/NDE3NDY2L3Bob3Rv/L2Nhbi1vZi03dXAu/anBnP3M9NjEyeDYx/MiZ3PTAmaz0yMCZj/PUJEemdxUjB0eTVf/YjRWOHR0Zzc3bDE5/MGh5WTA3amJvMzB2/QnduQkdPVlU9" alt="7UP" class="rounded-md w-full h-40 object-cover mb-3">
            <h3 class="text-lg font-semibold text-gray-700 text-center">7UP</h3>
            <p class="text-gray-500 mb-2">₱35.00</p>
            <button type="button" onclick="openModal('5', '7UP', '35.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
                Add to Cart
            </button>
        </div>

        <!-- Mountain Dew -->
        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center justify-center hover:shadow-xl transition-shadow duration-300">
            <img src="https://imgs.search.brave.com/_NO5kJII2K0vyW8KM6kbPFkiBhUmW31VRrSg4OLHMVE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/aGFyZG1vdW50YWlu/ZGV3LmNvbS9Db250/ZW50L19pbWcvc3dp/cGVyQ2FuX09yaWdp/bmFsLnBuZw" alt="Mountain Dew" class="rounded-md w-full h-40 object-cover mb-3">
            <h3 class="text-lg font-semibold text-gray-700 text-center">Mountain Dew</h3>
            <p class="text-gray-500 mb-2">₱50.00</p>
            <button type="button" onclick="openModal('6', 'Mountain Dew', '50.00')" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-4 py-2 focus:outline-none">
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
