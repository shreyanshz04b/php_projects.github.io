<?php
function calculateBookingCost($roomType, $month, $nights) {
    $baseRates = [
        "Standard" => 100,
        "Deluxe" => 150,
        "Suite" => 200,
    ];

    $baseRate = $baseRates[$roomType];
    
    if (in_array($month, ["June", "July", "August"])) {
        $baseRate *= 1.2; // High Season
    } elseif (in_array($month, ["December", "January", "February"])) {
        $baseRate *= 0.85; // Low Season
    }

    $totalCost = $baseRate * $nights;

    if ($nights >= 5) {
        $totalCost *= 0.9; // Long Stay Discount
    }

    return "The total booking cost for a " . $roomType . " for " . $nights . " nights in " . $month . " is $" . number_format($totalCost, 2) . ".";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomType = $_POST['roomType'];
    $month = $_POST['month'];
    $nights = $_POST['nights'];

    if (!empty($roomType) && !empty($month) && is_numeric($nights) && $nights > 0) {
        $result = calculateBookingCost($roomType, $month, $nights);
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
    <title>Hotel Booking System</title>
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
        <h1>Hotel Booking System</h1>
        <form method="post">
            <label for="roomType">Select Room Type:</label>
            <select id="roomType" name="roomType" required>
                <option value="">--Select Room Type--</option>
                <option value="Standard">Standard Room</option>
                <option value="Deluxe">Deluxe Room</option>
                <option value="Suite">Suite</option>
            </select>
            <label for="month">Select Month:</label>
            <select id="month" name="month" required>
                <option value="">--Select Month--</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
 </select>
            <label for="nights">Number of Nights:</label>
            <input type="number" id="nights" name="nights" required min="1">
            <input type="submit" value="Calculate Total Cost">
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