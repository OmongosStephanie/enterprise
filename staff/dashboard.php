<?php
session_start();
$conn = new mysqli("localhost", "root", "", "online_shop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Weekly Sales (last 7 days)
$weeklySalesSql = "SELECT SUM(total) AS total FROM orders WHERE status = 'completed' AND created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
$weeklySales = $conn->query($weeklySalesSql)->fetch_assoc()['total'] ?? 0;

// Monthly Sales (current month)
$monthlySalesSql = "SELECT SUM(total) AS total FROM orders WHERE status = 'completed' AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
$monthlySales = $conn->query($monthlySalesSql)->fetch_assoc()['total'] ?? 0;

// Yearly Sales (current year)
$yearlySalesSql = "SELECT SUM(total) AS total FROM orders WHERE status = 'completed' AND YEAR(created_at) = YEAR(CURDATE())";
$yearlySales = $conn->query($yearlySalesSql)->fetch_assoc()['total'] ?? 0;

// Available Riders
$ridersSql = "SELECT name, contact FROM riders WHERE status = 'available' OR status = 'active'";
$ridersResult = $conn->query($ridersSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Financial Reports</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
      <li><a href="rider.php" class="text-lg py-2 block">Riders</a></li>
      <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="flex-1 p-6">
    <div class="flex justify-between items-center bg-white p-4 rounded shadow mb-6">
      <h2 class="text-2xl font-semibold">Financial Report</h2>
      <div class="text-gray-600">📅 <?php echo date("M d, Y"); ?> | 👤 Staff</div>
    </div>

    <!-- Sales Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <div class="bg-green-100 p-6 rounded shadow text-center">
        <h3 class="text-lg font-bold text-green-800">Weekly Sales</h3>
        <p class="text-3xl font-semibold mt-2">₱<?php echo number_format($weeklySales, 2); ?></p>
      </div>
      <div class="bg-blue-100 p-6 rounded shadow text-center">
        <h3 class="text-lg font-bold text-blue-800">Monthly Sales</h3>
        <p class="text-3xl font-semibold mt-2">₱<?php echo number_format($monthlySales, 2); ?></p>
      </div>
      <div class="bg-purple-100 p-6 rounded shadow text-center">
        <h3 class="text-lg font-bold text-purple-800">Yearly Sales</h3>
        <p class="text-3xl font-semibold mt-2">₱<?php echo number_format($yearlySales, 2); ?></p>
      </div>
    </div>

    <!-- Available Riders Section -->
    <div class="bg-white p-6 rounded shadow">
      <h3 class="text-xl font-bold mb-4">Available Riders</h3>
      <?php if ($ridersResult->num_rows > 0): ?>
        <ul class="list-disc list-inside">
          <?php while ($rider = $ridersResult->fetch_assoc()): ?>
            <li class="mb-2">
              <strong><?php echo htmlspecialchars($rider['name']); ?></strong>
              <?php if (!empty($rider['contact_number'])): ?>
                — Contact: <?php echo htmlspecialchars($rider['contact_number']); ?>
              <?php endif; ?>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <p>No available riders found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
