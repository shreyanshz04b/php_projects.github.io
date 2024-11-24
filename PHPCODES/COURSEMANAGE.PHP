<?php
session_start();

if (!isset($_SESSION['courses'])) {
    $_SESSION['courses'] = [];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = $_POST['department'];
    $courseName = $_POST['courseName'];
    $instructors = $_POST['instructors'];


    $newCourse = [
        'department' => $department,
        'courseName' => $courseName,
        'instructors' => explode(',', $instructors) // Convert comma-separated string to array
    ];

    // Add the new course to the session
    $_SESSION['courses'][] = $newCourse;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management System</title>
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
            max-width: 600px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #00ffcc;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #00ffcc;
            border-radius: 4px;
            background-color: #222;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #00ffcc;
            color: black;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #00e6b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #00ffcc;
            text-align: left;
        }
        th {
            background-color: #00ffcc;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Course Management System</h1>
        <form method="post">
            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <label for="courseName">Course Name:</label>
            <input type="text" id="courseName" name="courseName" required>

            <label for="instructors">Instructors (comma-separated):</label>
            <input type="text" id="instructors" name="instructors" required>

            <input type="submit" value="Add Course">
        </form>

        <?php if (!empty($_SESSION['courses'])): ?>
            <h2>Courses List</h2>
            <table>
                <tr>
                    <th>Department</th>
                    <th>Course Name</th>
                    <th>Instructors</th>
                </tr>
                <?php foreach ($_SESSION['courses'] as $course): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['department']); ?></td>
                        <td><?php echo htmlspecialchars($course['courseName']); ?></td>
                        <td><?php echo htmlspecialchars(implode(', ', $course['instructors'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No courses added yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>