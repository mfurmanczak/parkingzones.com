$(document).ready(function () {
    // Add event listener for form submission
    $('#feeForm').submit(function (event) {
        event.preventDefault(); // Prevent the form from submitting

        // Perform validation here
        if (!validateForm()) {
            return; // Do not proceed if validation fails
        }

        // If validation passes, make an AJAX call to the server
        $.ajax({
            url: 'server/ParkingCalculator.php',
            type: 'POST',
            data: $(this).serialize(), // Serialize form data
            success: function (response) {
                // Display the amount in an alert box
                alert('The parking fee is ' + response);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    // Function to validate the form
    function validateForm() {
        // Retrieve values from the form
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();

        // Perform validation checks
        if (!startTime || !endTime) {
            alert('Please enter both start time and end time.');
            return false; // Validation failed
        }

        if (startTime >= endTime) {
            alert('Start time must be before end time.');
            return false; // Validation failed
        }
        var parkingArea = $('#parkingArea').val();
        if (!parkingArea) {
            alert('Please select a parking area.');
            return false; // Validation failed
        }

        var dayOfWeek = $('#dayOfWeek').val();
        if (!dayOfWeek) {
            alert('Please select a day of the week.');
            return false; // Validation failed
        }


        return true; // Validation passed
    }
});
