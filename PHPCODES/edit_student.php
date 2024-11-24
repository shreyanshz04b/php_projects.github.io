<?php
include 'db1.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $grade = $_POST['grade'];

    $ stmt = $pdo->prepare("UPDATE students SET name = ?, age = ?, email = ?, grade = ? WHERE id = ?");
    $stmt->execute([$name, $age, $email, $grade, $id]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= $student['name'] ?>" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" name="age" value="<?= $student['age'] ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= $student['email'] ?>" required>
        <br>
        <label for="grade">Grade:</label>
        <select name="grade" required>
            <option value="A" <?= $student['grade'] === 'A' ? 'selected' : '' ?>>A</option>
            <option value="B" <?= $student['grade'] === 'B' ? 'selected' : '' ?>>B</option>
            <option value="C" <?= $student['grade'] === 'C' ? 'selected' : '' ?>>C</option>
        </select>
        <br>
        <input type="submit" value="Update Student">
    </form>
    <a href="index.php">Back to Student List</a>
</body>
</html>