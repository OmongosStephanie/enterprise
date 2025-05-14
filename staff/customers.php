<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path as necessary

// Fetch data from the users table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    die("Error fetching data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers - Staff Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div class="flex">
        <div class="w-64 bg-gray-800 text-white h-screen p-4">
            <h2 class="text-2xl font-bold mb-8">Staff</h2>
            <ul>
                <li><a href="dashboard.php" class="text-lg py-2 block">Dashboard</a></li>
                <li><a href="inventory.php" class="text-lg py-2 block">Inventory</a></li>
                <li><a href="payments.php" class="text-lg py-2 block">Payments</a></li>
                <li><a href="customers.php" class="text-lg py-2 block bg-gray-700 rounded">Customers</a></li>
                <li><a href="membership.php" class="text-lg py-2 block">Membership</a></li>
                <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-lg mb-8">
                <h2 class="text-2xl font-semibold">Customer Management</h2>
                <div class="text-sm text-gray-500">📅 <?php echo date("M d, Y"); ?> | 👤 Staff</div>
            </div>

            <!-- Customer Table -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Customer List</h3>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3 text-left border-b">First Name</th>
                            <th class="p-3 text-left border-b">Last Name</th>
                            <th class="p-3 text-left border-b">Email</th>
                            <th class="p-3 text-left border-b">Contact Number</th>
                            <th class="p-3 text-left border-b">Address</th>
                            <th class="p-3 text-left border-b">Birthday</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['first_name']); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['last_name']); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['contact_number']); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['address']); ?></td>
                                    <td class="p-3 border-b"><?php echo htmlspecialchars($row['birthday']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="p-3 text-center">No customers found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php $conn->close(); ?>

</body>
</html>
