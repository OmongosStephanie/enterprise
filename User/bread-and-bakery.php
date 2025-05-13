<?php
session_start();
require_once '../includes/db.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch Bread and Bakery from Inventory
$sql = "SELECT * FROM inventory WHERE category = 'Bread and Bakery' LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
if (!$result) {
    die("Error fetching data: " . $conn->error);
}

// Count total bread and bakery items for pagination
$total_sql = "SELECT COUNT(*) as total FROM inventory WHERE category = 'Bread and Bakery'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bread and Bakery - S&R Online Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Open the modal when Add to Cart is clicked
        function openCartModal(productId, productName, productPrice, maxQty) {
            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('modalProductPrice').value = productPrice;

            const qtyInput = document.getElementById('modalQuantity');
            qtyInput.max = maxQty;
            qtyInput.value = 1;

            document.getElementById('cartModal').classList.remove('hidden');
            document.getElementById('cartModal').classList.add('flex');
        }

        // Close the modal
        function closeCartModal() {
            document.getElementById('cartModal').classList.add('hidden');
            document.getElementById('cartModal').classList.remove('flex');
        }

        // Submit the data to the cart.php for adding item
        function submitToCart() {
            const productId = document.getElementById('modalProductId').value;
            const productName = document.getElementById('modalProductName').textContent;
            const productPrice = document.getElementById('modalProductPrice').value;
            const quantity = document.getElementById('modalQuantity').value;

            const formData = new FormData();
            formData.append('add_to_cart', '1');
            formData.append('product_id', productId);
            formData.append('product_name', productName);
            formData.append('product_price', productPrice);
            formData.append('product_quantity', quantity);

            fetch('cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("Item added to cart!");
            })
            .catch(error => {
                alert("Error adding item to cart.");
            });

            closeCartModal();
        }
    </script>
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

    <!-- Sidebar Navigation -->
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

    <!-- Main Content -->
    <div class="flex-1 ml-6">
        <!-- Back Button -->
        <div class="container mx-auto px-4 mt-4">
            <a href="dashboard.php" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-semibold px-4 py-2 rounded">
                ← Back
            </a>
        </div>

        <!-- Product Display -->
        <main class="container mx-auto py-6 px-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Explore Our Bread and Bakery</h2>

            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition duration-300 flex flex-col items-center text-center">
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Product" class="w-28 h-28 object-cover mb-4 rounded-md">
                            <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($row['product_name']) ?></h3>
                            <p class="text-blue-600 font-bold text-lg mt-1">₱<?= number_format($row['price'], 2) ?></p>
                            <p class="text-sm text-gray-500 mb-4">In stock: <?= $row['quantity'] ?></p>

                            <?php if ($row['quantity'] > 0): ?>
                                <button 
                                    onclick="openCartModal(
                                        '<?= $row['product_id'] ?>', 
                                        '<?= htmlspecialchars($row['product_name']) ?>', 
                                        '<?= $row['price'] ?>', 
                                        <?= $row['quantity'] ?>
                                    )"
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-md transition"
                                >
                                    Add to Cart
                                </button>
                            <?php else: ?>
                                <span class="text-red-500 font-semibold mt-2">Out of Stock</span>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center col-span-full text-gray-500">No bread and bakery products found.</p>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="flex justify-center mt-10">
                    <nav class="inline-flex space-x-2">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?= $i ?>" class="px-4 py-2 border rounded-md <?= $i === $page ? 'bg-blue-500 text-white' : 'bg-white text-blue-500 hover:bg-blue-100' ?> transition">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </nav>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modal for Quantity Adjustment -->
    <div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80">
            <h2 class="text-xl font-semibold mb-2" id="modalProductName">Product</h2>
            <input type="number" id="modalQuantity" min="1" value="1" class="w-full p-2 border rounded mb-4">
            <div class="flex justify-end space-x-2">
                <button onclick="closeCartModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cancel</button>
                <button onclick="submitToCart()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">OK</button>
            </div>
            <input type="hidden" id="modalProductId">
            <input type="hidden" id="modalProductPrice">
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6 mt-16">
        <p>&copy; 2025 S & R Online Shop. All rights reserved.</p>
    </footer>

    <?php $conn->close(); ?>
</body>
</html>
