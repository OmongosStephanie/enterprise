<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$items = $_POST['items'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($items)) {
    $fullname = $_POST['fullname'];
    $branch = $_POST['branch'];
    $location = $_POST['location'];
    $street = $_POST['street'];

    $total = 0;
    foreach ($items as $item) {
        $total += floatval($item['price']) * intval($item['quantity']);
    }

    $conn = new mysqli("localhost", "root", "", "online_shop");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO orders (user_id, fullname, branch, location, street, total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssd", $user_id, $fullname, $branch, $location, $street, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?)");
    foreach ($items as $index => $item) {
        $name = $item['name'];
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $subtotal = $price * $quantity;

        $itemStmt->bind_param("isddi", $order_id, $name, $price, $quantity, $subtotal);
        $itemStmt->execute();
    }
    $itemStmt->close();
    $conn->close();

    foreach ($items as $index => $item) {
        if (isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    
    // Show confirmation UI and then redirect after delay
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Order Confirmation - S&R</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <meta http-equiv="refresh" content="5;url=orders.php">
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg text-center">
            <div class="text-green-500 text-5xl mb-4">✔️</div>
            <h1 class="text-2xl font-bold mb-2">Order Successfully Placed!</h1>
            <p class="text-gray-600 mb-6">Thank you for shopping with us! Your order is now being processed. You will be redirected to your order history shortly.</p>
            <a href="orders.php" class="inline-block bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">View My Orders Now</a>
            <p class="text-sm text-gray-400 mt-4">Redirecting in 5 seconds...</p>
        </div>
    </body>
    </html>
    <?php
    exit;
} else {
    echo "No items selected.";
}
