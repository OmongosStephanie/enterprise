<?php
session_start();

$items = $_POST['items'] ?? [];

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - S&R</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Checkout Summary</h1>

        <?php if (empty($items)): ?>
            <p>No items selected. <a href="cart.php" class="text-blue-600 underline">Go back to cart</a>.</p>
        <?php else: ?>
            <form method="POST" action="place_order.php">
                <table class="w-full mb-4">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="p-2">Product</th>
                            <th class="p-2">Price</th>
                            <th class="p-2">Quantity</th>
                            <th class="p-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $index => $item): 
                            $name = htmlspecialchars($item['name']);
                            $price = floatval($item['price']);
                            $quantity = intval($item['quantity']);
                            $subtotal = $price * $quantity;
                            $total += $subtotal;
                        ?>
                            <tr class="border-b">
                                <td class="p-2"><?= $name ?></td>
                                <td class="p-2">₱<?= number_format($price, 2) ?></td>
                                <td class="p-2"><?= $quantity ?></td>
                                <td class="p-2">₱<?= number_format($subtotal, 2) ?></td>
                            </tr>
                            <!-- Hidden inputs for each item -->
                            <input type="hidden" name="items[<?= $index ?>][name]" value="<?= $name ?>">
                            <input type="hidden" name="items[<?= $index ?>][price]" value="<?= $price ?>">
                            <input type="hidden" name="items[<?= $index ?>][quantity]" value="<?= $quantity ?>">
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p class="font-semibold text-lg mb-6">Total Amount: ₱<?= number_format($total, 2) ?></p>

                <!-- Customer Info -->
                <div class="mb-6">
                    <label class="block mb-2 font-medium" for="fullname">Full Name:</label>
                    <input type="text" name="fullname" id="fullname" required 
                           class="w-full p-2 border border-gray-300 rounded" placeholder="Enter your full name">
                </div>

                <!-- Branch Selection -->
                <div class="mb-6">
                    <label class="block mb-2 font-medium" for="branch">Select Branch:</label>
                    <select name="branch" id="branch" required class="w-full p-2 border border-gray-300 rounded" onchange="updateLocations()">
                        <option value="Dahilayan">Dahilayan</option>
                        <option value="Manolo">Manolo</option>
                    </select>
                </div>

                <!-- Location Selection based on Branch -->
                <div class="mb-6">
                    <label class="block mb-2 font-medium" for="location">Select Location:</label>
                    <select name="location" id="location" required class="w-full p-2 border border-gray-300 rounded">
                        <option value="">Select a location</option>
                    </select>
                </div>

                <!-- Street Address -->
                <div class="mb-6">
                    <label class="block mb-2 font-medium" for="street">Enter Street Address:</label>
                    <input type="text" name="street" id="street" required class="w-full p-2 border border-gray-300 rounded" placeholder="Enter street address">
                </div>

                <div class="flex justify-between">
                    <a href="cart.php" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">← Back to Cart</a>
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Place Order</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // Locations near Dahilayan and Manolo
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
                "lingion",
                "San Miguel",
                "Dicklum"
            ]
        };

        // Update location options based on the selected branch
        function updateLocations() {
            const branch = document.getElementById("branch").value;
            const locationSelect = document.getElementById("location");
            locationSelect.innerHTML = "<option value=''>Select a location</option>"; // Reset options

            const branchLocations = locations[branch] || [];
            branchLocations.forEach(location => {
                const option = document.createElement("option");
                option.value = location;
                option.textContent = location;
                locationSelect.appendChild(option);
            });
        }

        // Initial location update on page load
        window.onload = updateLocations;
    </script>
</body>
</html>
