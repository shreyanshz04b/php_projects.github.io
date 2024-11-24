<?php
session_start();

// Initialize orders array in session if it doesn't exist
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [];
}

// Handle form submission to add an order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $customerName = $_POST['customer_name'];
    $amountSpent = $_POST['amount_spent'];

    // Create a new order entry
    $newOrder = [
        'customer_name' => $customerName,
        'amount_spent' => floatval($amountSpent)
    ];

    // Add the new order to the session
    $_SESSION['orders'][] = $newOrder;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management System</title>
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
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Management System</h1>
        <form method="post">
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="amount_spent">Amount Spent:</label>
            <input type="number" id="amount_spent" name="amount_spent" step="0.01" required>

            <input type="hidden" name="action" value="add">
            <input type="submit" value="Add Order">
        </form>

        <?php if (!empty($_SESSION['orders'])): ?>
            <h2>Orders List</h2>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Amount Spent</th>
                </tr>
                <?php foreach ($_SESSION['orders'] as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($order['amount_spent'], 2)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h2>Customer Spending Report</h2>
            <?php
            // Calculate total spending per customer
            $spendingReport = [];
            foreach ($_SESSION['orders'] as $order) {
                $name = $order['customer_name'];
                if (!isset($spendingReport[$name])) {
                    $spendingReport[$name] = 0;
                }
                $spendingReport[$name] += $order['amount_spent'];
            }
            ?>

            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Total Spent</th>
                </tr>
                <?php foreach ($spendingReport as $name => $totalSpent): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($name); ?></td>
                        <td><?php echo htmlspecialchars(number_format($totalSpent, 2)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>