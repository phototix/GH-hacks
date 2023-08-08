<?php  
function isPalindrome(string $inputString): bool {
    // Remove spaces and convert to lowercase
    $cleanedString = strtolower(str_replace(' ', '', $inputString));
    
    // Reverse the cleaned string
    $reversedString = strrev($cleanedString);
    
    // Compare the cleaned string with its reverse
    return $cleanedString === $reversedString;
}

// Test the function
echo isPalindrome("racecar");  // Output: true
echo isPalindrome("hello");    // Output: false
echo isPalindrome("A man a plan a canal Panama");  // Output: true
?>