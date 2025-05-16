<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "online_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders
$stmt = $conn->prepare("SELECT id, fullname, branch, location, street, total, created_at, status, delivered_date, delivery_person FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - S&R</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-6xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-8">🧾 My Orders</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full table-auto text-left border-collapse">
                    <thead class="bg-blue-100 text-blue-800 uppercase text-sm">
                        <tr>
                            <th class="px-6 py-3">Order ID</th>
                            <th class="px-6 py-3">Full Name</th>
                            <th class="px-6 py-3">Branch</th>
                            <th class="px-6 py-3">Location</th>
                            <th class="px-6 py-3">Total (₱)</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Delivered Date</th>
                            <th class="px-6 py-3">Delivery Person</th>
                            <th class="px-6 py-3">Order Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4"><?php echo htmlspecialchars($row['id']); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($row['fullname']); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($row['branch']); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($row['location']); ?></td>
                                <td class="px-6 py-4 font-semibold">₱<?php echo number_format($row['total'], 2); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php
                                        if ($row['delivered_date']) {
                                            echo date('M d, Y', strtotime($row['delivered_date']));
                                        } else {
                                            echo "<span class='text-red-500'>Not Delivered</span>";
                                        }
                                    ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo htmlspecialchars($row['delivery_person']) ?: "<span class='text-gray-500'>Not Assigned</span>"; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php 
                                        $status = strtolower($row['status']);
                                        if ($status == 'pending') {
                                            echo "<span class='text-yellow-500 font-semibold capitalize'>Pending</span>";
                                        } elseif ($status == 'delivered') {
                                            echo "<span class='text-green-500 font-semibold capitalize'>Delivered</span>";
                                        } elseif ($status == 'completed') {
                                            echo "<span class='text-green-500 font-semibold capitalize'>Completed</span>";

                                          
} elseif ($status == 'cancelled') {
echo "<span class='text-red-500 font-semibold capitalize'>Cancelled</span>";
} else {
echo "<span class='capitalize'>{$row['status']}</span>";
}
?>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
<?php else: ?>
<p class="text-center text-gray-600">You have no orders yet.</p>
<?php endif; ?>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</div>
</body> </html> 