<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path as necessary

// Check if ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch data for the product
    $sql = "SELECT * FROM inventory WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found");
    }
} else {
    die("Product ID is missing");
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image_url = $_POST['image_url'];

    // Update the product
    $update_sql = "UPDATE inventory SET product_name = ?, price = ?, quantity = ?, image_url = ? WHERE product_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdiss", $product_name, $price, $quantity, $image_url, $product_id);

    if ($stmt->execute()) {
        echo "Product updated successfully.";
        // Redirect to inventory page after successful update
        header('Location: inventory.php');
        exit();
    } else {
        echo "Error updating product: " . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div class="flex">
        <div class="w-64 bg-gray-800 text-white h-screen p-4">
            <h2 class="text-2xl font-bold mb-8">Admin</h2>
            <ul>
                <li><a href="dashboard.php" class="text-lg py-2 block">Dashboard</a></li>
                <li><a href="inventory.php" class="text-lg py-2 block bg-gray-700 rounded">Inventory</a></li>
                <li><a href="payments.php" class="text-lg py-2 block">Payments</a></li>
                <li><a href="customers.php" class="text-lg py-2 block">Customers</a></li>
                <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-lg mb-8">
                <h2 class="text-2xl font-semibold">Edit Product</h2>
                <div class="text-sm text-gray-500">📅 <?php echo date("M d, Y"); ?> | 👤 Admin</div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Edit Product: <?php echo htmlspecialchars($product['product_name']); ?></h3>
                <form action="edit_inventory.php?id=<?php echo $product['product_id']; ?>" method="POST">
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm font-semibold mb-2">Product Name</label>
                        <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" class="w-full p-3 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-semibold mb-2">Price</label>
                        <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" class="w-full p-3 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-semibold mb-2">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" class="w-full p-3 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="image_url" class="block text-sm font-semibold mb-2">Image URL</label>
                        <input type="text" name="image_url" id="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>" class="w-full p-3 border border-gray-300 rounded" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg">Update Product</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>
