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
