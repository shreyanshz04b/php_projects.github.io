<?php
function calculateShippingCost($zone, $weight, $orderTotal) {
    $baseCosts = [
        "Zone 1" => 5,
        "Zone 2" => 10,
        "Zone 3" => 15,
    ];

    $baseCostPerKg = $baseCosts[$zone];
    $shippingCost = $baseCostPerKg * $weight;

    // Apply discounts
    if ($orderTotal > 200) {
        $shippingCost = 0; // Free shipping
    } elseif ($orderTotal > 100) {
        $shippingCost *= 0.9; // 10% discount
    }

    return "The final shipping cost for a weight of " . $weight . " kg in " . $zone . " is $" . number_format($shippingCost, 2) . ".";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zone = $_POST['zone'];
    $weight = $_POST['weight'];
    $orderTotal = $_POST['orderTotal'];

    if (!empty($zone) && is_numeric($weight) && $weight > 0 && is_numeric($orderTotal)) {
        $result = calculateShippingCost($zone, $weight, $orderTotal);
    } else {
        $result = "Please provide valid inputs.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Shipping Cost Calculator</title>
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
            max-width: 400px;
            margin: auto;
        }
        h1 {
            color: #00ffcc;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        select, input[type="number"] {
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #00ffcc;
            border-radius: 4px;
            background-color: #222;
            color: #fff;
        }
        input[type="submit"] {
            padding: 10px 15px;
            background-color: #00ffcc;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #00e6b3;
        }
        h2 {
            color: #00ffcc;
        }
        p {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Shipping Cost Calculator</h1>
        <form method="post">
            <label for="zone">Select Shipping Zone:</label>
            <select id="zone" name="zone" required>
                <option value="">--Select Shipping Zone--</option>
                <option value="Zone 1">Zone 1</option>
                <option value="Zone 2">Zone 2</option>
                <option value="Zone 3">Zone 3</option>
            </select>
            <label for="weight">Order Weight (kg):</label>
            <input type="number" id="weight" name="weight" required min="1" step="0.1">
            <label for="orderTotal">Total Order Amount ($):</label>
            <input type="number" id="orderTotal" name="orderTotal" required min="0" step="0.01">
            <input type="submit" value="Calculate Shipping Cost">
        </form>

        <?php
        if (isset($result)) {
            echo "<h2>Result:</h2>";
            echo "<p>$result</p>";
        }
        ?>
    </div>
</body>
</html>