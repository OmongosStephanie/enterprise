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

// Fetch total number of products from inventory
$sql_total_products = "SELECT COUNT(*) AS total_products FROM inventory";
$result_total_products = mysqli_query($conn, $sql_total_products);
$product_data = mysqli_fetch_assoc($result_total_products);

// Removed recent orders query as it's no longer needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Dashboard</title>
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
    /* Sidebar - unchanged */
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

    /* Content styles */
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

    /* Stats cards container */
    .stats {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }
    .stat-card {
        flex: 1 1 250px;
        background-color: #f3f4f6;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        text-align: center;
        transition: box-shadow 0.3s ease;
    }
    .stat-card:hover {
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    .stat-card h3 {
        font-size: 1.25rem;
        color: #374151;
        margin-bottom: 12px;
        font-weight: 700;
    }
    .stat-card p {
        font-size: 2.5rem;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats {
            flex-direction: column;
        }
        .stat-card {
            width: 100%;
        }
        .content {
            padding: 20px;
        }
    }
</style>
</head>
<body>

<div class="container">
    <!-- Sidebar: unchanged -->
    <div class="sidebar">
       <h2 class="text-xl font-semibold">Admin Dashboard</h2>
       <a href="dashboard.php">Dashboard</a>
       <a href="update_inventory.php">Manage Products</a>
       <a href="financial_report.php">Financial Report</a>
       <a href="customer.php">Customer</a>
       <a href="membership.php">Membership</a>
       <a href="logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Welcome, Admin</h1>

        <div class="stats">
            <div class="stat-card">
                <h3>Total Orders</h3>
                <p><?php echo $order_data['total_orders']; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Sales</h3>
                <p><?php echo '₱' . number_format($sales_data['total_sales'], 2); ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Products</h3>
                <p><?php echo $product_data['total_products']; ?></p>
            </div>
        </div>

        <!-- Recent Orders section removed -->

    </div>
</div>

</body>
</html>
