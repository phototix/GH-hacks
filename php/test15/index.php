<?php  
function isPrime(int $number): bool {
    if ($number <= 1) {
        return false;
    }

    if ($number <= 3) {
        return true;
    }

    if ($number % 2 === 0 || $number % 3 === 0) {
        return false;
    }

    $i = 5;
    while ($i * $i <= $number) {
        if ($number % $i === 0 || $number % ($i + 2) === 0) {
            return false;
        }
        $i += 6;
    }

    return true;
}

// Test the function
echo isPrime(5);   // Output: true
echo isPrime(10);  // Output: false
echo isPrime(17);  // Output: true

?>