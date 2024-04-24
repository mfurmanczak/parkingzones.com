$(document).ready(function () {
    // Make AJAX request to getAllZones.php
    $.ajax({
        url: 'server/GetAllZones.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Iterate over the received data and append options to select element
            response.forEach(function (zone) {
                $('#parkingArea').append(`<option value="${zone.id}">${zone.name}</option>`);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching parking zones:', error);
        }
    });
});