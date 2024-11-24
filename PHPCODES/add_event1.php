<?php
include 'db1.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO events (name, date, location, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $date, $location, $description]);

    header("Location: index1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
</head>
<body>
    <h1>Add New Event</h1>
    <form method="post">
        <label for="name">Event Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="date">Event Date:</label>
        <input type="date" name="date" required>
        <br>
        <label for="location">Location:</label>
        <input type="text" name="location" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <input type="submit" value="Add Event">
    </form>
    <a href="index1.php">Back to Event List</a>
</body>
</html>