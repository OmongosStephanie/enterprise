<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path as necessary

// Fetch customers and their feedbacks
$sql = "SELECT customers.id, customers.first_name, customers.last_name, customers.email, customers.phone_number, feedbacks.feedback, feedbacks.created_at 
        FROM customers 
        LEFT JOIN feedbacks ON customers.id = feedbacks.customer_id 
        ORDER BY customers.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Customers and Feedbacks - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Main Content -->
    <div class="p-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-6">Customer List and Feedback</h2>

            <?php if ($result->num_rows > 0): ?>
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">First Name</th>
                            <th class="px-4 py-2 border">Last Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Phone Number</th>
                            <th class="px-4 py-2 border">Feedback</th>
                            <th class="px-4 py-2 border">Feedback Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['first_name']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['last_name']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['feedback'] ?? 'No feedback provided'); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['created_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No customers found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>