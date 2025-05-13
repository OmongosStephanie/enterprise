<?php
function getOrderTracking($user_id) {
    require 'db.php'; // Adjust this path if needed

    $stmt = $conn->prepare("SELECT id AS order_id, tracking_number, order_status, estimated_delivery_date, actual_delivery_date 
                            FROM orders 
                            WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();
    return $orders;
}