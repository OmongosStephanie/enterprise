<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once '../includes/db.php'; // Adjust path as necessary

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM inventory WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    // Execute the query and check if successful
    if ($stmt->execute()) {
        // Product deleted successfully, redirect to inventory page
        header('Location: inventory.php');
        exit();
    } else {
        echo "Error deleting product: " . $stmt->error;
    }
} else {
    // If no ID is provided, redirect to inventory page
    header('Location: update_inventory.php');
    exit();
}

// Close database connection
$conn->close();
?>
