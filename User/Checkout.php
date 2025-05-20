<?php
session_start();
require_once '../includes/db.php';

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Make sure user is logged in for order linking
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch logged-in user's fullname and email
// *** CHANGE 'fullname' below if your column name differs ***
$stmt_user = $conn->prepare("SELECT first_name, email FROM users WHERE id = ?");
$stmt_user->bind_param("i", $_SESSION['user_id']);
$stmt_user->execute();
$stmt_user->bind_result($first_name, $email);
$stmt_user->fetch();
$stmt_user->close();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email_post = trim($_POST['email'] ?? '');
    $branch = trim($_POST['branch'] ?? '');
    $location = trim($_POST['location'] ?? '');

    if (!$name || !$email_post || !$branch || !$location) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email_post, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $cart_items = $_SESSION['cart'];

        // Calculate total
        $total = 0;
        foreach ($cart_items as $product_id => $item) {
            $total += $item['product_price'] * $item['quantity'];
        }

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert into orders table
            $stmt_order = $conn->prepare("INSERT INTO orders (user_id, fullname, email, branch, location, total, created_at, status) VALUES (?, ?, ?, ?, ?, ?, NOW(), 'pending')");
            $stmt_order->bind_param("issssd", $_SESSION['user_id'], $name, $email_post, $branch, $location, $total);
            $stmt_order->execute();

            if ($stmt_order->affected_rows == 0) {
                throw new Exception("Failed to create order.");
            }

            $order_id = $stmt_order->insert_id;
            $stmt_order->close();

            // Prepare statements for inserting order items and updating stock
            $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt_update_stock = $conn->prepare("UPDATE inventory SET stock = stock - ? WHERE product_id = ? AND stock >= ?");

            foreach ($cart_items as $product_id => $item) {
                $quantity = $item['quantity'];
                $price = $item['product_price'];

                // Insert order item
                $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                $stmt_item->execute();
                if ($stmt_item->affected_rows == 0) {
                    throw new Exception("Failed to add product $product_id to order.");
                }

                // Update inventory stock (only if enough stock exists)
                $stmt_update_stock->bind_param("iii", $quantity, $product_id, $quantity);
                $stmt_update_stock->execute();
                if ($stmt_update_stock->affected_rows == 0) {
                    throw new Exception("Insufficient stock for product ID: $product_id");
                }
            }

            $stmt_item->close();
            $stmt_update_stock->close();

            // Commit transaction
            $conn->commit();

            // Clear cart and success message
            $_SESSION['cart'] = [];
            $success = "Thank you, your order has been placed! Your Order ID is $order_id";

        } catch (Exception $e) {
            $conn->rollback();
            $error = "Order failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Checkout - S&R Online Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<header class="bg-gray-800 text-white py-4">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">S & R Online Shop</h1>
        <a href="cart.php" class="bg-yellow-400 text-gray-800 px-4 py-2 rounded hover:bg-yellow-500">Back to Cart</a>
    </div>
</header>

<main class="container mx-auto px-4 py-8 max-w-3xl">
    <h2 class="text-3xl font-semibold mb-6">Checkout</h2>

    <?php if ($error): ?>
        <div class="bg-red-200 text-red-800 p-4 mb-4 rounded"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-green-200 text-green-800 p-4 mb-4 rounded"><?= htmlspecialchars($success) ?></div>
        <a href="dashboard.php" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Continue Shopping</a>
    <?php else: ?>
        <section class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
            <table class="min-w-full bg-white rounded shadow mb-6">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b text-left">Product</th>
                        <th class="px-6 py-3 border-b text-right">Price</th>
                        <th class="px-6 py-3 border-b text-center">Quantity</th>
                        <th class="px-6 py-3 border-b text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_display = 0;
                    foreach ($_SESSION['cart'] as $product_id => $item):
                        $stmt = $conn->prepare("SELECT product_name, price FROM inventory WHERE product_id = ?");
                        $stmt->bind_param("i", $product_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $product = $result->fetch_assoc();
                        $stmt->close();

                        $name = $product['product_name'] ?? 'Unknown';
                        $price = floatval($product['price'] ?? 0);
                        $qty = intval($item['quantity']);
                        $subtotal = $price * $qty;
                        $total_display += $subtotal;
                    ?>
                    <tr>
                        <td class="px-6 py-4 border-b"><?= htmlspecialchars($name) ?></td>
                        <td class="px-6 py-4 border-b text-right">₱<?= number_format($price, 2) ?></td>
                        <td class="px-6 py-4 border-b text-center"><?= $qty ?></td>
                        <td class="px-6 py-4 border-b text-right">₱<?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-semibold text-lg">Total:</td>
                        <td class="px-6 py-4 text-right font-bold text-xl">₱<?= number_format($total_display, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </section>

        <section>
            <h3 class="text-xl font-semibold mb-4">Your Details</h3>
            <form method="post" class="bg-white p-6 rounded shadow space-y-4">
                <div>
                    <label for="name" class="block font-semibold mb-1">Name *</label>
                    <input type="text" id="name" name="name" required class="w-full p-2 border rounded" value="<?= htmlspecialchars($_POST['name'] ?? $first_name) ?>" />
                </div>
                <div>
                    <label for="email" class="block font-semibold mb-1">Email *</label>
                    <input type="email" id="email" name="email" required class="w-full p-2 border rounded" value="<?= htmlspecialchars($_POST['email'] ?? $email) ?>" />
                </div>
                <div>
                    <label for="branch" class="block font-semibold mb-1">Select Branch *</label>
                    <select name="branch" id="branch" required class="w-full p-2 border rounded" onchange="updateLocations()">
                        <option value="">-- Select Branch --</option>
                        <option value="Dahilayan" <?= (($_POST['branch'] ?? '') === 'Dahilayan') ? 'selected' : '' ?>>Dahilayan</option>
                        <option value="Manolo" <?= (($_POST['branch'] ?? '') === 'Manolo') ? 'selected' : '' ?>>Manolo</option>
                    </select>
                </div>
                <div>
                    <label for="location" class="block font-semibold mb-1">Select Location *</label>
                    <select name="location" id="location" required class="w-full p-2 border rounded">
                        <option value="">-- Select Location --</option>
                    </select>
                </div>
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Place Order</button>
            </form>
        </section>

        <script>
            const locations = {
                Dahilayan: [
                    "Dahilayan Forest Park",
                    "Dahilayan Adventure Park",
                    "Del Monte Pineapple Plantation",
                    "Alomah's Place",
                    "Kalugmanan",
                    "Mampayag"
                ],
                Manolo: [
                    "Manolo Fortich Market",
                    "Camp Phillips",
                    "Northern Bukidnon State College",
                    "Lingion",
                    "San Miguel",
                    "Dicklum"
                ]
            };

            function updateLocations() {
                const branch = document.getElementById("branch").value;
                const locationSelect = document.getElementById("location");
                locationSelect.innerHTML = '<option value="">-- Select Location --</option>';

                if (locations[branch]) {
                    locations[branch].forEach(loc => {
                        const option = document.createElement('option');
                        option.value = loc;
                        option.textContent = loc;
                        locationSelect.appendChild(option);
                    });
                }

                // Retain previously selected location after reload
                const prevLocation = "<?= htmlspecialchars($_POST['location'] ?? '') ?>";
                if (prevLocation) {
                    locationSelect.value = prevLocation;
                }
            }

            // Populate location select on page load if branch selected
            document.addEventListener('DOMContentLoaded', () => {
                updateLocations();
            });
        </script>
    <?php endif; ?>
</main>

<footer class="bg-gray-800 text-white text-center py-4 mt-12">
    &copy; <?= date('Y') ?> S & R Online Shop
</footer>
</body>
</html>
