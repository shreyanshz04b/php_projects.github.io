<?php
function calculateTuitionFee($programType, $creditHours, $hasScholarship) {
    $baseRates = [
        "Undergraduate" => 300,
        "Graduate" => 500,
        "PhD" => 800,
    ];

    $additionalFees = 50 + 100; // Library Fee + Technology Fee
    $baseRate = $baseRates[$programType];

    // Calculate tuition fee
    $tuitionFee = $baseRate * $creditHours + $additionalFees;

    // Apply discounts
    if ($hasScholarship) {
        $tuitionFee *= 0.80; // 20% scholarship discount
    }
    if ($creditHours >= 15) {
        $tuitionFee *= 0.90; // 10% discount for 15 or more credit hours
    }

    return "The total tuition fee for a " . $programType . " program with " . $creditHours . " credit hours is $" . number_format($tuitionFee, 2) . ".";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $programType = $_POST['programType'];
    $creditHours = $_POST['creditHours'];
    $hasScholarship = isset($_POST['scholarship']) && $_POST['scholarship'] === 'yes';

    if (!empty($programType) && is_numeric($creditHours) && $creditHours > 0) {
        $result = calculateTuitionFee($programType, $creditHours, $hasScholarship);
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
    <title>Tuition Fee Calculator</title>
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
        select, input[type="number"], input[type="checkbox"] {
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
        <h1>Tuition Fee Calculator</h1>
        <form method="post">
            <label for="programType">Select Program Type:</label>
            <select id="programType" name="programType" required>
                <option value="">--Select Program Type--</option>
                <option value="Undergraduate">Undergraduate</option>
                <option value="Graduate">Graduate</option>
                <option value="PhD">PhD</option>
            </select>
            <label for="creditHours">Number of Credit Hours:</label>
            <input type="number" id="creditHours" name="creditHours" required min="1">
            <label for="scholarship">Do you have a Scholarship?</label>
            <select id="scholarship" name="scholarship">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
            <input type="submit" value="Calculate Tuition Fee">
        </form>

        <?php
        if (isset($result)) echo "<h2>Result:</h2>";
            echo "<p>$result</p>";
        ?>
    </div>
</body>
</html>