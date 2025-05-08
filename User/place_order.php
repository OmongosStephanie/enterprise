<?php
session_start();

// Check if items are submitted via POST
$items = $_POST['items'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($items)) {
    $fullname = $_POST['fullname'];
    $branch = $_POST['branch'];
    $location = $_POST['location'];
    $street = $_POST['street'];

    // Calculate total amount
    $total = 0;
    foreach ($items as $item) {
        $total += floatval($item['price']) * intval($item['quantity']);
    }

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "online_shop");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into `orders`
    $stmt = $conn->prepare("INSERT INTO orders (fullname, branch, location, street, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $fullname, $branch, $location, $street, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert each item into `order_items`
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

    // Clear ordered items from session cart
    foreach ($items as $index => $item) {
        if (isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex

    // Display confirmation
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Order Confirmation - S&R</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 font-sans p-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow text-center">
            <h1 class="text-2xl font-bold text-green-600 mb-4">🎉 Order Successfully Placed!</h1>
            <p class="mb-6">Thank you for your purchase! Your order is being processed and will be shipped soon.</p>
            <a href="dashboard.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Continue Shopping</a>
        </div>
    </body>
    </html>
    <?php
    exit;
} else {
    echo "No items selected.";
}
?>
