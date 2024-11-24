<?php
function getStudents() {
    if (file_exists('students.json')) {
        $studentsJson = file_get_contents('students.json');
        return json_decode($studentsJson, true);
    }
    return [];
}

function saveStudents($students) {
    file_put_contents('students.json', json_encode($students, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $students = getStudents();
        if ($_POST['action'] === 'add_student') {
            $students[] = [
                'name' => $_POST['name'],
                'attendance' => []
            ];
            saveStudents($students);
        } elseif ($_POST['action'] === 'mark_attendance') {
            $index = $_POST['index'];
            $date = $_POST['date'];
            $status = $_POST['status'];
            $students[$index]['attendance'][$date] = $status;
            saveStudents($students);
        } elseif ($_POST['action'] === 'delete_attendance') {
            $index = $_POST['index'];
            $date = $_POST['date'];
            unset($students[$index]['attendance'][$date]);
            saveStudents($students);
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$students = getStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Tracker</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            text-shadow: 2px 2px 4px cyan;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid cyan;
            text-align: left;
        }
        th {
            background-color: rgba(0, 255, 255, 0.2);
        }
        tr:hover {
            background-color: rgba(0, 255, 255, 0.1);
        }
        input[type="text"], input[type="date"], select {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid cyan;
            border-radius: 5px;
            background-color: black;
            color: white;
            box-shadow: 2px 2px 5px cyan;
        }
        input[type="submit"] {
            padding: 5px 10px;
            background-color: cyan;
            border: none;
            border-radius: 5px;
            color: black;
            cursor: pointer;
            box-shadow: 2px 2px 5px cyan;
        }
        input[type="submit"]:hover {
            background-color: rgba(0, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <h1>Student Attendance Tracker</h1>
    
    <form method="post">
        <h2>Add New Student</h2>
        <input type="hidden" name="action" value="add_student">
        <label for="name">Student Name:</label>
        <input type="text" name="name" required>
        <input type="submit" value="Add Student">
    </form>

    <h2>Student Attendance Records</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Attendance</th>
            <th>Mark Attendance</th>
        </tr>
        <?php foreach ($students as $index => $student): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($student['attendance'] as $date => $status): ?>
                            <tr>
                                <td><?= htmlspecialchars($date) ?></td>
                                <td><?= htmlspecialchars($status) ?></td>
                                <td>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="action" value="delete_attendance">
                                        < input type="hidden" name="index" value="<?= $index ?>">
                                        <input type="hidden" name="date" value="<?= $date ?>">
                                        <input type="submit" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="action" value="mark_attendance">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <label for="date">Date:</label>
                        <input type="date" name="date" required>
                        <select name="status" required>
                            <option value="">Select Status</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                        <input type="submit" value="Mark Attendance">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>