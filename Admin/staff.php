<?php
session_start();

// Check if admin is logged in (adjust to staff session if needed)
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path if needed

// Fetch staff users from the database
$sql = "SELECT * FROM staff";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Staff Management - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            margin: 0; padding: 0; color: #333;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 20px;
            box-sizing: border-box;
            height: 100vh;
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
        .sidebar a:hover, .sidebar a.active {
            background-color: #444;
        }
        .sidebar h2 {
            margin-bottom: 24px;
            font-size: 1.6rem;
        }
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
        .table-container {
            background-color: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background-color: #f3f4f6;
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        tbody tr:hover {
            background-color: #f9fafb;
        }
        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="update_inventory.php">Manage Products</a>
        <a href="financial_report.php">Financial Report</a>
        <a href="customer.php">Customer</a>
        <a href="membership.php">Membership</a>
         <a href="staff.php">Staff</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Staff Management</h1>

        <div class="table-container">
            <h3 class="text-xl font-semibold mb-4">Staff List</h3>
            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center;">No staff members found</td>
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
