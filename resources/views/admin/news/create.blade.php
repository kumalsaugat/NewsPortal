@extends('layouts.app')


@section('content')
    <div class="app-content">
        <div class="container-fluid">

            @include('admin.message')

            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">@lang('app.create'): {{ $pageTitle }}</div>
                        </div>
                        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('admin.news.field')

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('app.submit')</button>
                                <a href="{{ route('news.index') }}" class="btn btn-success ml-3">@lang('app.back')</a>

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
        // Initialize TinyMCE for the textarea
        initTinyMCE('#description');
    </script>


    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        const pond = FilePond.create(document.querySelector('#image'), {
            acceptedFileTypes: ['image/*'],
            server: {
                process: {
                    url: '{{ route('upload') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        const data = JSON.parse(response);
                        return data.path;
                    }
                },
                revert: {
                    url: '{{ route('revert') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            }
        });
    </script>
@endpush
