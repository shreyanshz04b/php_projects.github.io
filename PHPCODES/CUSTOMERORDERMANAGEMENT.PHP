<?php
session_start();

if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['place_order'])) {
        $productName = htmlspecialchars($_POST['product_name']);
        $productPrice = (float)$_POST['product_price'];
        $productQuantity = (int)$_POST['product_quantity'];

        $_SESSION['orders'][] = [
            'name' => $productName,
            'price' => $productPrice,
            'quantity' => $productQuantity,
        ];
    }

    if (isset($_POST['update_order'])) {
        $orderIndex = (int)$_POST['order_index'];
        $newQuantity = (int)$_POST['new_quantity'];
        if (isset($_SESSION['orders'][$orderIndex])) {
            $_SESSION['orders'][$orderIndex]['quantity'] = $newQuantity;
        }
    }
}

$totalRevenue = 0;
foreach ($_SESSION['orders'] as $order) {
    $totalRevenue += $order['price'] * $order['quantity'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <style>
        body {
            background-color: black;
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #222;
            padding: 20px;
            box-shadow: 0 0 10px cyan;
        }
        h1, h2 {
            text-align: center;
            color: cyan;
        }
        input, button, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: cyan;
            color: black;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #00bcd4;
        }
        .order {
            border-bottom: 1px solid #444;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>E-Commerce Order Management</h1>

        <form method="POST">
            <h2>Place Order</h2>
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="number" step="0.01" name="product_price" placeholder="Product Price" required>
            <input type="number" name="product_quantity" placeholder="Quantity" required>
            <button type="submit" name="place_order">Place Order</button>
        </form>

        <h2>Orders</h2>
        <?php if (empty($_SESSION['orders'])): ?>
            <p>No orders placed yet.</p>
        <?php else: ?>
            <?php foreach ($_SESSION['orders'] as $index => $order): ?>
                <div class="order">
                    <strong><?php echo htmlspecialchars($order['name']); ?></strong> - 
                    Price: $<?php echo number_format($order['price'], 2); ?> - 
                    Quantity: <form method="POST" style="display:inline;">
                        <input type="number" name="new_quantity" value="<?php echo $order['quantity']; ?>" min="1" required>
                        <input type="hidden" name="order_index" value="<?php echo $index; ?>">
                        <button type="submit" name="update_order">Update</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <h3>Total Revenue: $<?php echo number_format($totalRevenue, 2); ?></h3>
        <?php endif; ?>
    </div>
</body>
</html>