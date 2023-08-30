<?php
function generateFibonacci($numTerms) {
    $fibonacci = [0, 1];
    
    for ($i = 2; $i < $numTerms; $i++) {
        $nextNumber = $fibonacci[$i - 1] + $fibonacci[$i - 2];
        array_push($fibonacci, $nextNumber);
    }
    
    return $fibonacci;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numTerms = isset($_POST["numTerms"]) ? intval($_POST["numTerms"]) : 0;
    $fibonacciSequence = generateFibonacci($numTerms);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fibonacci Sequence Generator</title>
</head>
<body>
    <h1>Fibonacci Sequence Generator</h1>
    <form method="post">
        <label for="numTerms">Enter the number of terms:</label><br>
        <input type="number" name="numTerms" value="<?php echo $numTerms ?? ''; ?>" required><br>
        <input type="submit" value="Generate Sequence">
    </form>
    
    <?php if (isset($fibonacciSequence)) : ?>
        <h2>Fibonacci Sequence:</h2>
        <p><?php echo implode(', ', $fibonacciSequence); ?></p>
    <?php endif; ?>
</body>
</html>
