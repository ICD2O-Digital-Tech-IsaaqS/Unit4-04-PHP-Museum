<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="description" content="Movie Age Checker, with PHP">
  <meta name="keywords" content="Immaculata, ICD2O">
  <meta name="author" content="Isaaq Simon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="./favicon_io (18)/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./favicon_io (18)/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./favicon_io (18)/favicon-16x16.png">
  <link rel="manifest" href="./favicon_io (18)/site.webmanifest">
  <title>Museum</title>
  <!-- Link to external CSS file -->
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container">
        <h2>Check Discount Eligibility</h2>

        <!-- Age and day input form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <!-- Age input -->
            <label for="age">Enter your age:</label>
            <input type="text" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" placeholder="e.g., 25">

            <!-- Day selection -->
            <label for="day">Select day:</label>
            <select id="day" name="day">
                <option value="">--Choose a day--</option>
                <?php
                $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                foreach ($days as $d) {
                    $selected = ($d === $day) ? "selected" : "";
                    echo "<option value=\"$d\" $selected>$d</option>";
                }
                ?>
            </select>

            <!-- Submit button -->
            <button type="submit">Check</button>
        </form>

        <?php
// Initialize variables
$age = $day = $message = "";
$discountDays = ["Tuesday", "Thursday"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age = trim($_POST["age"]);
    $day = $_POST["day"];

    // Validate age
    if ($age === "") {
        $message = "Please enter your age.";
    } elseif (!is_numeric($age) || intval($age) != $age) {
        $message = "Please enter a valid whole number for age.";
    } elseif ($age < 0) {
        $message = "Please enter a valid non-negative age.";
    } elseif ($day === "") {
        $message = "Please select a day.";
    } else {
        $age = intval($age);

        // Apply rules based on age and day
        if ($age < 5) {
            $message = "Eligible: Age less than 5.";
        } elseif ($age > 95) {
            $message = "Eligible: Age over 95.";
        } elseif ($age >= 12 && $age <= 21) {
            $message = "Eligible: Student age group (12–21).";
        } elseif (($age < 12 || $age > 21) && !in_array($day, $discountDays)) {
            $message = "Not eligible: Not a student and it's not a discount day.";
        } elseif (($age < 12 || $age > 21) && in_array($day, $discountDays)) {
            $message = "Eligible: It's a discount day.";
        } else {
            $message = "Standard pricing applies.";
        }
    }
}
?>

        <!-- Display result -->
        <div id="result">
            <?php if (!empty($message)) echo htmlspecialchars($message); ?>
        </div>
    </div>
</body>
</html>