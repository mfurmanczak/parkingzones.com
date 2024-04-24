$(document).ready(function () {
    // Make AJAX request to getAllZones.php
    $.ajax({
        url: 'server/GetAllZones.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Iterate over the received data and append rows to the table
            response.forEach(function (zone) {
                var row = `<tr>
                                <td>${zone.id}</td>
                                <td>${zone.name}</td>
                                <td>${zone.weekday_rate}</td>
                                <td>${zone.weekend_rate}</td>
                                <td>${zone.discount}</td>
                                <td><button class="btn btn-primary edit-btn" data-zone-id="${zone.id}">Edit</button></td>
                            </tr>`;
                $('#zoneTable').append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching parking zones:', error);
        }
    });
});
