<!DOCTYPE html>
<html lang="en">
//Generates Table
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
//Gets User Inputs
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $rows = isset($_POST["rows"]) ? intval($_POST["rows"]) : 0;
    $columns = isset($_POST["columns"]) ? intval($_POST["columns"]) : 0;
    $min = isset($_POST["min"]) ? intval($_POST["min"]) : 0;
    $max = isset($_POST["max"]) ? intval($_POST["max"]) : 0;
}

if ($rows <= 0 || $columns <= 0 || $min > $max){
	echo "Inputs are invalid please try again.";
	exit;
}
	//Generates array with random values using min and max as the parameters for random
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

	echo "<h2> Original 2D Array</h2>";
	echo "<p2> Your array size is: $rows x $columns</p2><br>";
	echo "<p2> Your min. Value is: $min</p2><br>";
	echo "<p2> Your max Value is: $max</p2><br>";
	echo "<table>";
	foreach ($array as $row) {
		echo "<tr>";
		foreach ($row as $value) {
			echo "<td>$value</td>";
		}
		echo "</tr>";
	}

	echo "</table>";
	    // Process Data for Table 2
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
                <td>" . number_format($rowAverages[$i], 2) . "</td>
                <td>" . number_format($rowStdDevs[$i], 2) . "</td>
              </tr>";
    }
    echo "</table>";

    // Display Table 3: Values and their Positivity/Nature
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


?>
