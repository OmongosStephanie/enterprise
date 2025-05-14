<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $stmt = $conn->prepare("UPDATE orders SET payment_status = 'Paid' WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        // Redirect back with success message
        header("Location: ../Admin/process_payments.php");
        exit();
    } else {
        // Redirect back with failure
        header("Location: ../Admin/process_payments.php");
        exit();
    }
}
?>
