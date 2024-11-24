<?php
include 'db1.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE events SET name = ?, date = ?, location = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $date, $location, $description, $id]);

    header("Location: index1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>
    <h1>Edit Event</h1>
    <form method="post">
        <label for="name">Event Name:</label>
        <input type="text" name="name" value="<?= $event['name'] ?>" required>
        <br>
        <label for="date">Event Date:</label>
        <input type="date" name="date" value="<?= $event['date'] ?>" required>
        <br>
        <label for="location">Location:</label>
        <input type="text" name="location" value="<?= $event['location'] ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required><?= $event['description'] ?></textarea>
        <br>
        <input type="submit" value="Update Event">
    </form>
    <a href="index1.php">Back to Event List</a>
</body>
</html>