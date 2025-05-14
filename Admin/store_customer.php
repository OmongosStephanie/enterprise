<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php';

// Handle deleting feedback
if (isset($_GET['delete_feedback'])) {
    $feedback_id = $_GET['delete_feedback'];

    // Delete feedback from the database
    $sql = "DELETE FROM feedbacks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {
        header('Location: manage_users_feedback.php'); // Refresh the page after deletion
        exit();
    } else {
        echo "Error deleting feedback: " . $conn->error;
    }
}

// Fetch users and their feedbacks
$sql = "SELECT customers.id, customers.name, customers.email, customers.created_at, feedbacks.id AS feedback_id, feedbacks.feedback, feedbacks.created_at AS feedback_date 
        FROM customers 
        LEFT JOIN feedbacks ON customers.id = feedbacks.customer_id 
        ORDER BY customers.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users and Feedbacks - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Main Content -->
    <div class="p-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-6">Manage Users and Feedbacks</h2>

            <?php if ($result->num_rows > 0): ?>
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Created At</th>
                            <th class="px-4 py-2 border">Feedback</th>
                            <th class="px-4 py-2 border">Feedback Date</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['feedback'] ?? 'No feedback provided'); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['feedback_date'] ?? 'N/A'); ?></td>
                                <td class="px-4 py-2 border">
                                    <?php if ($row['feedback_id']): ?>
                                        <a href="manage_users_feedback.php?delete_feedback=<?php echo $row['feedback_id']; ?>" class="text-red-500 hover:text-red-700">Delete Feedback</a>
                                    <?php else: ?>
                                        <span>No feedback</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
