<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: orders.php");
    exit();
}

$order_id = $_POST['order_id'];
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "online_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only cancel if status is 'pending'
$stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ? AND user_id = ? AND status = 'Pending'");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();

$conn->close();

header("Location: orders.php");
exit();
?>
