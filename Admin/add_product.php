<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php';

// Initialize variables
$product_name = $category = $stock = $price = $image_url = "";
$product_name_err = $category_err = $stock_err = $price_err = $image_url_err = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input fields
    if (empty($_POST['product_name'])) {
        $product_name_err = "Product name is required.";
    } else {
        $product_name = $_POST['product_name'];
    }

    if (empty($_POST['category'])) {
        $category_err = "Category is required.";
    } else {
        $category = $_POST['category'];
    }

    if (empty($_POST['stock']) || !is_numeric($_POST['stock'])) {
        $stock_err = "Valid stock is required.";
    } else {
        $stock = $_POST['stock'];
    }

    if (empty($_POST['price']) || !is_numeric($_POST['price'])) {
        $price_err = "Valid price is required.";
    } else {
        $price = $_POST['price'];
    }

    if (empty($_POST['image_url'])) {
        $image_url_err = "Image URL is required.";
    } else {
        $image_url = $_POST['image_url'];
    }

    // Check for duplicate product name
    if (empty($product_name_err) && empty($category_err) && empty($stock_err) && empty($price_err) && empty($image_url_err)) {
        $check_sql = "SELECT product_id FROM inventory WHERE product_name = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $product_name);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $product_name_err = "Product name already exists in the inventory.";
        } else {
            // Insert product into database
            $sql = "INSERT INTO inventory (product_name, category, stock, price, image_url) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssids", $product_name, $category, $stock, $price, $image_url);
            if ($stmt->execute()) {
                header('Location: update_inventory.php');
                exit();
            } else {
                echo "Error adding product: " . $conn->error;
            }
        }

        $check_stmt->close();
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
    <div class="flex justify-center items-center min-h-screen">
        <!-- Main Content (Card Style) -->
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-semibold mb-6 text-center">Add New Product</h2>

            <!-- Form -->
            <form action="add_product.php" method="POST">
                <!-- Product Name -->
                <div class="mb-4">
                    <label for="product_name" class="block text-gray-700">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="w-full p-3 border border-gray-300 rounded" value="<?php echo htmlspecialchars($product_name); ?>" placeholder="Enter product name">
                    <span class="text-red-500 text-sm"><?php echo $product_name_err; ?></span>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="category" class="block text-gray-700">Category</label>
                    <select name="category" id="category" class="w-full p-3 border border-gray-300 rounded">
                        <option value="">-- Select Category --</option>
                        <option value="Beverages" <?php echo ($category == 'Beverages') ? 'selected' : ''; ?>>Beverages</option>
                        <option value="Bread and Bakery" <?php echo ($category == 'Bread and Bakery') ? 'selected' : ''; ?>>Bread and Bakery</option>
                        <option value="Pantry Items" <?php echo ($category == 'Pantry Items') ? 'selected' : ''; ?>>Pantry Items</option>
                        <option value="Eggs and Chilled Products" <?php echo ($category == 'Eggs and Chilled Products') ? 'selected' : ''; ?>>Eggs and Chilled Products</option>
                        <option value="Fresh Meat Produce and Seafood" <?php echo ($category == 'Fresh Meat Produce and Seafood') ? 'selected' : ''; ?>>Fresh Meat Produce and Seafood</option>
                        <option value="Frozen Products" <?php echo ($category == 'Frozen Products') ? 'selected' : ''; ?>>Frozen Products</option>
                    </select>
                    <span class="text-red-500 text-sm"><?php echo $category_err; ?></span>
                </div>

                <!-- Stock -->
                <div class="mb-4">
                    <label for="stock" class="block text-gray-700">Stock</label>
                    <input type="number" name="stock" id="stock" class="w-full p-3 border border-gray-300 rounded" value="<?php echo htmlspecialchars($stock); ?>" placeholder="Enter stock">
                    <span class="text-red-500 text-sm"><?php echo $stock_err; ?></span>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Price</label>
                    <input type="number" step="0.01" name="price" id="price" class="w-full p-3 border border-gray-300 rounded" value="<?php echo htmlspecialchars($price); ?>" placeholder="Enter price">
                    <span class="text-red-500 text-sm"><?php echo $price_err; ?></span>
                </div>

                <!-- Image URL -->
                <div class="mb-4">
                    <label for="image_url" class="block text-gray-700">Product Image URL</label>
                    <input type="text" name="image_url" id="image_url" class="w-full p-3 border border-gray-300 rounded" value="<?php echo htmlspecialchars($image_url); ?>" placeholder="Enter image URL">
                    <span class="text-red-500 text-sm"><?php echo $image_url_err; ?></span>
                </div>

                <!-- Image Preview -->
                <?php if (!empty($image_url)): ?>
                <div class="mb-4 text-center">
                    <img src="<?php echo htmlspecialchars($image_url); ?>" alt="Preview" class="mx-auto max-h-40 object-contain border rounded">
                </div>
                <?php endif; ?>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700 transition">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
