<?php
// Include the database connection file
include 'dbconn.php';
$database = new Database();
$conn = $database->getConnection();

// Ensure $conn is defined and not null
if (!$conn) {
    // Handle database connection error
    $response = array('error' => 'Failed to connect to database');
    echo json_encode($response);
    exit;
}

// Query to fetch all parking zones
$sql = "SELECT Zone_ID, Zone_Name, Weekday_Rate, Weekend_Rate, Discount FROM parking_zone";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
    // Handle query execution error
    $response = array('error' => 'Failed to fetch parking zones');
    echo json_encode($response);
    exit;
}

// Fetch and format results
$zones = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Format each zone
    $zone = array(
        'id' => $row['Zone_ID'],
        'name' => $row['Zone_Name'],
        'weekday_rate' => $row['Weekday_Rate'],
        'weekend_rate' => $row['Weekend_Rate'],
        'discount' => $row['Discount']
    );
    // Add formatted zone to zones array
    $zones[] = $zone;
}

// Return JSON response
echo json_encode($zones);

// Close database connection
mysqli_close($conn);