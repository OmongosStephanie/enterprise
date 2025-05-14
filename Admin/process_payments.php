<?php
include('../includes/db.php');

// Fetch all pending payments
$sql_pending_orders = "SELECT * FROM orders WHERE payment_status = 'Pending' ORDER BY created_at DESC";
$result_pending_orders = mysqli_query($conn, $sql_pending_orders);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payments</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="process_payments.php">Process Payments</a>
        <a href="update_inventory.php">Manage Products</a>
        <a href="store_customer.php">Manage Users</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Process Pending Payments</h1>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <p class="success">✅ Payment marked as Paid successfully!</p>
        <?php elseif (isset($_GET['success']) && $_GET['success'] == 0): ?>
            <p class="error">❌ Failed to update payment status.</p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_pending_orders) > 0): ?>
                    <?php while ($order = mysqli_fetch_assoc($result_pending_orders)) { ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['user_id']; ?></td>
                            <td><?php echo '$' . number_format($order['total'], 2); ?></td>
                            <td><?php echo ucfirst($order['status']); ?></td>
                            <td><?php echo ucfirst($order['payment_status']); ?></td>
                            <td>
                                <form method="POST" action="update_payment_status.php">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit">Mark as Paid</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr><td colspan="6">No pending payments found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
