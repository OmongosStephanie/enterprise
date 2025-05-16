<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("Product ID is missing");
}

$product_id = $_GET['id'];

// Fetch product data
$sql = "SELECT * FROM inventory WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Product not found");
}

$product = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image_url = $_POST['image_url'];

    $update_sql = "UPDATE inventory SET product_name = ?, price = ?, stock = ?, image_url = ? WHERE product_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdiss", $product_name, $price, $stock, $image_url, $product_id);

    if ($stmt->execute()) {
        header('Location: update_inventory.php');
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

<div class="min-h-screen flex flex-col justify-center items-center p-6">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Edit Product</h2>
            <div class="text-sm text-gray-500">📅 <?php echo date("M d, Y"); ?> | 👤 Admin</div>
        </div>

        <!-- Back Button -->
        <div class="mb-6">
            <a href="update_inventory.php" class="inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">← Back</a>
        </div>

        <h3 class="text-xl font-semibold mb-4">Editing: <?php echo htmlspecialchars($product['product_name']); ?></h3>

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
                <label for="stock" class="block text-sm font-semibold mb-2">Stock</label>
                <input type="number" name="stock" id="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="image_url" class="block text-sm font-semibold mb-2">Image URL</label>
                <input type="text" name="image_url" id="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>" class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">Update Product</button>
        </form>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
