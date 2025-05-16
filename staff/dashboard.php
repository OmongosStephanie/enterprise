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
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex">

  <!-- Sidebar -->

  <div class="w-64 bg-gray-800 text-white h-screen p-4">
    <h2 class="text-2xl font-bold mb-8">Staff</h2>
    <ul>
      <li><a href="dashboard.php" class="text-lg py-2 block bg-gray-700 rounded">Dashboard</a></li>
      <li><a href="staff_financial.php" class="text-lg py-2 block">Financial Reports</a></li>
      <li><a href="payments.php" class="text-lg py-2 block">Customer Orders</a></li>
      <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->

  <div class="flex-1 p-6">
    <div class="flex justify-between items-center bg-white p-4 rounded shadow mb-6">
      <h2 class="text-2xl font-semibold">Welcome back, Luna</h2>
      <div class="text-gray-600">📅 <?php echo date("M d, Y"); ?> | 👤 Staff</div>
    </div>

    <div class="bg-white p-6 rounded shadow mb-6">
      <h3 class="text-xl font-bold mb-2">Welcome</h3>
      <p class="mb-2">We're glad to have you here! Manage your store, view reports, and keep track of all activities.</p>
      <p>Feel free to navigate through the sidebar to access various sections.</p>
    </div>

   
   

  </div>

</div>
</body>
</html>
