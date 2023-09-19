<?php
session_start();

// Initialize an empty array to store tasks
$tasks = [];

// Check if tasks are stored in the session
if (isset($_SESSION['tasks'])) {
    $tasks = $_SESSION['tasks'];
}

// Add a new task
if (isset($_POST['task']) && !empty($_POST['task'])) {
    $newTask = $_POST['task'];
    array_push($tasks, ['task' => $newTask, 'completed' => false]);
    $_SESSION['tasks'] = $tasks;
}

// Mark a task as completed
if (isset($_GET['complete']) && is_numeric($_GET['complete'])) {
    $taskIndex = $_GET['complete'];
    if (isset($tasks[$taskIndex])) {
        $tasks[$taskIndex]['completed'] = true;
        $_SESSION['tasks'] = $tasks;
    }
}

// Delete a task
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $taskIndex = $_GET['delete'];
    if (isset($tasks[$taskIndex])) {
        array_splice($tasks, $taskIndex, 1);
        $_SESSION['tasks'] = $tasks;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple To-Do List</title>
</head>
<body>
    <h1>Simple To-Do List</h1>
    
    <!-- Add Task Form -->
    <form method="POST">
        <label for="task">Add a new task:</label>
        <input type="text" id="task" name="task" required>
        <button type="submit">Add Task</button>
    </form>
    
    <!-- List of Tasks -->
    <ul>
        <?php foreach ($tasks as $index => $taskItem): ?>
            <li>
                <input type="checkbox" <?php if ($taskItem['completed']) echo 'checked'; ?> disabled>
                <?php echo $taskItem['task']; ?>
                <a href="?complete=<?php echo $index; ?>">Complete</a>
                <a href="?delete=<?php echo $index; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
