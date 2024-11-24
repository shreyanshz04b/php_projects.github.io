<?php
include 'db1.php';

// Fetch all events
$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
</head>
<body>
    <h1>Event List</h1>
    <a href="add_event1.php">Add New Event</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= $event['id'] ?></td>
                <td><?= $event['name'] ?></td>
                <td><?= $event['date'] ?></td>
                <td><?= $event['location'] ?></td>
                <td><?= $event['description'] ?></td>
                <td>
                    <a href="edit_event.php?id=<?= $event['id'] ?>">Edit</a>
                    <a href="delete_event.php?id=<?= $event['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>