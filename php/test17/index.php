<?php

// Get the input values
$ds = $_POST['ds'];
$nhr = $_POST['nhr'];
$nvr = $_POST['nvr'];
$cvr = $_POST['cvr'];

// Calculate the viewing distance
$vd = 2.54 * 100 / (tan(1/60) * ($nhr * $nvr + 1) * $cvr);

// Display the viewing distance
echo "The viewing distance is " . $vd . " meters.";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Voltage Divider Calculator</title>
</head>
<body>
    <form action="viewing_distance.php" method="post">
      <input type="text" name="ds" placeholder="Display diagonal size (in inches)">
      <input type="text" name="nhr" placeholder="Display native horizontal resolution (in pixels)">
      <input type="text" name="nvr" placeholder="Display native vertical resolution (in pixels)">
      <input type="text" name="cvr" placeholder="Vertical resolution of the video being displayed (in pixels)">
      <input type="submit" value="Calculate">
    </form>
</body>
</html>
