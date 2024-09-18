document.addEventListener('DOMContentLoaded', function() {
    // Reusable status toggle function
    function setupStatusToggles(toggleSelector, updateUrl) {
        let selectedCategoryId = null;
        let selectedStatus = null;

        // Handle status toggle click event
        document.querySelectorAll(toggleSelector).forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                // Store the item ID and status
                selectedCategoryId = this.getAttribute('data-id');
                selectedStatus = this.checked;

                // Trigger SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to update the status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms, call the updateStatus function
                        updateStatus(selectedCategoryId, selectedStatus, updateUrl);
                    } else {
                        // If canceled, reset the checkbox to its previous state
                        document.querySelector(`input[data-id="${selectedCategoryId}"]`).checked = !selectedStatus;
                    }
                });
            });
        });
    }

    // Update status using AJAX and show SweetAlert on success
    function updateStatus(id, status, url) {
        fetch(`${url}/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Manually update the toggle status
                document.querySelector(`input[data-id="${id}"]`).checked = status;

                // Show SweetAlert success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Status updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was a problem updating the status.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);

            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while updating the status.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    // Export the setup function to make it reusable
    window.setupStatusToggles = setupStatusToggles;
});
