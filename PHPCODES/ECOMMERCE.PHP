<?php
session_start();

// Initialize orders and customers arrays in session if they don't exist
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [];
}
if (!isset($_SESSION['customers'])) {
    $_SESSION['customers'] = [];
}

// Handle form submission to add an order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $customerName = trim($_POST['customer_name']);
    $product = trim($_POST['product']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $totalAmount = $quantity * $price;

    // Create a new order entry
    $newOrder = [
        'customer_name' => $customerName,
        'product' => $product,
        'quantity' => $quantity,
        'total_amount' => $totalAmount
    ];

    // Add the new order to the session
    $_SESSION['orders'][] = $newOrder;

    // Update customer spending and favorite products
    if (!isset($_SESSION['customers'][$customerName])) {
        $_SESSION['customers'][$customerName] = [
            'total_spent' => 0,
            'favorite_products' => [] // Initialize as an empty array
        ];
    }
    $_SESSION['customers'][$customerName]['total_spent'] += $totalAmount;

    // Update favorite products
    if (!in_array($product, $_SESSION['customers'][$customerName]['favorite_products'])) {
        $_SESSION['customers'][$customerName]['favorite_products'][] = $product;
    }
}

// Handle order removal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'remove') {
    $index = intval($_POST['index']);
    if (isset($_SESSION['orders'][$index])) {
        // Update customer spending
        $order = $_SESSION['orders'][$index];
        $customerName = $order['customer_name'];
        $_SESSION['customers'][$customerName]['total_spent'] -= $order['total_amount'];
        
        // Remove the order
        unset($_SESSION['orders'][$index]);
        $_SESSION['orders'] = array_values($_SESSION['orders']); // Reindex the array
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #000;
            color: #fff;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px cyan;
            max-width: 600px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #00ffcc;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"], input[type="submit"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #00ffcc;
            border-radius: 4px;
            background-color: #222;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #00ffcc;
            color: black;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #00e6b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #00ffcc;
            text-align: left;
        }
        th {
            background-color: #00ffcc;
            color: black }
        .remove-button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>E-Commerce Management System</h1>
        <form method="post">
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="product">Product:</label>
            <input type="text" id="product" name="product" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" required>

            <label for="price">Price per Unit:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <input type="hidden" name="action" value="add">
            <input type="submit" value="Add Order">
        </form>

        <?php if (!empty($_SESSION['orders'])): ?>
            <h2>Order Summary</h2>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($_SESSION['orders'] as $index => $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['product']); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="remove-button">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h2>Customer Profiles</h2>
            <?php foreach ($_SESSION['customers'] as $name => $profile): ?>
                <h3><?php echo htmlspecialchars($name); ?></h3>
                <p>Total Spent: <?php echo htmlspecialchars(number_format($profile['total_spent'] ?? 0, 2)); ?></p>
                <p>Favorite Products: <?php echo htmlspecialchars(implode(', ', $profile['favorite_products'] ?? [])); ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>