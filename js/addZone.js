$(document).ready(function () {
    // Function to validate the form
    function validateForm() {
        // Retrieve form data
        var zoneName = $('#zoneName').val().trim();
        var weekdayRate = parseFloat($('#weekdayRate').val());
        var weekendRate = parseFloat($('#weekendRate').val());
        var discount = parseFloat($('#discount').val());

        // Perform validation checks
        if (zoneName === '') {
            alert('Please enter zone name.');
            return false; // Validation failed
        }

        if (isNaN(weekdayRate) || weekdayRate <= 0) {
            alert('Please enter a valid weekday rate.');
            return false; // Validation failed
        }

        if (isNaN(weekendRate) || weekendRate <= 0) {
            alert('Please enter a valid weekend rate.');
            return false; // Validation failed
        }

        if (isNaN(discount) || discount < 0 || discount > 100) {
            alert('Please enter a valid discount percentage (between 0 and 100).');
            return false; // Validation failed
        }

        return true; // Validation passed
    }

    $('#addZoneForm').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // make the call to the server if the form is valid
        if (!validateForm()) {
            return;
        } else {
            // Retrieve form data
            var formData = $(this).serialize();

            // AJAX call to AddZone.php     
            $.ajax({
                url: 'server/AddZone.php',
                type: 'POST',
                data: formData,
                success: function () {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert('Error adding zone:', error);
                }
            });
        }
    });
});
