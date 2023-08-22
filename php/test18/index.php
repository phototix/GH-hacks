<?php
function calculateGrade($marks) {
    if ($marks >= 90) {
        return "A";
    } elseif ($marks >= 80) {
        return "B";
    } elseif ($marks >= 70) {
        return "C";
    } elseif ($marks >= 60) {
        return "D";
    } else {
        return "F";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $marks = isset($_POST["marks"]) ? floatval($_POST["marks"]) : 0;
    $grade = calculateGrade($marks);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grade Calculator</title>
</head>
<body>
    <h1>Grade Calculator</h1>
    <form method="post">
        <label for="marks">Enter the marks: </label>
        <input type="number" step="any" name="marks" required>
        <input type="submit" value="Calculate Grade">
    </form>
    
    <?php if (isset($grade)) : ?>
        <p>Grade: <?php echo $grade; ?></p>
    <?php endif; ?>
</body>
</html>
