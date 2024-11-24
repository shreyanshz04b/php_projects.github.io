<?php
include 'db1.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $grade = $_POST['grade'];

    $stmt = $pdo->prepare("INSERT INTO students (name, age, email, grade) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $age, $email, $grade]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>
<body>
    <h1>Add New Student</h1>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" name="age" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="grade">Grade:</label>
        <select name="grade" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
        </select>
        <br>
        <input type="submit" value="Add Student">
    </form>
    <a href="index.php">Back to Student List</a>
</body>
</html>