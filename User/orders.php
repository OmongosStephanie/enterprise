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

// Fetch orders with rider contact by joining riders table
$stmt = $conn->prepare("
    SELECT 
        o.id, o.fullname, o.branch, o.location, o.street, o.total, o.created_at, o.status, o.delivered_date, o.delivery_person,
        r.contact AS contact_number
    FROM orders o
    LEFT JOIN riders r ON o.delivery_person = r.name
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");
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
                            <th class="px-6 py-3">Action</th>
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
                                <td class="px-6 py-4 text-sm">
                                    <?php 
                                        if ($row['delivery_person']) {
                                            echo htmlspecialchars($row['delivery_person']);
                                            if ($row['contact_number']) {
                                                echo " <span class='text-gray-500'>(☎ " . htmlspecialchars($row['contact_number']) . ")</span>";
                                            }
                                        } else {
                                            echo "<span class='text-gray-500 italic'>Not Assigned</span>";
                                        }
                                    ?>
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
                                <td class="px-6 py-4">
                                    <?php if ($status == 'pending'): ?>
                                        <form action="cancel_order.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">Cancel</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">You have no orders yet.</p>
        <?php endif; ?>

        <!-- Back button -->
        <div class="mt-6 text-center">
            <a href="dashboard.php" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded">
                ← Back to Dashboard
            </a>
        </div>

        <?php
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
