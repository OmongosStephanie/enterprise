<?php
session_start();

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

// Get order counts by status
$status_counts = [
    'pending' => 0,
    'delivered' => 0,
    'completed' => 0
];

$sql = "SELECT status, COUNT(*) as count FROM orders GROUP BY status";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $status = strtolower($row['status']);
    if (isset($status_counts[$status])) {
        $status_counts[$status] = $row['count'];
    }
}

// Initialize sales totals
$sales_weekly = 0;
$sales_monthly = 0;
$sales_yearly = 0;

// Weekly Sales (current week)
$result = $conn->query("
    SELECT SUM(total) AS total 
    FROM orders 
    WHERE status = 'completed' AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)
");
$sales_weekly = $result->fetch_assoc()['total'] ?? 0;

// Monthly Sales (current month)
$result = $conn->query("
    SELECT SUM(total) AS total 
    FROM orders 
    WHERE status = 'completed' AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())
");
$sales_monthly = $result->fetch_assoc()['total'] ?? 0;

// Yearly Sales (current year)
$result = $conn->query("
    SELECT SUM(total) AS total 
    FROM orders 
    WHERE status = 'completed' AND YEAR(created_at) = YEAR(CURDATE())
");
$sales_yearly = $result->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Financial Report - Staff Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-white h-screen p-4">
        <h2 class="text-2xl font-bold mb-8">Staff</h2>
        <ul>
            <li><a href="dashboard.php" class="text-lg py-2 block">Dashboard</a></li>
            <li><a href="staff_financial.php" class="text-lg py-2 block bg-gray-700 rounded">Financial Reports</a></li>
            <li><a href="payments.php" class="text-lg py-2 block">Customer Orders</a></li>
            <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-4">
        <div class="flex justify-between items-center bg-white p-4 rounded shadow mb-6">
            <h2 class="text-2xl font-semibold">Financial Overview</h2>
            <div class="text-gray-600">📅 <?php echo date("M d, Y"); ?> | 👤 Staff</div>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-bold mb-4">Order Status Summary</h3>
            <canvas id="statusChart" width="400" height="100"></canvas>
        </div>

        <div class="bg-white p-6 rounded shadow mt-6">
            <h3 class="text-xl font-bold mb-4">Sales Report</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-lg">
                <div class="bg-green-100 p-4 rounded shadow">
                    <h4 class="font-semibold">Weekly Sales</h4>
                    <p class="text-2xl font-bold text-green-700">₱<?php echo number_format($sales_weekly, 2); ?></p>
                </div>
                <div class="bg-blue-100 p-4 rounded shadow">
                    <h4 class="font-semibold">Monthly Sales</h4>
                    <p class="text-2xl font-bold text-blue-700">₱<?php echo number_format($sales_monthly, 2); ?></p>
                </div>
                <div class="bg-yellow-100 p-4 rounded shadow">
                    <h4 class="font-semibold">Yearly Sales</h4>
                    <p class="text-2xl font-bold text-yellow-700">₱<?php echo number_format($sales_yearly, 2); ?></p>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Delivered', 'Completed'],
            datasets: [{
                label: 'Number of Orders',
                data: [
                    <?php echo $status_counts['pending']; ?>,
                    <?php echo $status_counts['delivered']; ?>,
                    <?php echo $status_counts['completed']; ?>
                ],
                backgroundColor: [
                    '#facc15', // yellow
                    '#3b82f6', // blue
                    '#10b981'  // green
                ],
                borderColor: [
                    '#eab308',
                    '#2563eb',
                    '#059669'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
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
