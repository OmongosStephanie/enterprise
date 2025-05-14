<?php
session_start();
$conn = new mysqli("localhost", "root", "", "online_shop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Dashboard</title>
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
    <h2>Staff</h2>
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
      <h2>Welcome back, Luna</h2>
      <div>📅 <?php echo date("M d, Y"); ?> | 👤 staff</div>
    </div>

    <div class="card" style="margin-top: 20px;">
      <h3>Welcome</h3>
      <p>We're glad to have you here! Manage your store, view reports, and keep track of all activities.</p>
      <p>Feel free to navigate through the sidebar to access various sections.</p>
    </div>
  </div>

</body>
</html>
