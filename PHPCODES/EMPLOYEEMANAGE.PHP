<?php
session_start();

// Initialize employees array in session if it doesn't exist
if (!isset($_SESSION['employees'])) {
    $_SESSION['employees'] = [];
}

// Handle form submission to add an employee
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $department = $_POST['department'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    // Create a new employee entry
    $newEmployee = [
        'department' => $department,
        'name' => $name,
        'position' => $position,
        'salary' => $salary
    ];

    // Add the new employee to the session
    $_SESSION['employees'][] = $newEmployee;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
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
        input[type="text"], input[type="number"], input[type="submit"] {
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
        <h1>Employee Management System</h1>
        <form method="post">
            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <label for="name">Employee Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required>

            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" required>

            <input type="hidden" name="action" value="add">
            <input type="submit" value="Add Employee">
        </form>

        <?php if (!empty($_SESSION['employees'])): ?>
            <h2>Employees List</h2>
            <?php
            // Group employees by department
            $employeesByDepartment = [];
            foreach ($_SESSION['employees'] as $employee) {
                $employeesByDepartment[$employee['department']][] = $employee;
            }
            ?>

            <?php foreach ($employeesByDepartment as $department => $employees): ?>
                <h3><?php echo htmlspecialchars($department); ?></h3>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Salary</th>
                    </tr>
                    <?php foreach ($employees as $emp): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($emp['name']); ?></td>
                            <td><?php echo htmlspecialchars($emp['position']); ?></td>
                            <td><?php echo htmlspecialchars($emp['salary']); ?></td>
                        </tr>
                    <?php endforeach; ?>
 </table>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>