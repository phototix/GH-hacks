<?php  
function arraySum(array $numbers): int {
    $sum = 0;
    
    foreach ($numbers as $number) {
        $sum += $number;
    }
    
    return $sum;
}

// Test the function
$numbers1 = [1, 2, 3, 4, 5];
echo arraySum($numbers1);  // Output: 15

$numbers2 = [-10, 0, 10, -5];
echo arraySum($numbers2);  // Output: -5

?>