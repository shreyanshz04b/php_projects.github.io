<?php
$discount = 0;
$discountAmount = 0;
$finalAmount = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $membershipStatus = $_POST['membershipStatus'];
    $orderAmount = floatval($_POST['orderAmount']);

    if ($membershipStatus === 'premium') {
        if ($orderAmount >= 100) {
            $discount = 0.20; // 20% discount
        } else {
            $discount = 0.10; // 10% discount
        }
    } elseif ($membershipStatus === 'regular') {
        if ($orderAmount >= 100) {
            $discount = 0.15; // 15% discount
        } else {
            $discount = 0.05; // 5% discount
        }
    } elseif ($membershipStatus === 'none') {
        $discount = 0; // No discount
    }

    $discountAmount = $orderAmount * $discount;
    $finalAmount = $orderAmount - $discountAmount;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 4PX 8PX 4PX 8PX cyan;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #212345;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Discount Calculator</h1>
        <form action="" method="POST">
            <label for="membershipStatus">Membership Status:</label>
            <select name="membershipStatus" id="membershipStatus" required>
                <option value="none">None</option>
                <option value="regular">Regular Member</option>
                <option value="premium">Premium Member</option>
            </select>

            <label for="orderAmount">Order Amount ($):</label>
            <input type="number" name="orderAmount" id="orderAmount" step="0.01" required>

            <button type="submit">Calculate Discount</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <div class="result">
                <h2>Discount Summary</h2>
                <p>Order Amount: $<?php echo number_format($orderAmount, 2); ?></p>
                <p>Discount Percentage: <?php echo ($discount * 100); ?>%</p>
                <p>Discount Amount: $<?php echo number_format($discountAmount, 2); ?></p>
                <p>Final Amount: $<?php echo number_format($finalAmount, 2); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>