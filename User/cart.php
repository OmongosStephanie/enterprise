<?php
session_start();
require_once '../includes/db.php';

// Add to cart
if (isset($_POST['add_to_cart'])) {
    header('Content-Type: application/json');

    $product_id = intval($_POST['product_id'] ?? 0);
    $quantity = intval($_POST['product_quantity'] ?? 0);

    if ($product_id <= 0 || $quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid product or quantity']);
        exit;
    }

    $stmt = $conn->prepare("SELECT quantity, price FROM inventory WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    $row = $result->fetch_assoc();
    $stock_qty = intval($row['quantity']);
    $product_price = floatval($row['price']);
    $current_cart_qty = $_SESSION['cart'][$product_id]['quantity'] ?? 0;

    if ($quantity + $current_cart_qty > $stock_qty) {
        echo json_encode(['success' => false, 'message' => 'Quantity exceeds stock']);
        exit;
    }

    $_SESSION['cart'][$product_id] = [
        'product_id' => $product_id,
        'quantity' => $current_cart_qty + $quantity,
        'product_price' => $product_price
    ];

    echo json_encode(['success' => true, 'message' => 'Item added to cart!']);
    exit;
}

// Remove from cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = intval($_POST['product_id'] ?? 0);
    unset($_SESSION['cart'][$product_id]);
    header('Location: cart.php');
    exit;
}

// Update quantity
if (isset($_POST['update_quantity'])) {
    $product_id = intval($_POST['product_id'] ?? 0);
    $new_qty = intval($_POST['new_quantity'] ?? 0);

    if ($product_id > 0 && $new_qty > 0 && isset($_SESSION['cart'][$product_id])) {
        $stmt = $conn->prepare("SELECT quantity FROM inventory WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stock_qty = intval($row['quantity']);

            if ($new_qty <= $stock_qty) {
                $_SESSION['cart'][$product_id]['quantity'] = $new_qty;
            } else {
                $_SESSION['cart'][$product_id]['quantity'] = $stock_qty;
                $_SESSION['error'] = "Quantity adjusted to available stock ($stock_qty).";
            }
        }
    }
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart - S&R Online Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">S & R Online Shop</h1>
            <a href="dashboard.php" class="bg-yellow-400 text-gray-800 px-4 py-2 rounded hover:bg-yellow-500">Continue Shopping</a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold mb-6">Shopping Cart</h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="bg-red-200 text-red-800 p-4 mb-4 rounded">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (empty($_SESSION['cart'])): ?>
            <p class="text-gray-700 text-lg">Your cart is empty.</p>
        <?php else: ?>
            <form method="post" class="overflow-x-auto">
                <table class="min-w-full bg-white rounded shadow">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b text-left">Product</th>
                            <th class="px-6 py-3 border-b text-right">Price</th>
                            <th class="px-6 py-3 border-b text-center">Quantity</th>
                            <th class="px-6 py-3 border-b text-right">Subtotal</th>
                            <th class="px-6 py-3 border-b text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $product_id => $item):
                            // Fetch product name and price from DB if missing
                            if (empty($item['product_name']) || empty($item['product_price'])) {
                                $stmt = $conn->prepare("SELECT product_name, price FROM inventory WHERE product_id = ?");
                                $stmt->bind_param("i", $product_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    $product = $result->fetch_assoc();
                                    $name = $product['product_name'];
                                    $price = floatval($product['price']);
                                } else {
                                    $name = 'Unknown';
                                    $price = 0;
                                }
                            } else {
                                $name = $item['product_name'];
                                $price = floatval($item['product_price']);
                            }

                            $qty = intval($item['quantity']);
                            $subtotal = $price * $qty;
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td class="px-6 py-4 border-b"><?= htmlspecialchars($name) ?></td>
                            <td class="px-6 py-4 border-b text-right">₱<?= number_format($price, 2) ?></td>
                            <td class="px-6 py-4 border-b text-center">
                                <form method="post" class="inline-flex items-center">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                                    <input type="number" name="new_quantity" value="<?= $qty ?>" min="1" class="w-16 p-1 border rounded" />
                                    <button type="submit" name="update_quantity" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 ml-2">Update</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 border-b text-right">₱<?= number_format($subtotal, 2) ?></td>
                            <td class="px-6 py-4 border-b text-center">
                                <form method="post" onsubmit="return confirm('Remove this item?');">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                                    <button type="submit" name="remove_from_cart" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-semibold text-lg">Total:</td>
                            <td colspan="2" class="px-6 py-4 text-right font-bold text-xl">₱<?= number_format($total, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </form>

            <div class="mt-6">
                <a href="checkout.php" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>

<?php $conn->close(); ?>
