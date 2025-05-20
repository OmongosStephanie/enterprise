<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
include '../includes/db.php';

// Order status count (including cancelled)
$status_counts = [
    'pending' => 0,
    'delivered' => 0,
    'completed' => 0,
    'cancelled' => 0
];

$sql = "SELECT status, COUNT(*) as count FROM orders GROUP BY status";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $status = strtolower($row['status']);
    if (isset($status_counts[$status])) {
        $status_counts[$status] = $row['count'];
    }
}

// Sales figures
$sales_weekly = $sales_monthly = $sales_yearly = 0;

$result = $conn->query("SELECT SUM(total) AS total FROM orders WHERE status = 'completed' AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
$sales_weekly = $result->fetch_assoc()['total'] ?? 0;

$result = $conn->query("SELECT SUM(total) AS total FROM orders WHERE status = 'completed' AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())");
$sales_monthly = $result->fetch_assoc()['total'] ?? 0;

$result = $conn->query("SELECT SUM(total) AS total FROM orders WHERE status = 'completed' AND YEAR(created_at) = YEAR(CURDATE())");
$sales_yearly = $result->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Financial Report - Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Same styling as before */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            color: #333;
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
        }
        .sidebar h2 {
            font-size: 1.6rem;
            margin-bottom: 24px;
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
        .sidebar a:hover {
            background-color: #444;
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
            font-weight: 700;
            margin-bottom: 30px;
            color: #111827;
        }
        .stats {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .stat-card {
            flex: 1 1 250px;
            background-color: #f3f4f6;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            text-align: center;
            transition: box-shadow 0.3s ease;
        }
        .stat-card:hover {
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            font-size: 1.25rem;
            color: #374151;
            margin-bottom: 12px;
            font-weight: 700;
        }
        .stat-card p {
            font-size: 2.5rem;
            font-weight: 800;
            color: #111827;
            margin: 0;
        }
        .chart-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
            }
            .stat-card {
                width: 100%;
            }
            .content {
                padding: 20px;
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

    <!-- Main Content -->
    <div class="content">
        <h1>📊 Financial Report (<?php echo date("F d, Y"); ?>)</h1>

        <!-- Stat Cards -->
        <div class="stats">
            <div class="stat-card">
                <h3>Weekly Sales</h3>
                <p>₱<?php echo number_format($sales_weekly, 2); ?></p>
            </div>
            <div class="stat-card">
                <h3>Monthly Sales</h3>
                <p>₱<?php echo number_format($sales_monthly, 2); ?></p>
            </div>
            <div class="stat-card">
                <h3>Yearly Sales</h3>
                <p>₱<?php echo number_format($sales_yearly, 2); ?></p>
            </div>
            <div class="stat-card" style="background-color:#fee2e2;">
                <h3 style="color:#b91c1c;">Cancelled Orders</h3>
                <p style="color:#b91c1c;"><?php echo $status_counts['cancelled']; ?></p>
            </div>
        </div>

        <!-- Chart -->
        <div class="chart-container">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 20px;">📦 Order Status Summary</h2>
            <canvas id="statusChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Delivered', 'Completed', 'Cancelled'],
            datasets: [{
                label: 'Number of Orders',
                data: [
                    <?php echo $status_counts['pending']; ?>,
                    <?php echo $status_counts['delivered']; ?>,
                    <?php echo $status_counts['completed']; ?>,
                    <?php echo $status_counts['cancelled']; ?>
                ],
                backgroundColor: ['#facc15', '#3b82f6', '#10b981', '#ef4444'],
                borderColor: ['#eab308', '#2563eb', '#059669', '#dc2626'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

</body>
</html>
