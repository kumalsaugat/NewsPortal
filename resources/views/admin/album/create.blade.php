@extends('layouts.app')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Breadcrumbs::render('album.create') }}
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->



    <div class="app-content">
        <div class="container-fluid">

            @include('admin.message')


            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>@lang('app.create') {{ $pageTitle }}</h4>
                            </div>
                        </div>
                        <form action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('admin.album.field')

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i>
                                    @lang('app.submit')</button>
                                <a href="{{ route('album.index') }}" class="btn btn-warning text-white mt-3"><i
                                        class="fas fa-times-circle"></i> @lang('app.cancel')</a>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        const pond = FilePond.create(document.querySelector('#image'), {
            acceptedFileTypes: ['image/*'],
            multiple: true, // Allow multiple file uploads
            server: {
                process: {
                    url: '{{ route('multipleUpload') }}', // Temporary upload route for multiple files
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        const data = JSON.parse(response);
                        const input = document.querySelector('input[name="uploaded_images"]'); // Store multiple paths

                        let existingImages = input.value ? JSON.parse(input.value) : [];

                        // Append the newly uploaded image paths to the array
                        data.paths.forEach((path) => {
                            existingImages.push(path);
                        });

                        input.value = JSON.stringify(existingImages); // Store as JSON array in hidden input
                        return data.paths;
                    }
                },
                revert: {
                    url: '{{ route('revert') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        console.log('File reverted:', response);
                    }
                },
            }
        });

    </script>
@endpush
