<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Processing</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $rows = isset($_POST["rows"]) ? intval($_POST["rows"]) : 0;
    $columns = isset($_POST["columns"]) ? intval($_POST["columns"]) : 0;
    $min = isset($_POST["min"]) ? intval($_POST["min"]) : 0;
    $max = isset($_POST["max"]) ? intval($_POST["max"]) : 0;
}

if ($rows <= 0 || $columns <= 0 || $min > $max){
    echo "Inputs are invalid. Please <a href='arrayDemo.html'>try again</a>.";
    exit;
}

// Generates array with random values
$array = [];
for ($i = 0; $i < $rows; $i++) {
    for ($j = 0; $j < $columns; $j++) {
        $array[$i][$j] = rand($min, $max);
    }
}

// Function to calculate standard deviation
function standardDeviation($arr) {
    $mean = array_sum($arr) / count($arr);
    $variance = array_reduce($arr, function ($carry, $val) use ($mean) {
        return $carry + pow($val - $mean, 2);
    }, 0) / count($arr);
    return sqrt($variance);
}

// Display Original 2D Array
echo "<h2>Original 2D Array</h2>";
echo "<p>Your array size is: $rows x $columns</p>";
echo "<p>Your min. value is: $min</p>";
echo "<p>Your max value is: $max</p>";
echo "<table>";
foreach ($array as $row) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>$value</td>";
    }
    echo "</tr>";
}
echo "</table>";

// Process Data for Sum, Average, Standard Deviation
$rowSums = [];
$rowAverages = [];
$rowStdDevs = [];
foreach ($array as $row) {
    $sum = array_sum($row);
    $average = $sum / count($row);
    $stdDev = standardDeviation($row);
    
    $rowSums[] = $sum;
    $rowAverages[] = $average;
    $rowStdDevs[] = $stdDev;
}

// Display Table 2: Sum, Average, Standard Deviation
echo "<h2>Row Statistics</h2>";
echo "<table>
        <tr>
            <th>Row</th>
            <th>Sum</th>
            <th>Average</th>
            <th>Standard Deviation</th>
        </tr>";
for ($i = 0; $i < $rows; $i++) {
    echo "<tr>
            <td>Row " . ($i + 1) . "</td>
            <td>{$rowSums[$i]}</td>
            <td>" . number_format($rowAverages[$i], 3) . "</td>
            <td>" . number_format($rowStdDevs[$i], 3) . "</td>
          </tr>";
}
echo "</table>";

// Display Table 3: Values and Labels
echo "<h2>Values and Positivity</h2>";
echo "<table>";
foreach ($array as $row) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>$value</td>";
    }
    echo "</tr><tr>";
    foreach ($row as $value) {
        if ($value > 0) {
            echo "<td>Positive</td>";
        } elseif ($value < 0) {
            echo "<td>Negative</td>";
        } else {
            echo "<td>Zero</td>";
        }
    }
    echo "</tr>";
}
echo "</table>";

// Link back to input page
echo '<br><a href="arrayDemo.html">Go Back</a>';
?>

</body>
</html>
