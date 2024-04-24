<?php
// Include the database connection file
include 'dbconn.php';
$db = new Database();
$conn = $db->getConnection();

// Check if zone ID is provided via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['zoneId'])) {
    // Retrieve zone ID from POST data
    $zoneId = $_POST['zoneId'];

    // Prepare SQL statement to delete the zone from the database
    $sql = "DELETE FROM parking_zone WHERE Zone_ID = ?";

    try {
        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $zoneId);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Return success message
            echo "Zone deleted successfully";
        } else {
            // Return error message
            echo "Error deleting zone";
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
    // If zone ID is not provided, return error message
    echo "Error: Zone ID not provided";
}
?>
