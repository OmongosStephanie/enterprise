<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
require_once '../includes/db.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Category selection
$category = isset($_GET['category']) ? $_GET['category'] : 'Beverages';

// Query to fetch inventory items by category with pagination
$sql = "SELECT * FROM inventory WHERE category = ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $category, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Total for pagination
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
<meta charset="UTF-8" />
<title>Inventory - Admin Panel</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
        margin: 0;
        padding: 0;
        color: #333;
    }
    .container {
        display: flex;
        min-height: 100vh;
    }
    .sidebar {
        width: 250px;
        background-color: #333;
        color: white;
        padding: 20px;
        height: 100vh;
        box-sizing: border-box;
    }
    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px 12px;
        margin: 8px 0;
        border-radius: 4px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    .sidebar a:hover {
        background-color: #444;
    }
    .sidebar h2 {
        margin-bottom: 24px;
        font-size: 1.6rem;
    }
    .content {
        flex-grow: 1;
        padding: 30px 40px;
        background: #fff;
        box-sizing: border-box;
        overflow-y: auto;
    }
    .content h1 {
        font-size: 2rem;
        margin-bottom: 30px;
        font-weight: 700;
        color: #111827;
    }
    .filter {
        margin-bottom: 20px;
    }
    .filter a {
        text-decoration: none;
        background: #2563eb;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        margin-right: 10px;
        font-weight: 500;
    }
    .filter a:nth-child(2) {
        background: #10b981;
    }
    .filter a:hover {
        opacity: 0.9;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    th, td {
        text-align: left;
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f3f4f6;
    }
    img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 6px;
    }
    .actions a {
        margin-right: 12px;
        text-decoration: none;
        font-weight: 600;
    }
    .actions a.edit {
        color: #2563eb;
    }
    .actions a.delete {
        color: #dc2626;
    }
    .add-btn {
        background-color: #10b981;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        float: right;
        margin-bottom: 20px;
    }
    .pagination {
        margin-top: 20px;
        text-align: center;
    }
    .pagination a {
        display: inline-block;
        margin: 0 5px;
        padding: 8px 14px;
        color: #2563eb;
        border: 1px solid #2563eb;
        border-radius: 4px;
        text-decoration: none;
    }
    .pagination a.active {
        background-color: #2563eb;
        color: white;
    }
</style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="update_inventory.php">Manage Products</a>
        <a href="financial_report.php">Financial Report</a>
        <a href="customer.php">Customer</a>
        <a href="membership.php">Membership</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1>Inventory Management</h1>

        <div class="filter">
            <a href="?category=Beverages">Beverages</a>
            <a href="?category=Bread and Bakery">Bread and Bakery</a>
        </div>

        <a href="add_product.php" class="add-btn">➕ Add Product</a>

        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['stock']); ?></td>
                            <td>₱<?php echo number_format($row['price'], 2); ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Product Image"></td>
                            <td class="actions">
                                <a href="edit_inventory.php?id=<?php echo $row['product_id']; ?>" class="edit">Edit</a>
                                <a href="delete_inventory.php?id=<?php echo $row['product_id']; ?>" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">No products found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</div>

<?php $conn->close(); ?>
</body>
</html>
