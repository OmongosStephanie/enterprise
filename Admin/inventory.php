<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path as necessary

// Pagination setup
$limit = 10; // Number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Category selection (default category is 'Beverages')
$category = isset($_GET['category']) ? $_GET['category'] : 'Beverages';

// Modify query to filter by category
$sql = "SELECT * FROM inventory WHERE category = ? LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching data: " . $conn->error);
}

// Get total number of products for pagination
$total_sql = "SELECT COUNT(*) as total FROM inventory WHERE category = ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("s", $category);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white h-screen p-4">
            <h2 class="text-2xl font-bold mb-8">Admin</h2>
            <ul>
                <li><a href="dashboard.php" class="text-lg py-2 block">Dashboard</a></li>
                <li><a href="inventory.php" class="text-lg py-2 block bg-gray-700 rounded">Inventory</a></li>
                <li><a href="payments.php" class="text-lg py-2 block">Payments</a></li>
                <li><a href="customers.php" class="text-lg py-2 block">Customers</a></li>
                <li><a href="membership.php" class="text-lg py-2 block">Membership</a></li>
                <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-lg mb-8">
                <h2 class="text-2xl font-semibold">Inventory Management</h2>
                <div class="text-sm text-gray-500">📅 <?php echo date("M d, Y"); ?> | 👤 Admin</div>
            </div>

            <!-- Category Filter -->
            <div class="mb-6">
                <a href="?category=<?php echo urlencode('Beverages'); ?>" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Beverages</a>
                <a href="?category=<?php echo urlencode('Bread and Bakery'); ?>" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Bread and Bakery</a>
            </div>

            <!-- Inventory Table -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Inventory List (<?php echo htmlspecialchars($category); ?>)</h3>
                    <a href="add_product.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        ➕ Add Product
                    </a>
                </div>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3 text-left border-b">Product ID</th>
                            <th class="p-3 text-left border-b">Product Name</th>
                            <th class="p-3 text-left border-b">Quantity</th>
                            <th class="p-3 text-left border-b">Price</th>
                            <th class="p-3 text-left border-b">Image</th>
                            <th class="p-3 text-left border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['product_id']); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['product_name']); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['quantity']); ?></td>
                                    <td class="p-3 border-b"><?php echo number_format($row['price'], 2); ?></td>
                                    <td class="p-3 border-b">
                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Product Image" class="w-16 h-16 object-cover">
                                    </td>
                                    <td class="p-3 border-b">
                                        <a href="edit_inventory.php?id=<?php echo $row['product_id']; ?>" class="text-blue-600 hover:underline">Edit</a>
                                        <a href="delete_inventory.php?id=<?php echo $row['product_id']; ?>" class="text-red-600 ml-4 hover:underline">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="p-3 text-center">No inventory found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-6">
                <nav>
                    <ul class="flex space-x-4">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li>
                                <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>" class="px-4 py-2 border <?php echo ($i == $page) ? 'bg-blue-500 text-white' : 'text-blue-500'; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Close DB connection -->
    <?php $conn->close(); ?>
</body>
</html>
