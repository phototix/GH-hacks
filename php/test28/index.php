<?php
session_start();

// Initialize an array to store workout records
$workoutRecords = [];

// Check if workout records are stored in the session
if (isset($_SESSION['workoutRecords'])) {
    $workoutRecords = $_SESSION['workoutRecords'];
}

// Add a new workout record
if (isset($_POST['time']) && isset($_POST['sets']) && isset($_POST['workout']) && isset($_POST['remark'])) {
    $newRecord = [
        'time' => $_POST['time'],
        'sets' => $_POST['sets'],
        'workout' => $_POST['workout'],
        'remark' => $_POST['remark'],
    ];

    array_push($workoutRecords, $newRecord);

    // Save updated workout records to the session
    $_SESSION['workoutRecords'] = $workoutRecords;
}

// Delete a workout record
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $recordIndex = $_GET['delete'];
    if (isset($workoutRecords[$recordIndex])) {
        array_splice($workoutRecords, $recordIndex, 1);
        // Save updated workout records to the session
        $_SESSION['workoutRecords'] = $workoutRecords;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Workout Records</title>
</head>
<body>
    <h1>Daily Workout Records</h1>
    
    <!-- Add Workout Record Form -->
    <form method="POST">
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required><br>
        <label for="sets">Sets:</label>
        <input type="number" id="sets" name="sets" min="1" required><br>
        <label for="workout">Workout Name:</label>
        <input type="text" id="workout" name="workout" required><br>
        <label for="remark">Remark:</label>
        <input type="text" id="remark" name="remark"><br>
        <button type="submit">Add Record</button>
    </form>
    
    <!-- List of Workout Records -->
    <h2>Workout Records:</h2>
    <ul>
        <?php foreach ($workoutRecords as $index => $record): ?>
            <li>
                <strong>Time:</strong> <?php echo $record['time']; ?><br>
                <strong>Sets:</strong> <?php echo $record['sets']; ?><br>
                <strong>Workout Name:</strong> <?php echo $record['workout']; ?><br>
                <strong>Remark:</strong> <?php echo $record['remark']; ?><br>
                <a href="?delete=<?php echo $index; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
