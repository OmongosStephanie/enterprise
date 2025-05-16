<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch memberships
$sql = "SELECT * FROM memberships LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching data: " . $conn->error);
}

// Get total for pagination
$total_sql = "SELECT COUNT(*) as total FROM memberships";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_memberships = $total_row['total'];
$total_pages = ceil($total_memberships / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Membership Management</title>
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
    .sidebar h2 {
        margin-bottom: 24px;
        font-size: 1.6rem;
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
    .sidebar a.active {
        background-color: #444;
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

    .table-container {
        background: #f3f4f6;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    th, td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    thead {
        background-color: #e5e7eb;
    }

    tr:hover {
        background-color: #f9fafb;
    }

    /* Pagination */
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .pagination a {
        padding: 8px 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
        text-decoration: none;
        color: #007bff;
        font-weight: 500;
    }

    .pagination a.active {
        background-color: #007bff;
        color: white;
    }

    .pagination a:hover {
        background-color: #e0e7ff;
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
        <a href="membership.php" class="active">Membership</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1>Membership Management</h1>

        <div class="table-container">
            <h2 style="margin-bottom: 16px;">Membership List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Membership ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Benefits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td>₱<?php echo number_format($row['price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['benefits']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center;">No memberships found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>
</body>
</html>
