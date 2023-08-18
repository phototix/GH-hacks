<?php

function voltageDivider(float $Vin, float $R1, float $R2) {
  $Vd = $Vin * ($R2 / ($R1 + $R2));
  return $Vd;
}

// Get the input values
$Vin = floatval(readline("Enter the input voltage (V): "));
$R1 = floatval(readline("Enter the value of resistor R1 (ohms): "));
$R2 = floatval(readline("Enter the value of resistor R2 (ohms): "));

// Calculate the output voltage
$Vd = voltageDivider($Vin, $R1, $R2);

// Display the output voltage
echo "The output voltage is: $Vd volts\n";

?>
