<?php
session_start();

// Sample data for reviews with specified guest names
$reviews = [
    [
        "guest_name" => "Vinay Sharma",
        "rating" => 5,
        "room_type" => "Deluxe",
        "duration" => "Long Stay",
        "comment" => "Had a wonderful experience! The service was excellent.",
        "date" => "2023-10-01"
    ],
    [
        "guest_name" => "Anuj Kumar",
        "rating" => 4,
        "room_type" => "Standard",
        "duration" => "Short Stay",
        "comment" => "Good value for the price.",
        "date" => "2023-09-15"
    ],
    [
        "guest_name" => "Narendra Mohan",
        "rating" => 3,
        "room_type" => "Suite",
        "duration" => "Long Stay",
        "comment" => "The room was nice, but the service could improve.",
        "date" => "2023-08-25"
    ],
    [
        "guest_name" => "Anuj Mangal",
        "rating" => 5,
        "room_type" => "Deluxe",
        "duration" => "Short Stay",
        "comment" => "Absolutely loved it! Will come back for sure.",
        "date" => "2023-10-10"
    ],
    [
        "guest_name" => "Rohit Agarwal",
        "rating" => 2,
        "room_type" => "Standard",
        "duration" => "Long Stay",
        "comment" => "Not what I expected. Disappointed with the cleanliness.",
        "date" => "2023-09-30"
    ],
];

// Handle filtering
$filteredReviews = $reviews;
if (isset($_GET['filter'])) {
    $filterRoomType = $_GET['room_type'];
    $filterDuration = $_GET['duration'];

    $filteredReviews = array_filter($reviews, function($review) use ($filterRoomType, $filterDuration) {
        return ($filterRoomType === 'All' || $review['room_type'] === $filterRoomType) &&
               ($filterDuration === 'All' || $review['duration'] === $filterDuration);
    });
}

// Function to convert rating to star emoji
function getStarRating($rating) {
    return str_repeat("⭐", $rating);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayEasy Guest Feedback</title>
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
            background: black;
            padding: 20px;
            box-shadow: 0 0 10px cyan;
        }
        h1 {
            text-align: center;
        }
        .review {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .review:last-child {
            border-bottom: none;
        }
        .filter {
            margin-bottom: 20px;
        }
        .filter select {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Guest Feedback</h1>

        <!-- Filter Options -->
        <div class="filter">
            <h2>Filter Feedback</h2>
            <form method="GET">
                <select name="room_type">
                    <option value="All">All Room Types</option>
                    <option value="Standard">Standard</option>
                    <option value="Deluxe">Deluxe</option>
                    <option value="Suite">Suite</option>
                </select>
                <select name="duration">
                    <option value="All">All Durations</option>
                    <option value="Short Stay">Short Stay</option>
                    <option value="Long Stay">Long Stay</option>
                </select>
                <button type="submit" name="filter">Filter</button>
            </form>
        </div>

        <!-- Display Reviews -->
        <h2>Reviews</h2>
        <?php foreach ($filteredReviews as $review): ?>
            <div class="review">
                <strong><?php echo htmlspecialchars($review['guest_name']); ?></strong> (<?php echo getStarRating($review['rating']); ?>) - 
                <em><?php echo htmlspecialchars($review['room_type']); ?>, <?php echo htmlspecialchars($review['duration']); ?></em>
                <p><?php echo htmlspecialchars($review['comment']); ?></p>
                <small><?php echo $review['date']; ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>