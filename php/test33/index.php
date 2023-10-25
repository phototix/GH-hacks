<?php

// Function to generate max and min settings for microphone array adjustment
function generateMicArraySettings($maxDb, $minDb) {
    // Define a safety margin for adjustment
    $safetyMargin = 3; // Adjust this as needed

    // Calculate the max and min settings
    $maxSetting = $maxDb + $safetyMargin;
    $minSetting = $minDb - $safetyMargin;

    // Ensure the minimum setting is not less than a reasonable value
    $minSetting = max($minSetting, 20); // Adjust the minimum as needed

    // Return the settings
    return [
        'max' => $maxSetting,
        'min' => $minSetting
    ];
}

// Example input values
$maxDb = 90; // Replace with the captured maximum dB value
$minDb = 40; // Replace with the captured minimum dB value

// Generate microphone array settings
$settings = generateMicArraySettings($maxDb, $minDb);

// Output the settings
echo "Maximum Setting: {$settings['max']} dB<br>";
echo "Minimum Setting: {$settings['min']} dB";
