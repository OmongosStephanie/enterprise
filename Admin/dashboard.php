<?php
// Include the database connection
include('../includes/db.php');

// Fetch total orders and total sales
$sql_total_orders = "SELECT COUNT(*) AS total_orders FROM orders";
$result_total_orders = mysqli_query($conn, $sql_total_orders);
$order_data = mysqli_fetch_assoc($result_total_orders);

$sql_total_sales = "SELECT SUM(total) AS total_sales FROM orders";
$result_total_sales = mysqli_query($conn, $sql_total_sales);
$sales_data = mysqli_fetch_assoc($result_total_sales);

// ✅ Fetch total number of products
$sql_total_products = "SELECT COUNT(*) AS total_products FROM products";
$result_total_products = mysqli_query($conn, $sql_total_products);
$product_data = mysqli_fetch_assoc($result_total_products);

// Fetch recent orders, sorted by created_at
$sql_recent_orders = "SELECT * FROM orders ORDER BY created_at DESC LIMIT 5";
$result_recent_orders = mysqli_query($conn, $sql_recent_orders);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin: 5px 0;
        }
        .sidebar a:hover {
            background-color: #444;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .stat-card {
            background-color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 30%;
            text-align: center;
        }
        .stat-card h3 {
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="Process_payments.php">Process Payments</a>
        <a href="update_inventory.php">Manage Products</a>
        <a href="store_customer.php">Manage Users</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Welcome, Admin</h1>
        <div style="display: flex; flex-wrap: wrap;">
            <!-- Total Orders -->
            <div class="stat-card">
                <h3>Total Orders</h3>
                <p><?php echo $order_data['total_orders']; ?></p>
            </div>

            <!-- Total Sales -->
            <div class="stat-card">
                <h3>Total Sales</h3>
                <p><?php echo '$' . number_format($sales_data['total_sales'], 2); ?></p>
            </div>

            <!-- Total Products -->
            <div class="stat-card">
                <h3>Total Products</h3>
                <p><?php echo $product_data['total_products']; ?></p>
            </div>
        </div>

        <!-- Quick Overview of Recent Orders -->
        <h2>Recent Orders</h2>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($result_recent_orders)) { ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['user_id']; ?></td>
                        <td><?php echo '$' . number_format($order['total'], 2); ?></td>
                        <td><?php echo ucfirst($order['payment_status']); ?></td>
                        <td>
                            <a href="admin_order_details.php?user_id=<?php echo $order['user_id']; ?>">View</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
