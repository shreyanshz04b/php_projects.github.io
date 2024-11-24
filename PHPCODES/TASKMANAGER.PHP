<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        $taskDescription = htmlspecialchars($_POST['task_description']);
        $taskDeadline = htmlspecialchars($_POST['task_deadline']);
        $taskPriority = htmlspecialchars($_POST['task_priority']);
        
        $_SESSION['tasks'][] = [
            'description' => $taskDescription,
            'deadline' => $taskDeadline,
            'priority' => $taskPriority,
            'completed' => false
        ];
    }

    if (isset($_POST['complete_task'])) {
        $taskIndex = (int)$_POST['task_index'];
        if (isset($_SESSION['tasks'][$taskIndex])) {
            $_SESSION['tasks'][$taskIndex]['completed'] = true;
        }
    }
}

$priorities = ['high', 'medium', 'low'];
$sortedTasks = array_filter($_SESSION['tasks'], function($task) {
    return !$task['completed'];
});
usort($sortedTasks, function($a, $b) {
    $priorityOrder = array_flip($priorities);
    return $priorityOrder[$a['priority']] <=> $priorityOrder[$b['priority']];
});

$summary = [
    'high' => 0,
    'medium' => 0,
    'low' => 0,
];

foreach ($_SESSION['tasks'] as $task) {
    if (!$task['completed']) {
        $summary[$task['priority']]++;
    }
}

$completedTasks = array_filter($_SESSION['tasks'], function($task) {
    return $task['completed'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <style>
        body {
            background-color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: white;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #222;
            padding: 20px;
            box-shadow: 0 0 10px cyan;
        }
        h1, h2 {
            text-align: center;
            color: cyan;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: cyan;
            color: black;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #00bcd4;
        }
        .task {
            border-bottom: 1px solid #444;
            padding: 10px 0;
        }
        .completed {
            text-decoration: line-through;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Task Manager</h1>

        <form method="POST">
            <h2>Add Task</h2>
            <input type="text" name="task_description" placeholder="Task Description" required>
            <input type="date" name="task_deadline" required>
            <select name="task_priority" required>
                <option value="" disabled selected>Select Priority</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
            <button type="submit" name="add_task">Add Task</button>
        </form>

        <h2>Task Summary</h2>
        <p>High Priority: <?php echo $summary['high']; ?></p>
        <p>Medium Priority: <?php echo $summary['medium']; ?></p>
        <p>Low Priority: <?php echo $summary['low']; ?></p>

        <h2>Tasks</h2>
        <?php if (empty($sortedTasks)): ?>
            <p>No tasks available.</p>
        <?php else: ?>
            <?php foreach ($sortedTasks as $index => $task): ?>
                <div class="task <?php echo $task['completed'] ? 'completed' : ''; ?>">
                    <strong><?php echo htmlspecialchars($task['description']); ?></strong> - 
                    <em>Deadline: <?php echo htmlspecialchars($task ['deadline']); ?></em> - 
                    <span>Priority: <?php echo htmlspecialchars(ucfirst($task['priority'])); ?></span>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="task_index" value="<?php echo $index; ?>">
                        <button type="submit" name="complete_task">Complete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h2>Completed Tasks</h2>
        <?php if (empty($completedTasks)): ?>
            <p>No completed tasks.</p>
        <?php else: ?>
            <?php foreach ($completedTasks as $task): ?>
                <div class="task completed">
                    <strong><?php echo htmlspecialchars($task['description']); ?></strong> - 
                    <em>Deadline: <?php echo htmlspecialchars($task['deadline']); ?></em> - 
                    <span>Priority: <?php echo htmlspecialchars(ucfirst($task['priority'])); ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>