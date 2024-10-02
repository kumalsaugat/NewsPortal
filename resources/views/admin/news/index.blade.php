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
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <!-- Action Buttons -->
                                    <a href="{{ route('news.create') }}">
                                        <button class="btn btn-success"><i class="fa fa-plus"></i>
                                            @lang('app.createNew')</button></a>
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
@endpush
