@extends('layouts.app')

@section('content')



    <div class="app-content"> <!--begin::Container-->


        <div class="container-fluid"> <!--begin::Row-->

            @include('admin.message')

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">


                        <div class="card-header ">
                            <a href="{{ route('news-category.create') }}">
                                <button type="submit" class="btn btn-success float-sm-right ">@lang('app.createNew')</button></a>
                        </div> <!-- /.card-header -->


                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>@lang('app.category.name')</th>
                                        <th>@lang('app.category.slug')</th>
                                        <th>@lang('app.category.image')</th>
                                        <th>@lang('app.category.status')</th>
                                        <th style="width: 280px">@lang('app.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->slug }}</td>


                                                <td>
                                                    @if ($category->image)

                                                        <a href="{{ asset('storage/' . $category->image) }}"
                                                            data-fancybox="gallery" data-caption="{{ $category->title }}">
                                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                                alt="{{ $category->title }}"
                                                                style="width: 50px; height: auto;">
                                                        </a>
                                                    @else
                                                        <p>No image available</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox"
                                                            data-id="{{ $category->id }}"
                                                            {{ $category->status ? 'checked' : '' }}>
                                                        <label class="form-check-label" id="statusLabel{{ $category->id }}">
                                                            {{-- {{ $category->status ? 'Active' : 'Inactive' }} --}}
                                                        </label>
                                                    </div>
                                                </td>
                                                {{-- <td>{!! Str::limit($category->description, 50) !!}</td> --}}
                                                <td>
                                                    <a href="{{ route('news-category.show', $category->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('news-category.edit', $category->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('news-category.destroy', $category->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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
                            {{ $categories->links('pagination::bootstrap-5') }}

                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->

    {{-- status modal --}}
    <div class="modal fade" id="modal-status-toggle" tabindex="-1" aria-labelledby="modal-status-toggle"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-status-toggle">Confirm Status Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to update the status of this News category?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmStatusUpdate">Update</button>
                </div>
            </div>
        </div>
    </div>
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

                    // Show confirmation modal
                    var modal = new bootstrap.Modal(document.getElementById('modal-status-toggle'));
                    modal.show();
                });
            });

            // Handle modal confirmation for status update
            document.getElementById('confirmStatusUpdate').addEventListener('click', function() {
                if (selectedCategoryId !== null) {
                    updateStatus(selectedCategoryId, selectedStatus);
                }
            });

            // Update status using AJAX and show SweetAlert on success
            function updateStatus(id, status) {
                fetch(`/news-category/update-status/${id}`, {
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
                            // document.getElementById(`statusLabel${id}`).textContent = status ? 'Active' :
                            //     'Inactive';

                            // Manually update the toggle status
                            document.querySelector(`input[data-id="${id}"]`).checked = status;

                            Swal.fire({
                                title: 'Success!',
                                text: 'Status updated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        }

                        // Hide the modal after update
                        var modal = bootstrap.Modal.getInstance(document.getElementById('modal-status-toggle'));
                        modal.hide();
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                    });
            }
        });
    </script>
@endpush

