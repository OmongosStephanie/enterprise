<?php
session_start();

// Handle removing an item from the cart via POST
if (isset($_POST['remove'])) {
    $removeIndex = $_POST['remove'];
    if (isset($_SESSION['cart'][$removeIndex])) {
        unset($_SESSION['cart'][$removeIndex]);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to refresh the cart
    exit();
}

// Validate cart data structure
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<!-- HTML and CSS stay the same -->
