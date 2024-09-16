@extends('layouts.app')

@section('content')
    <div class="app-content">
        <div class="container-fluid">

            @include('admin.message')

            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">@lang('app.edit') : {{ $pageTitle }}</div>
                        </div>
                        <form action="{{ route('news-category.update', $categoryData->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @include('admin.newsCategory.field')

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('app.update')</button>
                                <a href="{{ route('news-category.index') }}" class="btn btn-outline-dark ml-3">@lang('app.back')</a>

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

        const inputElement = document.querySelector('#image');

        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['image/*'],
            server: {
                load: (source, load, error, progress, abort, headers) => {
                    fetch(source, {
                        mode: 'cors'
                    }).then((res) => {
                        return res.blob();
                    }).then(load).catch(error);
                },
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
            },

            files: [
                @if (isset($categoryData) && $categoryData->image)
                    {
                        source: '{{ asset('storage/' . $categoryData->image) }}',
                        options: {
                            type: 'local',
                        },
                    }
                @endif
            ],
        });
    </script>
@endpush
