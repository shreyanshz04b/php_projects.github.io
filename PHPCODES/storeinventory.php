<?php
session_start();

if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = htmlspecialchars($_POST['product_name']);
    $productPrice = (float)$_POST['product_price'];
    $_SESSION['inventory'][] = [
        'name' => $productName,
        'price' => $productPrice
    ];
}

$totalPrice = array_sum(array_column($_SESSION['inventory'], 'price'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store Inventory</title>
    <style>
        body {
            background-color: black;
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #333;
            padding: 20px;
            box-shadow: 0 0 10px cyan;
        }
        h1, h2, h3 {
            text-align: center;
        }
        .product {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .product:last-child {
            border-bottom: none;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
        }
        input[type="text"], input[type="number"] {
            background: #555;
            color: #fff;
        }
        button {
            background: cyan;
            color: black;
            cursor: pointer;
        }
        button:hover {
            background: #00bcd4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Online Store Inventory</h1>

        <form method="POST">
            <h2>Add a Product</h2>
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="number" step="0.01" name="product_price" placeholder="Product Price" required>
            <button type="submit">Add Product</button>
        </form>

        <h2>Inventory List</h2>
        <?php if (empty($_SESSION['inventory'])): ?>
            <p>No products added yet.</p>
        <?php else: ?>
            <?php foreach ($_SESSION['inventory'] as $product): ?>
                <div class="product">
                    <strong><?php echo htmlspecialchars($product['name']); ?></strong> - 
                    <em>$<?php echo number_format($product['price'], 2); ?></em>
                </div>
            <?php endforeach; ?>
            <h3>Total Price: $<?php echo number_format($totalPrice, 2); ?></h3>
        <?php endif; ?>
    </div>
</body>
</html>