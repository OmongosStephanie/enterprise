<?php
session_start();

// Update or remove item quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $index = $_POST['index'];
        $newQuantity = $_POST['quantity'];
        if (isset($_SESSION['cart'][$index]) && $newQuantity > 0) {
            $_SESSION['cart'][$index]['quantity'] = $newQuantity;
        }
    } elseif (isset($_POST['remove'])) {
        $index = $_POST['remove'];
        if (isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - S&R</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function updateTotal() {
            const checkboxes = document.querySelectorAll('input[name="select[]"]:checked');
            let total = 0;
            checkboxes.forEach(cb => {
                const quantity = parseInt(cb.dataset.quantity);
                const price = parseFloat(cb.dataset.price);
                total += quantity * price;
            });
            document.getElementById('total').textContent = total.toFixed(2);
            document.getElementById('checkout-btn').style.display = checkboxes.length > 0 ? 'inline-block' : 'none';
        }

        function goToCheckout() {
            const form = document.getElementById('checkout-form');
            const selectedItems = document.querySelectorAll('input[name="select[]"]:checked');

            // Clear previous hidden inputs
            document.querySelectorAll('.checkout-item-data').forEach(el => el.remove());

            if (selectedItems.length === 0) {
                alert('Please select items to proceed to checkout.');
                return;
            }

            selectedItems.forEach(cb => {
                const index = cb.value;
                const price = cb.dataset.price;
                const quantity = cb.dataset.quantity;

                const name = cb.closest('tr').querySelector('td:nth-child(2)').textContent.trim();

                const nameField = document.createElement('input');
                nameField.type = 'hidden';
                nameField.name = `items[${index}][name]`;
                nameField.value = name;
                nameField.classList.add('checkout-item-data');

                const priceField = document.createElement('input');
                priceField.type = 'hidden';
                priceField.name = `items[${index}][price]`;
                priceField.value = price;
                priceField.classList.add('checkout-item-data');

                const qtyField = document.createElement('input');
                qtyField.type = 'hidden';
                qtyField.name = `items[${index}][quantity]`;
                qtyField.value = quantity;
                qtyField.classList.add('checkout-item-data');

                form.appendChild(nameField);
                form.appendChild(priceField);
                form.appendChild(qtyField);
            });

            form.submit();
        }

        function updateQuantity(index) {
            const quantityInput = document.getElementById('quantity-' + index);
            const quantity = quantityInput.value;
            if (quantity > 0) {
                // Update quantity in the session via AJAX or form submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                const inputIndex = document.createElement('input');
                inputIndex.type = 'hidden';
                inputIndex.name = 'index';
                inputIndex.value = index;
                const inputQuantity = document.createElement('input');
                inputQuantity.type = 'hidden';
                inputQuantity.name = 'quantity';
                inputQuantity.value = quantity;
                const inputUpdate = document.createElement('input');
                inputUpdate.type = 'hidden';
                inputUpdate.name = 'update';
                inputUpdate.value = 'true';
                form.appendChild(inputIndex);
                form.appendChild(inputQuantity);
                form.appendChild(inputUpdate);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function confirmRemove(index) {
            if (confirm("Are you sure you want to remove this item from your cart?")) {
                // Create a hidden form to submit the removal action
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove';
                input.value = index;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        window.onload = updateTotal;
    </script>
</head>
<body class="bg-gray-100 font-sans p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty. You have already placed your order.</p>
        <?php else: ?>
            <form id="checkout-form" method="post" action="checkout.php">
                <table class="w-full mb-4">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="p-2">Select</th>
                            <th class="p-2">Product</th>
                            <th class="p-2">Price</th>
                            <th class="p-2">Quantity</th>
                            <th class="p-2">Subtotal</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $index => $item): 
                            $quantity = $item['quantity'] ?? 1;
                            $price = $item['price'];
                            $subtotal = $quantity * $price;
                        ?>
                            <tr class="border-b">
                                <td class="p-2">
                                    <input type="checkbox" name="select[]" value="<?= $index ?>" 
                                        data-price="<?= $price ?>" 
                                        data-quantity="<?= $quantity ?>" 
                                        onchange="updateTotal()">
                                </td>
                                <td class="p-2"><?= htmlspecialchars($item['name']) ?></td>
                                <td class="p-2">₱<?= number_format($price, 2) ?></td>
                                <td class="p-2">
                                    <input type="number" id="quantity-<?= $index ?>" value="<?= $quantity ?>" min="1" class="w-16 p-1 border rounded" onchange="updateQuantity(<?= $index ?>)">
                                </td>
                                <td class="p-2">₱<?= number_format($subtotal, 2) ?></td>
                                <td class="p-2">
                                    <button type="button" class="text-red-500 hover:text-red-700" onclick="confirmRemove(<?= $index ?>)">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="font-semibold">Total: ₱<span id="total">0.00</span></p>
                <!-- Hidden checkout data will be appended here by JavaScript -->
                <button type="button" id="checkout-btn" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hidden hover:bg-blue-600" onclick="goToCheckout()">Proceed to Checkout</button>
            </form>
        <?php endif; ?>
        <a href="dashboard.php" class="mt-6 inline-block text-blue-600 hover:underline">← Continue Shopping</a>
    </div>
</body>
</html>
