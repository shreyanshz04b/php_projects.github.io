<?php
function calculateShippingFee($destination, $weight) {
    $shipping_fee = 0;
    $is_domestic = false;

    if ($destination == "India") {
        $is_domestic = true;
        if ($weight <= 5) {
            $shipping_fee = 10;
        } else {
            $shipping_fee = 15;
        }
    } elseif ($destination == "USA") {
        $is_domestic = false; 
        if ($weight <= 5) {
            $shipping_fee = 20;
        } else {
            $shipping_fee = 30;
        }
    } else {
        $north_america = ["Canada", "Mexico"];
        $europe = ["UK", "France", "Germany"];
        $asia = ["China", "Japan"];

        if (in_array($destination, $north_america)) {
            if ($weight <= 5) {
                $shipping_fee = 20;
            } else {
                $shipping_fee = 30;
            }
        } elseif (in_array($destination, $europe)) {
            if ($weight <= 5) {
                $shipping_fee = 25;
            } else {
                $shipping_fee = 35;
            }
        } elseif (in_array($destination, $asia)) {
            if ($weight <= 5) {
                $shipping_fee = 40;
            } else {
                $shipping_fee = 50;
            }
        } else {
            return "Shipping to this destination is not available.";
        }
    }

    $type = $is_domestic ? "domestic" : "international";
    return "The shipping fee to " . htmlspecialchars($destination) . " for a package weighing " . htmlspecialchars($weight) . " kg is $$shipping_fee (Type: $type).";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destination = trim($_POST['destination']);
    $weight = $_POST['weight'];

    if (!empty($destination) && is_numeric($weight) && $weight > 0) {
        $result = calculateShippingFee($destination, $weight);
    } else {
        $result = "Please provide a valid destination and weight.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Fee Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: black;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px cyan;
        }

        h1 {
            text-align: center;
            color: cyan;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: #333;
            color: white;
        }

        input[type="submit"] {
            background-color: cyan;
            color: black;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #00bcd4;
        }

        .result {
            margin-top: 20px;
            font-size: 1.2em;
            color: cyan;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Shipping Fee Calculator</h1>
        <form method="post">
            <div class="form-group">
                <label for="destination">Destination Country:</label>
                <select id="destination" name="destination" required>
                    <option value="">Select a country</option>
                    <option value="USA">USA</option>
                    <option value="Canada">Canada</option>
                    <option value="Mexico">Mexico</option>
                    <option value="UK">UK</option>
                    <option value="France">France</option>
                    <option value="Germany">Germany</option>
                    <option value="China">China</option>
                    < option value="Japan">Japan</option>
                    <option value="India">India</option>
                </select>
            </div>
            <div class="form-group">
                <label for="weight">Package Weight (kg):</label>
                <input type="number" id="weight" name="weight" min="0.1" step="0.1" required>
            </div>
            <input type="submit" value="Calculate Shipping Fee">
        </form>
        <?php if (isset($result)): ?>
            <div class="result"><?php echo $result; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>