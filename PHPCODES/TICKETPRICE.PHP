<?php
function calculateTicketPrice($age, $day) {
    $base_price = 10;
    $final_price = $base_price;

    if (in_array($day, ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"])) {
        if ($age < 12) {
            $final_price *= 0.5;
        } elseif ($age > 60) {
            $final_price *= 0.7;
        }
    } elseif (in_array($day, ["Saturday", "Sunday"])) {
        if ($age < 12) {
            $final_price *= 0.75;
        } elseif ($age > 60) {
            $final_price *= 0.85;
        }
    }

    return "The ticket price for a " . $age . " year old on " . $day . " is $" . number_format($final_price, 2) . ".";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age = $_POST['age'];
    $day = $_POST['day'];

    if (is_numeric($age) && $age >= 0 && !empty($day)) {
        $result = calculateTicketPrice($age, $day);
    } else {
        $result = "Please provide a valid age and day.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Booking</title>
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
        input[type="number"], select {
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
        <h1>Movie Ticket Booking System</h1>
        <form method="post">
            <label for="age">Your Age:</label>
            <input type="number" id="age" name="age" required min="0">
            <label for="day">Select Day:</label>
            <select id="day" name="day" required>
                <option value="">--Select a Day--</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
            <input type="submit" value="Calculate Ticket Price">
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