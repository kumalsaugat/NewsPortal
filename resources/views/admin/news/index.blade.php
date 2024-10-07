@extends('layouts.app')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Breadcrumbs::render('news.index') }}
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->




    <div class="app-content"> <!--begin::Container-->


        <div class="container-fluid"> <!--begin::Row-->

            @include('admin.message')



            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">

                        <div class="card-body p-3">
                            <div class="d-flex mb-3">

                                    <!-- Action Buttons -->
                                    <a href="{{ route('news.create') }}">
                                        <button class="btn btn-success" ><i class="fa fa-plus"></i>
                                            @lang('app.createNew')
                                        </button>
                                    </a>

                                    <!-- Reset Button -->
                                    <button type="button" class="btn btn-danger" onClick="resetTable()" style="margin-left: 10px">
                                        <i class="fa fa-undo"></i> Reset
                                    </button>

                                    <!-- Reload Button -->
                                    <button type="button" class="btn btn-warning" id="reloadTable"
                                        onclick="location.reload();" style="margin-left: 10px">
                                        <i class="fa fa-sync"></i> Reload
                                    </button>
                                    <div class="d-flex" style="margin-left: 10px">
                                        <select id="bulkAction" class="form-select me-2" style="width: auto;">
                                            <option value="" selected disabled>Bulk Action</option>
                                            <option value="toggle-status">Toggle Status</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button class="btn btn-secondary" id="applyBulkAction">Apply</button>
                                    </div>

                            </div>
                            <div class="table-responsive">
                                {!! $dataTable->table(['class' => 'table table-striped table-bordered dt-responsive nowrap', 'width' => '100%']) !!}
                            </div>
                        </div> <!-- /.card-body -->

                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup status toggles for this module
            setupStatusToggles('.status-toggle', '/news/update-status');

            // Re-initialize the status toggle after DataTable is drawn
            $(document).on('draw.dt', function() {
                setupStatusToggles('.status-toggle', '/news/update-status');
            });
        });
    </script>

    <script>
        $('#select-all').click(function() {
            $('input[name="selected_rows[]"]').prop('checked', this.checked);
        });
    </script>
    <script>
        // Setup bulk actions for this specific page
        setupBulkActions({
            applyBulkAction: '#applyBulkAction',
            rowSelector: 'input[name="selected_rows[]"]',
            bulkAction: '#bulkAction',
            updateUrl: '/news/bulk-update-status', // URL for update status
            deleteUrl: '/news/bulk-delete' // URL for delete
        });
    </script>

@endpush
