// formValidator.js

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
