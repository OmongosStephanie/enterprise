<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path as necessary

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    // Simple validation
    if (empty($product_name) || empty($category) || empty($quantity) || empty($price) || empty($image_url)) {
        $error_message = "All fields are required.";
    } else {
        // Insert product into the database
        $sql = "INSERT INTO inventory (product_name, category, quantity, price, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssids", $product_name, $category, $quantity, $price, $image_url);
        
        if ($stmt->execute()) {
            // Redirect to inventory page after successful insertion
            header('Location: inventory.php');
            exit();
        } else {
            $error_message = "Error adding product: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white h-screen p-4">
            <h2 class="text-2xl font-bold mb-8">Admin</h2>
            <ul>
                <li><a href="dashboard.php" class="text-lg py-2 block">Dashboard</a></li>
                <li><a href="inventory.php" class="text-lg py-2 block">Inventory</a></li>
                <li><a href="payments.php" class="text-lg py-2 block">Payments</a></li>
                <li><a href="customers.php" class="text-lg py-2 block">Customers</a></li>
                <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-lg mb-8">
                <h2 class="text-2xl font-semibold">Add New Product</h2>
                <div class="text-sm text-gray-500">📅 <?php echo date("M d, Y"); ?> | 👤 Admin</div>
            </div>

            <!-- Add Product Form -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <?php if (isset($error_message)): ?>
                    <div class="text-red-600 mb-4"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="add_product.php">
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm font-semibold">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="w-full p-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-sm font-semibold">Category</label>
                        <select name="category" id="category" class="w-full p-2 border rounded">
                            <option value="Beverages">Beverages</option>
                            <option value="Bread and Bakery">Bread and Bakery</option>
                            <option value="Pantry Items">Pantry Items</option>
                            <option value="Eggs and Chilled Products">Eggs and Chilled Products</option>
                            <option value="Fresh Meat Produce and Seafood">Fresh Meat Produce and Seafood</option>
                            <option value="Frozen Products">Frozen Products</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-semibold">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="w-full p-2 border rounded" required min="1">
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-semibold">Price</label>
                        <input type="number" name="price" id="price" class="w-full p-2 border rounded" required min="0" step="0.01">
                    </div>

                    <div class="mb-4">
                        <label for="image_url" class="block text-sm font-semibold">Image URL</label>
                        <input type="text" name="image_url" id="image_url" class="w-full p-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Close DB connection -->
    <?php $conn->close(); ?>
</body>
</html>
