<?php
session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

function calculateAverageAndStatus($grades) {
    if (empty($grades)) {
        return ['average' => 0, 'status' => 'N/A'];
    }
    
    $total = array_sum($grades);
    $average = $total / count($grades);
    $status = $average >= 60 ? 'Passed' : 'Failed';

    return ['average' => round($average, 2), 'status' => $status];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_student'])) {
        $studentName = htmlspecialchars($_POST['student_name']);
        $grades = array_map('floatval', $_POST['grades']);
        $_SESSION['students'][$studentName] = $grades;
    }

    if (isset($_POST['update_grades'])) {
        $studentName = htmlspecialchars($_POST['student_name']);
        $grades = array_map('floatval', $_POST['grades']);
        if (isset($_SESSION['students'][$studentName])) {
            $_SESSION['students'][$studentName] = $grades;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Management System</title>
    <style>
        body {
            background-color: black;
            font-family: Arial, sans-serif;
            color: white;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0PX 0PX 10PX cyan;
        }
        th, td {
            border: 1px solid white;
            padding: 8px;
            text-align: left;
            box-shadow: 0PX 0PX 10PX cyan;
        }
        th {
            background-color: gray;
        }
    </style>
</head>
<body>
    <h1>Grade Management System</h1>
    
    <form method="POST">
        <h2>Add Student Grades</h2>
        <input type="text" name="student_name" placeholder="Student Name" required>
        <input type="text" name="grades[]" placeholder="Grade 1" required>
        <input type="text" name="grades[]" placeholder="Grade 2" required>
        <input type="text" name="grades[]" placeholder="Grade 3" required>
        <button type="submit" name="add_student">Add Grades</button>
    </form>

    <form method="POST">
        <h2>Update Student Grades</h2>
        <input type="text" name="student_name" placeholder="Student Name" required>
        <input type="text" name="grades[]" placeholder="New Grade 1" required>
        <input type="text" name="grades[]" placeholder="New Grade 2" required>
        <input type="text" name="grades[]" placeholder="New Grade 3" required>
        <button type="submit" name="update_grades">Update Grades</button>
    </form>

    <h2>Student Performance Report</h2>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Grades</th>
            <th>Average</th>
            <th>Status</th>
        </tr>
        <?php foreach ($_SESSION['students'] as $name => $grades): 
            $result = calculateAverageAndStatus($grades);
        ?>
        <tr>
            <td><?php echo htmlspecialchars($name); ?></td>
            <td><?php echo implode(', ', $grades); ?></td>
            <td><?php echo $result['average']; ?></td>
            <td><?php echo $result['status']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>