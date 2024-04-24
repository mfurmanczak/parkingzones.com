<?php
// Include the database connection file
include 'dbconn.php';
$db = new Database();
$conn = $db->getConnection();
// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $zoneName = $_POST['zoneName'];
    $weekdayRate = $_POST['weekdayRate'];
    $weekendRate = $_POST['weekendRate'];
    $discount = $_POST['discount'];

    // Prepare SQL statement to insert data into the zones table
    $sql = "INSERT INTO parking_zone (Zone_Name, Weekday_Rate, Weekend_Rate, Discount) 
            VALUES (?, ?, ?, ?)";

    try {
        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddd", $zoneName, $weekdayRate, $weekendRate, $discount);

        // Execute the SQL statement
        if ($stmt->execute()) {
            echo "New zone added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>
