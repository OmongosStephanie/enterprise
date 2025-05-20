<?php
session_start();

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

$status_message = '';
$editing = false;
$edit_data = [
    'id' => '',
    'name' => '',
    'contact' => '',
    'status' => 'active',
];

// Handle Add Rider
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_rider'])) {
    $rider_name = $conn->real_escape_string(trim($_POST['rider_name']));
    $rider_contact = $conn->real_escape_string(trim($_POST['rider_contact']));
    $rider_status = $conn->real_escape_string(trim($_POST['rider_status']));

    if ($rider_name !== '' && $rider_contact !== '') {
        $check = $conn->query("SELECT id FROM riders WHERE name = '$rider_name'");
        if ($check->num_rows > 0) {
            $status_message = "Rider '$rider_name' already exists.";
        } else {
            $insert = $conn->query("INSERT INTO riders (name, contact, status) VALUES ('$rider_name', '$rider_contact', '$rider_status')");
            $status_message = $insert ? "Rider '$rider_name' added successfully." : "Failed to add rider: " . $conn->error;
        }
    } else {
        $status_message = "Please fill in all rider details.";
    }
}

// Handle Edit Mode
if (isset($_GET['edit'])) {
    $editing = true;
    $edit_id = (int)$_GET['edit'];
    $result = $conn->query("SELECT * FROM riders WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    }
}

// Handle Update Rider
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_rider'])) {
    $id = (int)$_POST['rider_id'];
    $rider_name = $conn->real_escape_string(trim($_POST['rider_name']));
    $rider_contact = $conn->real_escape_string(trim($_POST['rider_contact']));
    $rider_status = $conn->real_escape_string(trim($_POST['rider_status']));

    if ($rider_name !== '' && $rider_contact !== '') {
        $update = $conn->query("UPDATE riders SET name='$rider_name', contact='$rider_contact', status='$rider_status' WHERE id=$id");
        $status_message = $update ? "Rider updated successfully." : "Failed to update rider: " . $conn->error;
        header("Location: rider.php");
        exit();
    } else {
        $status_message = "Please fill in all fields.";
    }
}

// Delete Rider
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $conn->query("DELETE FROM riders WHERE id = $delete_id");
    header("Location: rider.php");
    exit();
}

// Fetch all riders
$riders = $conn->query("SELECT * FROM riders ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Rider Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex min-h-screen">

  <!-- Sidebar -->
   <div class="w-64 bg-gray-800 text-white h-screen p-4">
    <h2 class="text-2xl font-bold mb-8">Staff</h2>
    <ul>
      <li><a href="dashboard.php" class="text-lg py-2 block">Dashboard</a></li>
      <li><a href="staff_financial.php" class="text-lg py-2 block">Financial Reports</a></li>
      <li><a href="payments.php" class="text-lg py-2 block">Customer Orders</a></li>
      <li><a href="rider.php" class="text-lg py-2 block bg-gray-700 rounded">Riders</a></li>
      <li><a href="logout.php" class="text-lg py-2 block mt-4 text-red-500">Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <main class="flex-1 p-8">
    <header class="flex justify-between items-center bg-white p-6 rounded shadow mb-8">
      <h1 class="text-3xl font-semibold">Manage Riders</h1>
      <div class="text-gray-600 select-none">📅 <?php echo date("M d, Y"); ?> | 👤 Staff</div>
    </header>

    <!-- Status Message -->
    <?php if (!empty($status_message)): ?>
      <div class="mb-8 p-4 bg-green-100 text-green-700 rounded shadow">
        <?php echo $status_message; ?>
      </div>
    <?php endif; ?>

    <!-- 2-Column Layout -->
    <div class="flex gap-x-6">

      <!-- Form Column -->
      <section class="bg-white p-6 rounded shadow w-1/2 flex flex-col">
        <h2 class="text-xl font-bold mb-4"><?php echo $editing ? 'Edit Rider' : 'Add New Rider'; ?></h2>
        <form method="POST" class="flex flex-col flex-grow">
          <input type="hidden" name="rider_id" value="<?php echo $edit_data['id']; ?>" />
          <div class="mb-4">
            <label for="rider_name" class="block mb-1 font-medium text-gray-700">Rider Name</label>
            <input
              type="text"
              name="rider_name"
              id="rider_name"
              class="w-full border border-gray-300 rounded px-3 py-2"
              value="<?php echo htmlspecialchars($edit_data['name']); ?>"
              required
            />
          </div>
          <div class="mb-4">
            <label for="rider_contact" class="block mb-1 font-medium text-gray-700">Contact Number</label>
            <input
              type="text"
              name="rider_contact"
              id="rider_contact"
              class="w-full border border-gray-300 rounded px-3 py-2"
              value="<?php echo htmlspecialchars($edit_data['contact']); ?>"
              required
            />
          </div>
          <div class="mb-4">
            <label for="rider_status" class="block mb-1 font-medium text-gray-700">Status</label>
            <select
              name="rider_status"
              id="rider_status"
              class="w-full border border-gray-300 rounded px-3 py-2"
            >
              <option value="active" <?php echo $edit_data['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
              <option value="inactive" <?php echo $edit_data['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
          </div>
          <div class="mt-auto">
            <button
              type="submit"
              name="<?php echo $editing ? 'update_rider' : 'add_rider'; ?>"
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded"
            >
              <?php echo $editing ? 'Update Rider' : 'Add Rider'; ?>
            </button>
            <?php if ($editing): ?>
              <a href="rider.php" class="ml-4 text-gray-600 hover:underline">Cancel</a>
            <?php endif; ?>
          </div>
        </form>
      </section>

      <!-- List Column -->
      <section class="bg-white p-6 rounded shadow w-1/2 max-h-[600px] overflow-y-auto">
        <h2 class="text-xl font-bold mb-4">Riders List</h2>
        <?php if ($riders->num_rows > 0): ?>
          <ul>
            <?php while ($row = $riders->fetch_assoc()): ?>
              <li class="flex justify-between items-center border-b py-3">
                <div>
                  <p class="font-semibold">
                    <?php echo htmlspecialchars($row['name']); ?>
                    <span class="text-sm text-gray-600">(<?php echo htmlspecialchars($row['contact']); ?>)</span>
                  </p>
                  <p class="text-sm <?php echo $row['status'] === 'active' ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo ucfirst($row['status']); ?>
                  </p>
                </div>
                <div class="flex gap-4">
                  <a href="rider.php?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                  <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Delete this rider?');">Delete</a>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <p class="text-gray-600">No riders found.</p>
        <?php endif; ?>
      </section>
    </div>
  </main>
</div>
</body>
</html>
