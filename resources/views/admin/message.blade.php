@if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            window.location.reload();
        });
    </script>
@endif

@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error', // Use 'error' icon
            confirmButtonText: 'OK',
            showCancelButton: false, // Optional: hide cancel button
            backdrop: true // Optional: enable backdrop
        }).then((result) => {
            // Refresh the page to clear the session message
            window.location.reload(); // Refresh the page to clear the session message
        });
    </script>
@endif
