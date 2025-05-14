<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path as necessary

// Pagination setup
$limit = 10; // Number of memberships per page
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

// Get total number of memberships for pagination
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
    <meta charset="UTF-8">
    <title>Memberships - Staff Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white h-screen p-4">
            <h2 class="text-2xl font-bold mb-8">Staff</h2>
            <ul>
                <li><a href="dashboard.php" class="text-lg py-2 block">Dashboard</a></li>
                <li><a href="inventory.php" class="text-lg py-2 block">Inventory</a></li>
                <li><a href="payments.php" class="text-lg py-2 block">Payments</a></li>
                <li><a href="customers.php" class="text-lg py-2 block">Customers</a></li>
                <li><a href="membership.php" class="text-lg py-2 block bg-gray-700 rounded">Membership</a></li>
                <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-lg mb-8">
                <h2 class="text-2xl font-semibold">Membership Management</h2>
                <div class="text-sm text-gray-500">📅 <?php echo date("M d, Y"); ?> | 👤 Staff</div>
            </div>

            <!-- Membership Table -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Membership List</h3>
                </div>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3 text-left border-b">Membership ID</th>
                            <th class="p-3 text-left border-b">Name</th>
                            <th class="p-3 text-left border-b">Price</th>
                            <th class="p-3 text-left border-b">Benefits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="p-3 border-b">₱<?php echo number_format($row['price'], 2); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['benefits']); ?></td>

                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-3 text-center">No memberships found</td>
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
                                <a href="?page=<?php echo $i; ?>" class="px-4 py-2 border <?php echo ($i == $page) ? 'bg-blue-500 text-white' : 'text-blue-500'; ?>"><?php echo $i; ?></a>
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
