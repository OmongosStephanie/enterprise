<?php
session_start();

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

$status_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $conn->real_escape_string($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $delivered_date = !empty($_POST['delivered_date']) ? "'" . $conn->real_escape_string($_POST['delivered_date']) . "'" : "NULL";
    $delivery_person = $conn->real_escape_string($_POST['delivery_person']);

    $sql_update = "UPDATE orders 
                   SET status = '$status', 
                       delivered_date = $delivered_date, 
                       delivery_person = '$delivery_person' 
                   WHERE id = '$order_id'";

    if ($conn->query($sql_update)) {
        $status_message = "Order #$order_id updated successfully.";
    } else {
        $status_message = "Failed to update order #$order_id: " . $conn->error;
    }
}

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_rows = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT id, fullname, branch, location, street, total, created_at, status, delivered_date, delivery_person 
        FROM orders 
        ORDER BY created_at DESC 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments - Staff Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex">
    <!-- Sidebar (Sticky) -->
    <div class="w-64 bg-gray-800 text-white h-screen p-4 fixed top-0 left-0">
        <h2 class="text-2xl font-bold mb-8">Staff</h2>
        <ul>
            <li><a href="dashboard.php" class="text-lg py-2 block">Dashboard</a></li>
            <li><a href="staff_financial.php" class="text-lg py-2 block">Financial Reports</a></li>
            <li><a href="payments.php" class="text-lg py-2 block bg-gray-700 rounded">Customer Orders</a></li>
            <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-4 ml-64">
        <div class="flex justify-between items-center bg-white p-3 rounded shadow mb-5 text-lg">
            <h2 class="text-2xl font-semibold">Management</h2>
            <div class="text-gray-600">📅 <?php echo date("M d, Y"); ?> | 👤 Staff</div>
        </div>

        <?php if (!empty($status_message)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-lg">
                <?php echo $status_message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-4 rounded shadow text-lg overflow-auto">
            <h3 class="text-xl font-semibold mb-3">Orders</h3>
            <table class="min-w-full table-auto border border-gray-300 text-base">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">Name</th>
                        <th class="p-3 border-b">Branch</th>
                        <th class="p-3 border-b">Location</th>
                        <th class="p-3 border-b">Street</th>
                        <th class="p-3 border-b">Total</th>
                        <th class="p-3 border-b">Date</th>
                        <th class="p-3 border-b">Status</th>
                        <th class="p-3 border-b">Delivered</th>
                        <th class="p-3 border-b">Rider</th>
                        <th class="p-3 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b"><?php echo $row['id']; ?></td>
                            <td class="p-3 border-b"><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td class="p-3 border-b"><?php echo htmlspecialchars($row['branch']); ?></td>
                            <td class="p-3 border-b"><?php echo htmlspecialchars($row['location']); ?></td>
                            <td class="p-3 border-b"><?php echo htmlspecialchars($row['street']); ?></td>
                            <td class="p-3 border-b font-semibold">₱<?php echo number_format($row['total'], 2); ?></td>
                            <td class="p-3 border-b"><?php echo date('M d', strtotime($row['created_at'])); ?></td>
                            <td class="p-3 border-b"><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="p-3 border-b">
                                <?php echo $row['delivered_date'] ? date('M d', strtotime($row['delivered_date'])) : "<span class='text-red-500'>No</span>"; ?>
                            </td>
                            <td class="p-3 border-b">
                                <?php echo htmlspecialchars($row['delivery_person']) ?: "<span class='text-gray-500'>None</span>"; ?>
                            </td>
                            <td class="p-3 border-b">
                                <form method="POST" class="flex flex-col space-y-2">
                                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                    <select name="status" class="border rounded p-2 text-base" required>
                                        <option value="pending" <?php echo $row['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="delivered" <?php echo $row['status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="completed" <?php echo $row['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    </select>
                                    <input type="date" name="delivered_date" class="border rounded p-2 text-base" value="<?php echo $row['delivered_date'] ? date('Y-m-d', strtotime($row['delivered_date'])) : ''; ?>">
                                    <input type="text" name="delivery_person" class="border rounded p-2 text-base" placeholder="Rider" value="<?php echo htmlspecialchars($row['delivery_person']); ?>">
                                    <button type="submit" class="bg-blue-500 text-white px-3 py-2 text-base rounded hover:bg-blue-600">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="11" class="text-center p-3 text-lg">No orders found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center space-x-2 text-lg">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" 
                   class="px-4 py-2 border rounded <?php echo $i == $page ? 'bg-blue-500 text-white' : 'bg-white text-blue-500'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</div>
</body>
</html>
