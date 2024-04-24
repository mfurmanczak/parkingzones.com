<?php
// Include the database connection file
include 'dbconn.php';
$db = new Database();
$conn = $db->getConnection();

// Check if form data is submitted via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $zoneId = $_POST['zoneId'];
    $zoneName = $_POST['zoneName'];
    $weekdayRate = $_POST['weekdayRate'];
    $weekendRate = $_POST['weekendRate'];
    $discount = $_POST['discount'];

    // Prepare SQL statement to update the zone in the database
    $sql = "UPDATE parking_zone 
            SET Zone_Name = ?, Weekday_Rate = ?, Weekend_Rate = ?, Discount = ? 
            WHERE Zone_ID = ?";

    try {
        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $zoneName, $weekdayRate, $weekendRate, $discount, $zoneId);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Return success message
            echo "Zone updated successfully";
        } else {
            // Return error message
            echo "Error updating zone";
        }
    } catch (Exception $e) {
        // Return error message
        echo "Error: " . $e->getMessage();
    } finally {
        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    // If form data is not provided, return error message
    echo "Error: Form data not provided";
}
?>