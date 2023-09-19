<?php
session_start();

// Initialize an empty array to store wallet transactions
$transactions = [];

// Load transactions from the text file
$filePath = 'transactions.txt';
if (file_exists($filePath)) {
    $transactions = json_decode(file_get_contents($filePath), true);
}

// Add a new transaction
if (isset($_POST['description']) && isset($_POST['amount'])) {
    $newTransaction = [
        'date' => date('Y-m-d H:i:s'),
        'description' => $_POST['description'],
        'amount' => floatval($_POST['amount']),
    ];

    array_push($transactions, $newTransaction);

    // Save updated transactions to the text file
    file_put_contents($filePath, json_encode($transactions));

    // Redirect to avoid form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Delete a transaction
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $transactionIndex = $_GET['delete'];
    if (isset($transactions[$transactionIndex])) {
        array_splice($transactions, $transactionIndex, 1);
        // Save updated transactions to the text file
        file_put_contents($filePath, json_encode($transactions));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wallet Transactions</title>
</head>
<body>
    <h1>Wallet Transactions</h1>
    
    <!-- Add Transaction Form -->
    <form method="POST">
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required><br>
        <button type="submit">Add Transaction</button>
    </form>
    
    <!-- List of Transactions -->
    <h2>Transactions:</h2>
    <ul>
        <?php foreach ($transactions as $index => $transaction): ?>
            <li>
                <?php echo $transaction['date']; ?> -
                <?php echo $transaction['description']; ?> -
                <?php echo '$' . number_format($transaction['amount'], 2); ?>
                <a href="?delete=<?php echo $index; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
