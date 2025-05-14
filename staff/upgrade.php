<?php
session_start();
$conn = new mysqli("localhost", "root", "", "online_shop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['membership_id'] ?? null;
if (!$id) {
    die("No membership ID provided.");
}

$stmt = $conn->prepare("SELECT * FROM memberships WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$membership = $result->fetch_assoc();

if (!$membership) {
    die("Membership not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_plan = $_POST['membership_plan'];
    $update = $conn->prepare("UPDATE memberships SET membership_plan = ? WHERE id = ?");
    $update->bind_param("si", $new_plan, $id);
    $update->execute();

    header("Location: membership.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upgrade Membership</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

  <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-lg">
    <div class="text-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Upgrade Membership</h1>
      <p class="text-gray-500 mt-1">for <span class="text-blue-600 font-semibold"><?= htmlspecialchars($membership['name']) ?></span></p>
    </div>

    <form method="POST" class="space-y-5">
      <div>
        <label class="block text-gray-700 font-medium mb-2">Choose a Plan</label>
        <select name="membership_plan" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" required>
          <option value="basic" <?= $membership['membership_plan'] == 'basic' ? 'selected' : '' ?>>🟡 Basic - ₱199.99</option>
          <option value="premium" <?= $membership['membership_plan'] == 'premium' ? 'selected' : '' ?>>🔵 Premium - ₱499.99</option>
          <option value="vip" <?= $membership['membership_plan'] == 'vip' ? 'selected' : '' ?>>👑 VIP - ₱999.99</option>
        </select>
      </div>

      <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-3 rounded-lg transition duration-200">
        Upgrade Now
      </button>

      <a href="membership.php" class="block text-center text-sm text-gray-500 hover:underline mt-2">← Back to Membership</a>
    </form>
  </div>

</body>
</html>
