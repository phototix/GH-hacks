<?php

function voltageDivider(float $Vin, float $R1, float $R2) {
    $Vd = $Vin * ($R2 / ($R1 + $R2));
    return $Vd;
}

// Validate and retrieve input values from $_POST
$Vin = isset($_POST['vin']) ? floatval($_POST['vin']) : null;
$R1 = isset($_POST['r1']) ? floatval($_POST['r1']) : null;
$R2 = isset($_POST['r2']) ? floatval($_POST['r2']) : null;

if ($Vin !== null && $R1 !== null && $R2 !== null) {
    // Calculate the output voltage
    $Vd = voltageDivider($Vin, $R1, $R2);
    
    // Display the output voltage
    echo "The output voltage is: $Vd volts\n";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Voltage Divider Calculator</title>
</head>
<body>
    <form method="post">
        <label for="vin">Enter the input voltage (V): </label>
        <input type="number" step="any" name="vin" required><br>
        
        <label for="r1">Enter the value of resistor R1 (ohms): </label>
        <input type="number" step="any" name="r1" required><br>
        
        <label for="r2">Enter the value of resistor R2 (ohms): </label>
        <input type="number" step="any" name="r2" required><br>
        
        <input type="submit" value="Calculate">
    </form>
</body>
</html>
