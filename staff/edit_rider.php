<?php
session_start();

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

$status_message = '';

if (!isset($_GET['id'])) {
    header('Location: rider.php');
    exit();
}

$rider_id = (int)$_GET['id'];

// Fetch rider data
$result = $conn->query("SELECT * FROM riders WHERE id = $rider_id");
if ($result->num_rows === 0) {
    header('Location: rider.php');
    exit();
}

$rider = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rider_name = $conn->real_escape_string(trim($_POST['rider_name']));
    $rider_contact = $conn->real_escape_string(trim($_POST['rider_contact']));
    $rider_status = $conn->real_escape_string(trim($_POST['rider_status']));

    if ($rider_name !== '' && $rider_contact !== '') {
        $update = $conn->query("UPDATE riders SET name='$rider_name', contact='$rider_contact', status='$rider_status' WHERE id=$rider_id");

        if ($update) {
            header('Location: rider.php?message=updated');
            exit();
        } else {
            $status_message = "Failed to update rider: " . $conn->error;
        }
    } else {
        $status_message = "Please fill in all fields.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Rider</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Edit Rider</h2>

    <?php if ($status_message): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?php echo $status_message; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-4">
        <label for="rider_name" class="block mb-1 font-medium text-gray-700">Rider Name</label>
        <input type="text" id="rider_name" name="rider_name" required
          class="w-full border border-gray-300 rounded px-3 py-2"
          value="<?php echo htmlspecialchars($rider['name']); ?>" />
      </div>
      <div class="mb-4">
        <label for="rider_contact" class="block mb-1 font-medium text-gray-700">Contact Number</label>
        <input type="text" id="rider_contact" name="rider_contact" required
          class="w-full border border-gray-300 rounded px-3 py-2"
          value="<?php echo htmlspecialchars($rider['contact']); ?>" />
      </div>
      <div class="mb-4">
        <label for="rider_status" class="block mb-1 font-medium text-gray-700">Status</label>
        <select id="rider_status" name="rider_status" class="w-full border border-gray-300 rounded px-3 py-2">
          <option value="active" <?php echo $rider['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
          <option value="inactive" <?php echo $rider['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select>
      </div>
      <div class="flex justify-between items-center">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Rider</button>
        <a href="rider.php" class="text-gray-600 hover:underline">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
