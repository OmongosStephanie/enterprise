<?php
session_start();
$conn = new mysqli("localhost", "root", "", "online_shop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Get total sales from orders table
$sql = "SELECT SUM(total) AS total_sales FROM orders";
$result = $conn->query($sql);

// Check if query is successful
if (!$result) {
    die("Error fetching total sales: " . $conn->error);
}

$row = $result->fetch_assoc();
$total_sales = $row['total_sales'] ?? 0; // Fallback to 0 if null

// ✅ Define stats
$stats = [
    [
        'label' => 'Cash Sales',
        'value' => 8543,
        'percentage_change' => 30
    ],
    [
        'label' => 'Monthly Income',
        'value' => 20087,
        'percentage_change' => 16
    ],
    [
        'label' => 'Yearly Sales',
        'value' => 8543,
        'percentage_change' => -29
    ],
    [
        'label' => 'Security Deposits',
        'value' => 2388,
        'percentage_change' => 19
    ],
    [
        'label' => 'Product Sales',
        'value' => $total_sales, // ✅ Correct variable used
        'percentage_change' => 12
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: #f5f6fa;
      display: flex;
    }
    .sidebar {
      width: 220px;
      background: #2c3e50;
      color: white;
      height: 100vh;
      padding: 20px;
      box-sizing: border-box;
    }
    .sidebar h2 {
      margin-top: 0;
    }
    .sidebar ul {
      padding: 0;
      list-style-type: none;
    }
    .sidebar li {
      margin: 15px 0;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      font-weight: bold;
    }
    .sidebar a:hover {
      text-decoration: underline;
    }
    .main {
      flex: 1;
      padding: 20px;
    }
    .topbar {
      background: white;
      padding: 15px 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card h3 {
      margin: 0 0 10px;
    }
    canvas {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
    }
    .membership {
      background: #16a085;
      color: white;
      padding: 20px;
      margin-top: 20px;
      border-radius: 10px;
      font-size: 18px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Admin</h2>
    <ul>
      <li><a href="dashboard.php" class="text-lg py-2 block bg-gray-700 rounded">Dashboard</a></li>
      <li><a href="inventory.php" class="text-lg py-2 block">Inventory</a></li>
      <li><a href="payments.php" class="text-lg py-2 block">Payments</a></li>
      <li><a href="customers.php" class="text-lg py-2 block">Customers</a></li>
      <li><a href="membership.php" class="text-lg py-2 block">Membership</a></li>
      <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="topbar">
      <h2>Welcome back, Admin</h2>
      <div>📅 <?php echo date("M d, Y"); ?> | 👤 Admin</div>
    </div>

    <div class="dashboard-cards">
      <?php foreach ($stats as $stat): ?>
        <div class="card">
          <h3><?= htmlspecialchars($stat['label']) ?></h3>
          <p>Value: ₱<?= number_format($stat['value'], 2) ?></p>
          <p>
            <b><?= ($stat['percentage_change'] >= 0 ? '+' : '') . $stat['percentage_change'] ?>%</b> 
            <?= $stat['percentage_change'] >= 0 ? 'increase' : 'decrease' ?>
          </p>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- ✅ Show total sales in a dedicated card -->
    <div class="card" style="margin-top: 20px;">
      <h3>Total Sales</h3>
      <p>₱<?= number_format($total_sales, 2) ?></p>
    </div>

    <canvas id="salesChart" width="400" height="150"></canvas>
  </div>

  <script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [
          {
            label: 'Sales',
            data: [2000, 3000, 4000, 3500, 4200, 3800, 4600],
            borderColor: '#3498db',
            fill: false
          },
          {
            label: 'Loss',
            data: [1200, 1500, 1600, 1800, 1700, 1600, 1500],
            borderColor: '#e74c3c',
            fill: false
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>

</body>
</html>
