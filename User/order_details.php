<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "online_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-4xl mx-auto py-10 px-6">
        <?php if ($order): ?>
            <h1 class="text-2xl font-bold text-blue-700 mb-4">Order #<?php echo $order['id']; ?></h1>
            <div class="bg-white p-6 rounded-lg shadow">
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
                <p><strong>Branch:</strong> <?php echo htmlspecialchars($order['branch']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($order['location']); ?></p>
                <p><strong>Street:</strong> <?php echo htmlspecialchars($order['street']); ?></p>
                <p><strong>Total:</strong> ₱<?php echo number_format($order['total'], 2); ?></p>
                <p><strong>Date Ordered:</strong> <?php echo date("F j, Y", strtotime($order['created_at'])); ?></p>
                <p><strong>Status:</strong> 
                    <span class="font-semibold capitalize <?php echo $order['status'] === 'delivered' ? 'text-green-600' : 'text-yellow-500'; ?>">
                        <?php echo htmlspecialchars($order['status']); ?>
                    </span>
                </p>

                <?php if ($order['status'] === 'delivered' && !empty($order['delivered_at'])): ?>
                    <p><strong>Delivered Date:</strong> <?php echo date("F j, Y", strtotime($order['delivered_at'])); ?></p>
                <?php endif; ?>

                <?php if ($order['status'] === 'delivered' && !empty($order['delivery_person'])): ?>
                    <p><strong>Delivery Person:</strong> <?php echo htmlspecialchars($order['delivery_person']); ?></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">Order not found or you don’t have permission to view it.</p>
        <?php endif; ?>

        <div class="mt-6 text-center">
            <a href="orders.php" class="text-blue-500 hover:underline">&larr; Back to My Orders</a>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
