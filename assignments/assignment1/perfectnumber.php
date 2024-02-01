<?php
//perfect number function
function isPerfectNumber($number) {
    if ($number <= 0) {
        return "Invalid input. Please enter a positive integer.";
    }

    $divisors = array();
    $sum = 0;

    for ($i = 1; $i <= $number / 2; $i++) {
        if ($number % $i == 0) {
            $divisors[] = $i;
            $sum += $i;
        }
    }

    if ($sum == $number) {
        return "Yes, this is a perfect number. Proof: " . implode('+', $divisors) . " = $number";
    } else {
        return "No, this is not a perfect number. Proof: " . implode(' != ', $divisors) . " != $number";
    }
}

//tester function
function testPerfectNumberFunction() {
    $testCases = array(
        6 => "Yes, this is a perfect number. Proof: 1+2+3 = 6",
        28 => "Yes, this is a perfect number. Proof: 1+2+4+7+14 = 28",
        12 => "No, this is not a perfect number. Proof: 1+2+3+4+6 != 12",
        1 => "No, this is not a perfect number. Proof: 1 != 1",
        0 => "Invalid input. Please enter a positive integer."
    );

    $results = array();

    foreach ($testCases as $input => $expectedOutput) {
        $actualOutput = isPerfectNumber($input);

        $results[] = array(
            'input' => $input,
            'expected' => $expectedOutput,
            'actual' => $actualOutput,
            'result' => ($actualOutput === $expectedOutput) ? 'Passed' : 'Failed'
        );
    }

    return $results;
}

//server input post method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    if (isset($_POST["testButton"])) {
        // Run the tester function if the test button is pressed
        $testResults = testPerfectNumberFunction();
    } else {
        // Process user input only if the number is provided
        $inputNumber = isset($_POST["number"]) ? $_POST["number"] : null;

        if ($inputNumber !== null) {
            $result = isPerfectNumber($inputNumber);
        }
    }
} else {
    // Set default result
    $result = "";
}

?>

<!--html for the text input on adding text in the text box and clicking on check
//on click of run tester button, the test result will be given in a tabular fashion
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfect Number Checker</title>
</head>
<body>

<h1>Perfect Number Checker</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="number">Enter a number (optional):</label>
    <input type="text" id="number" name="number">
    <button type="submit">Check</button>

    <!-- Add a test button -->
    <button type="submit" name="testButton">Run Tester</button>
</form>

<?php
// Display result if available
if (!empty($result)) {
    echo "<p>$result</p>";
}

// Display test results in a table
if (isset($testResults) && !empty($testResults)) {
    echo "<h2>Test Results</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Input</th><th>Expected Output</th><th>Actual Output</th><th>Result</th></tr>";

    foreach ($testResults as $test) {
        echo "<tr>";
        echo "<td>{$test['input']}</td>";
        echo "<td>{$test['expected']}</td>";
        echo "<td>{$test['actual']}</td>";
        echo "<td>{$test['result']}</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>

</body>
</html>
