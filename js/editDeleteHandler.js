$(document).ready(function () {
    // Event listener for edit button click
    $('#zoneTable').on('click', '.edit-btn', function () {
        // Find the row containing the clicked button
        var row = $(this).closest('tr');

        // Replace the text content with input fields containing the current values
        row.find('td:not(:first-child)').each(function () {
            var value = $(this).text();
            $(this).html(`<input type="text" class="form-control" value="${value}">`);
        });

        // Append the save and delete buttons next to the last child
        var zoneId = row.find('td:nth-child(1)').text();
        var actionField = row.find('td:last-child');
        actionField.html(`<button type="submit" class="btn btn-primary save-btn">Save</button>`);
        actionField.append(`<button type="button" id="delete-${zoneId}" class="btn btn-danger delete-btn">Delete</button>`);
    });

    // Event listener for confirm button click
    $('#zoneTable').on('click', '.save-btn', function () {
        // Find the row containing the clicked button
        var row = $(this).closest('tr');

        // Get the updated values from input fields
        var zoneId = row.find('td:nth-child(1)').text();
        var zoneName = row.find('td:nth-child(2) input').val();
        var weekdayRate = row.find('td:nth-child(3) input').val();
        var weekendRate = row.find('td:nth-child(4) input').val();
        var discount = row.find('td:nth-child(5) input').val();

        // Perform AJAX request to update the zone in the database
        $.ajax({
            url: 'server/UpdateZone.php',
            type: 'POST',
            data: {
                zoneId: zoneId,
                zoneName: zoneName,
                weekdayRate: weekdayRate,
                weekendRate: weekendRate,
                discount: discount
            },
            success: function (response) {
                // Handle success response
                console.log('Zone updated successfully:', response);

                // Replace input fields with updated values
                row.find('td:not(:first-child)').each(function () {
                    var value = $(this).find('input').val();
                    $(this).text(value);
                });

                // Add back the edit button
                var actionField = row.find('td:last-child');
                actionField.html('<button type="button" class="btn btn-primary edit-btn">Edit</button>');

                // Remove the save button and delete button
                row.find('.save-btn').remove();
                row.find('.delete-btn').remove();
            },
            error: function (xhr, status, error) {
                console.error('Error updating zone:', error);
            }
        });
    });

    // Event listener for delete button click
    $('#zoneTable').on('click', '.delete-btn', function () {
        // Extract the zone ID from the delete button's ID
        var zoneId = $(this).attr('id').split('-')[1];

        // Perform AJAX request to delete the zone from the database
        $.ajax({
            url: 'server/DeleteZone.php',
            type: 'POST',
            data: { zoneId: zoneId },
            success: function () {
                location.reload();
            },
            error: function (xhr, status, error) {
                alert('Error deleting zone:', error);
            }
        });
    });
});
