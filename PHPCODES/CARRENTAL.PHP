<?php
function calculateRentalCost($carType, $rentalDays, $month) {
    $dailyRates = [
        "Economy" => 30,
        "Standard" => 50,
        "Luxury" => 100,
    ];

    $baseRate = $dailyRates[$carType];
    
    // Seasonal adjustments
    if (in_array($month, ["June", "July", "August"])) {
        $baseRate *= 1.25; // Peak Season
    } elseif (in_array($month, ["November", "December", "January"])) {
        $baseRate *= 0.85; // Off-Season
    }

    // Calculate total cost
    $totalCost = $baseRate * $rentalDays;

    // Long rental discount
    if ($rentalDays >= 7) {
        $totalCost *= 0.88; // 12% discount
    }

    return "The total rental cost for a " . $carType . " for " . $rentalDays . " days in " . $month . " is $" . number_format($totalCost, 2) . ".";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carType = $_POST['carType'];
    $rentalDays = $_POST['rentalDays'];
    $month = $_POST['month'];

    if (!empty($carType) && is_numeric($rentalDays) && $rentalDays > 0) {
        $result = calculateRentalCost($carType, $rentalDays, $month);
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
    <title>Car Rental System</title>
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
        <h1>Car Rental Cost Calculator</h1>
        <form method="post">
            <label for="carType">Select Car Type:</label>
            <select id="carType" name="carType" required>
                <option value="">--Select Car Type--</option>
                <option value="Economy">Economy</option>
                <option value="Standard">Standard</option>
                <option value="Luxury">Luxury</option>
            </select>
            <label for="rentalDays">Rental Period (Days):</label>
            <input type="number" id="rentalDays" name="rentalDays" required min="1">
            <label for="month">Select Month:</label>
            <select id="month" name="month" required>
                <option value="">--Select Month--</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value=" July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
            <input type="submit" value="Calculate Rental Cost">
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