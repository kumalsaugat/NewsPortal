@extends('layouts.app')

@section('content')



    <div class="app-content"> <!--begin::Container-->


        <div class="container-fluid"> <!--begin::Row-->

            @include('admin.message')

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">

                        <div class="card-header ">
                            <a href="{{ route('news.create') }}">
                                <button type="submit" class="btn btn-success float-sm-right ">@lang('app.createNew')</button></a>
                        </div> <!-- /.card-header -->


                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 280px">@lang('app.action')</th>
                                        <th>@lang('app.news.title')</th>
                                        <th>@lang('app.news.image')</th>
                                        <th>@lang('app.news.category')</th>
                                        <th>@lang('app.news.user')</th>
                                        <th>@lang('app.news.status')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($news->isNotEmpty())
                                        @foreach ($news as $new)
                                            <tr class="align-middle">
                                                <td>
                                                    <a href="{{ route('news.show', $new->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('news.edit', $new->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form id="deletePostForm" action="{{ route('news.destroy', $new->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete({{ $new->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>{{ $new->title }}</td>
                                                <td>
                                                    @if ($new->image)
                                                    <a href="{{ asset('storage/' . $new->image) }}"
                                                        data-fancybox="gallery" data-caption="{{ $new->title }}">
                                                        <img src="{{ asset('storage/images/thumbnails/' . basename($new->image)) }}"
                                                            alt="{{ $new->title }}" style="width: 50px; height: auto;">
                                                    </a>
                                                    @else
                                                        <p>No image available</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($new->category)
                                                        {{ $new->category->name }}
                                                    @else
                                                        None
                                                    @endif

                                                <td>{{ $new->user->name }}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $new->id }}" {{ $new->status ? 'checked' : '' }}>
                                                        <label class="form-check-label" id="statusLabel{{ $new->id }}">
                                                            {{-- Optionally: {{ $new->status ? 'Active' : 'Inactive' }} --}}
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Records Not Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $news->links('pagination::bootstrap-5') }}

                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedCategoryId = null;
            let selectedStatus = null;

            // Handle status toggle click event
            document.querySelectorAll('.status-toggle').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Store the category ID and status
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
                            updateStatus(selectedCategoryId, selectedStatus);
                        } else {
                            // If canceled, reset the checkbox to its previous state
                            document.querySelector(`input[data-id="${selectedCategoryId}"]`).checked = !selectedStatus;
                        }
                    });
                });
            });

            // Update status using AJAX and show SweetAlert on success
            function updateStatus(id, status) {
                fetch(`/news/update-status/${id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
        });

    </script>

<script>
    function handleDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('deletePostForm').submit();
            }
        });
    }
</script>




@endpush
