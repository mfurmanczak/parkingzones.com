<?php
class ParkingCalculator
{
    private $conn; // Database connection

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function calculateFee()
    {
        // Retrieve values from $_POST
        $start_time = $_POST['startTime'];
        $end_time = $_POST['endTime'];
        $day_of_week = $_POST['dayOfWeek'];
        $currency = $_POST['currency'];

        // Determine the appropriate rate based on the day of the week
        $rate_column = ($day_of_week >= 1 && $day_of_week <= 5) ? 'Weekday_Rate' : 'Weekend_Rate';

        // Fetch the rate from the database
        $query = "SELECT $rate_column, Discount FROM parking_zone WHERE Zone_ID = ?";
        $stmt = $this->conn->prepare($query);
        $zone_id = $_POST['parkingArea'];
        $stmt->bind_param('i', $zone_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $rate = $row[$rate_column];

        // Fetch the exchange rate based on the selected currency
        $exchange_rate = $this->fetchExchangeRate($currency);

        if ($exchange_rate === false) {
            return 'Error fetching exchange rate for ' . $currency;
        }

        // Convert rate to selected currency
        $rate_in_selected_currency = $rate * $exchange_rate;

        // Calculate the total number of hours parked
        $start_datetime = new DateTime($start_time);
        $end_datetime = new DateTime($end_time);
        $parking_hours = $end_datetime->diff($start_datetime)->h;

        // Calculate the total fee before discount
        $total_fee = $parking_hours * $rate_in_selected_currency;

        // Apply discount if applicable (you can keep the existing discount calculation)
        $discount = $row['Discount'];
        $amount_due = $total_fee - ($total_fee * $discount / 100);

        // Round the total fee to two decimal places
        $rounded_amount_due = number_format($amount_due, 2);

        // Return the rounded total fee
        return $rounded_amount_due;
    }

    private function fetchExchangeRate($currency)
    {
        // API endpoint
        $api_url = 'https://open.er-api.com/v6/latest/USD';

        // Fetch data from the API
        $response = file_get_contents($api_url);

        // Check if request was successful
        if ($response === false) {
            return false; // Error fetching data
        }

        // Decode JSON response
        $data = json_decode($response, true);

        // Check if JSON decoding was successful
        if ($data === null) {
            return false; // Error decoding JSON
        }

        // Check if rates are available in the response
        if (!isset($data['rates'])) {
            return false; // Rates not found in response
        }

        // Check if the requested currency exists in the rates
        if (!isset($data['rates'][$currency])) {
            return false; // Requested currency not found
        }

        // Extract and return the exchange rate for the requested currency
        return $data['rates'][$currency];
    }
}

include 'dbconn.php';
$database = new Database();
$conn = $database->getConnection();

$calculator = new ParkingCalculator($conn);

// Calculate the fee and echo the result
echo $calculator->calculateFee() . ' ' . $_POST['currency'];