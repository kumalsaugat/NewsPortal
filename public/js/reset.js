// Function to reset table filters
// Reset Button functionality
$("button.btn-danger").click(function () {
    // Clear any filters or search inputs (adjust based on your filter fields)
    $("#bulkAction").val(""); // Reset select dropdown
    $('input[type="text"], input[type="search"]').val(""); // Reset input fields

    // Reload the DataTable without filters
    let table = $("#dataTableBuilder").DataTable();
    table.search("").columns().search("").draw();
});
