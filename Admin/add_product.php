<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path as necessary

// Initialize variables
$product_name = $category = $quantity = $price = $image_url = "";
$product_name_err = $category_err = $quantity_err = $price_err = $image_url_err = "";

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

    if (empty($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
        $quantity_err = "Valid quantity is required.";
    } else {
        $quantity = $_POST['quantity'];
    }

    if (empty($_POST['price']) || !is_numeric($_POST['price'])) {
        $price_err = "Valid price is required.";
    } else {
        $price = $_POST['price'];
    }

    // Handle file upload for image
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $image_url = 'uploads/' . basename($_FILES['image_url']['name']);
        if (!move_uploaded_file($_FILES['image_url']['tmp_name'], '../' . $image_url)) {
            $image_url_err = "Failed to upload image.";
        }
    } else {
        $image_url_err = "Product image is required.";
    }

    // Insert product into database if there are no errors
    if (empty($product_name_err) && empty($category_err) && empty($quantity_err) && empty($price_err) && empty($image_url_err)) {
        $sql = "INSERT INTO inventory (product_name, category, quantity, price, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssids", $product_name, $category, $quantity, $price, $image_url);
        if ($stmt->execute()) {
            header('Location: update_inventory.php'); // Redirect to inventory management page
            exit();
        } else {
            echo "Error adding product: " . $conn->error;
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
    <div class="flex justify-center items-center min-h-screen">
        <!-- Main Content (Card Style) -->
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-semibold mb-6 text-center">Add New Product</h2>

            <!-- Form -->
            <form action="add_product.php" method="POST" enctype="multipart/form-data">
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
                        <option value="Beverages" <?php echo ($category == 'Beverages') ? 'selected' : ''; ?>>Beverages</option>
                        <option value="Bread and Bakery" <?php echo ($category == 'Bread and Bakery') ? 'selected' : ''; ?>>Bread and Bakery</option>
                        <!-- Add more categories as needed -->
                    </select>
                    <span class="text-red-500 text-sm"><?php echo $category_err; ?></span>
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="w-full p-3 border border-gray-300 rounded" value="<?php echo htmlspecialchars($quantity); ?>" placeholder="Enter quantity">
                    <span class="text-red-500 text-sm"><?php echo $quantity_err; ?></span>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Price</label>
                    <input type="number" name="price" id="price" class="w-full p-3 border border-gray-300 rounded" value="<?php echo htmlspecialchars($price); ?>" placeholder="Enter price">
                    <span class="text-red-500 text-sm"><?php echo $price_err; ?></span>
                </div>

                <!-- Product Image -->
                <div class="mb-4">
                    <label for="image_url" class="block text-gray-700">Product Image</label>
                    <input type="file" name="image_url" id="image_url" class="w-full p-3 border border-gray-300 rounded">
                    <span class="text-red-500 text-sm"><?php echo $image_url_err; ?></span>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700 transition">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
