<?php
// Function to format date and time based on the specified timezone
function formatDateByTimezone($timezone) {
    $dateTime = new DateTime('now', new DateTimeZone($timezone));
    return $dateTime->format('Y M d h:i A');
}

// List of supported timezones
$timezones = timezone_identifiers_list();

// Default timezone
$selectedTimezone = 'America/New_York';

// Handle form submission
if (isset($_POST['timezone'])) {
    $selectedTimezone = $_POST['timezone'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timezone Converter</title>
</head>
<body>
    <h1>Timezone Converter</h1>
    
    <!-- Timezone Dropdown -->
    <form method="POST">
        <label for="timezone">Select Timezone:</label>
        <select id="timezone" name="timezone">
            <?php foreach ($timezones as $tz): ?>
                <option value="<?php echo $tz; ?>" <?php if ($tz === $selectedTimezone) echo 'selected'; ?>><?php echo $tz; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Change Timezone</button>
    </form>
    
    <!-- Display Date and Time -->
    <h2>Current Date and Time:</h2>
    <p><?php echo formatDateByTimezone($selectedTimezone); ?></p>
</body>
</html>
