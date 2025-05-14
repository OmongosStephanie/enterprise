<?php
// Include the database connection
include('../includes/db.php');

// Check if 'user_id' is set in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch orders placed by the given user
    $sql_order_details = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
    $result_order_details = mysqli_query($conn, $sql_order_details);

    // Check if the query is successful
    if (!$result_order_details) {
        die("Error: " . mysqli_error($conn));
    }
    
    // Fetch user details
    $sql_user_details = "SELECT * FROM users WHERE id = $user_id";
    $result_user_details = mysqli_query($conn, $sql_user_details);
    $user_data = mysqli_fetch_assoc($result_user_details);
} else {
    echo "User ID not specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .user-details {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        .back-button {
            margin-bottom: 20px;
        }
        .back-button button {
            padding: 10px 20px;
            font-size: 14px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-button button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<!-- Back Button -->
<div class="back-button">
    <button onclick="window.history.back()">← Back</button>
</div>

<!-- User Details -->
<div class="user-details">
    <h1>Order Details for User: <?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?></h1>
    <p><strong>Full Name:</strong> <?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?></p>
    <p><strong>Location:</strong> <?php echo $user_data['address']; ?></p>
</div>

<!-- Orders Table -->
<h2>Orders</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Total Amount</th>
            <th>Payment Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($order = mysqli_fetch_assoc($result_order_details)) { ?>
            <tr>
                <td><?php echo $order['id']; // This is the actual order's primary key ?></td>
                <td><?php echo '$' . number_format($order['total'], 2); ?></td>
                <td><?php echo ucfirst($order['payment_status']); ?></td>
                <td><?php echo $order['created_at']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
