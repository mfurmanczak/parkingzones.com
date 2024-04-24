<?php
// Include the database connection file
include 'dbconn.php';

// Check if form data is submitted via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize an array to store validation errors
    $errors = array();

    // Sanitize and validate zone name
    $zoneName = filter_input(INPUT_POST, 'zoneName', FILTER_SANITIZE_STRING);
    if (empty($zoneName)) {
        $errors[] = "Zone name is required.";
    }

    // Validate weekday rate
    $weekdayRate = filter_input(INPUT_POST, 'weekdayRate', FILTER_VALIDATE_INT);
    if ($weekdayRate === false || $weekdayRate <= 0) {
        $errors[] = "Please enter a valid weekday rate.";
    }

    // Validate weekend rate
    $weekendRate = filter_input(INPUT_POST, 'weekendRate', FILTER_VALIDATE_INT);
    if ($weekendRate === false || $weekendRate <= 0) {
        $errors[] = "Please enter a valid weekend rate.";
    }

    // Validate discount
    $discount = filter_input(INPUT_POST, 'discount', FILTER_VALIDATE_FLOAT);
    if ($discount === false || $discount < 0 || $discount > 100) {
        $errors[] = "Please enter a valid discount percentage (between 0 and 100).";
    }

    // If there are no validation errors, proceed with database operations
    if (empty($errors)) {
        // Establish database connection
        $db = new Database();
        $conn = $db->getConnection();

        // Prepare SQL statement to insert data into the zones table
        $sql = "INSERT INTO parking_zone (Zone_Name, Weekday_Rate, Weekend_Rate, Discount) 
                VALUES (?, ?, ?, ?)";

        try {
            // Prepare and bind parameters
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siii", $zoneName, $weekdayRate, $weekendRate, $discount);

            // Execute the SQL statement
            if ($stmt->execute()) {
                echo "New zone added successfully";
            } else {
                echo "Error adding zone";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
    } else {
        // Output validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
} else {
    // If form data is not provided, return error message
    echo "Error: Form data not provided";
}
?>
