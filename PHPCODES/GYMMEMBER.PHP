<?php
function calculateMembershipCost($membershipType, $months, $hasReferralCode) {
    $monthlyFees = [
        "Basic" => 30,
        "Standard" => 45,
        "Premium" => 60,
    ];

    $baseCost = $monthlyFees[$membershipType];
    $totalCost = $baseCost * $months;

    // Apply discounts
    if ($months == 12) {
        $totalCost *= 0.85; // 15% discount for 12-month membership
    }
    if ($hasReferralCode) {
        $totalCost *= 0.95; // Additional 5% discount for referral code
    }

    return "The total membership cost for a " . $membershipType . " membership for " . $months . " months is $" . number_format($totalCost, 2) . ".";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membershipType = $_POST['membershipType'];
    $months = $_POST['months'];
    $hasReferralCode = isset($_POST['referralCode']) && $_POST['referralCode'] === 'yes';

    if (!empty($membershipType) && is_numeric($months) && $months > 0) {
        $result = calculateMembershipCost($membershipType, $months, $hasReferralCode);
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
    <title>Gym Membership Cost Calculator</title>
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
        <h1>Gym Membership Cost Calculator</h1>
        <form method="post">
            <label for="membershipType">Select Membership Type:</label>
            <select id="membershipType" name="membershipType" required>
                <option value="">--Select Membership Type--</option>
                <option value="Basic">Basic</option>
                <option value="Standard">Standard</option>
                <option value="Premium">Premium</option>
            </select>
            <label for="months">Membership Length (Months):</label>
            <input type="number" id="months" name="months" required min="1">
            <label for="referralCode">Have a Referral Code?</label>
            <select id="referralCode" name="referralCode">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
            <input type="submit" value="Calculate Membership Cost">
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