<?php  
$arraysData = Array(
    [a] => 5
    [b] => 2
    [c] => 4
    [d] => 1
)

function countRepeatedCharacters(string $inputString): array {
    $result = [];
    $length = strlen($inputString);

    for ($i = 0; $i < $length; $i++) {
        $char = $inputString[$i];
        $count = 1;

        while ($i + 1 < $length && $inputString[$i] === $inputString[$i + 1]) {
            $count++;
            $i++;
        }

        $result[$char] = $count;
    }

    return $result;
}

// Test the function
$input = "aaabbccccdaa";
$result = countRepeatedCharacters($input);
print_r($result);

?>