@extends('layouts.app')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Breadcrumbs::render('news.edit', $newsData) }}
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
                            <div class="card-title">@lang('app.edit') {{ $pageTitle }}</div>
                        </div>
                        <form action="{{ route('news.update', $newsData->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @include('admin.news.field', ['isEdit' => true])



                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-edit"></i>
                                    @lang('app.update')</button>
                                <a href="{{ route('news.index') }}" class="btn btn-warning text-white mt-3"><i
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
                @if (isset($newsData) && $newsData->image)
                    {
                        source: '{{ asset('storage/images/thumbnails/' . basename($newsData->image)) }}',
                        options: {
                            type: 'local',
                        },
                    }
                @endif
            ],
        });
    </script>

    {{-- <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        const inputElement = document.querySelector('#image');

        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['image/*'],
            server: {
                process: '{{ route('upload') }}',
                revert: '{{ route('revert') }}',
                load: '{{ route('load', ':filename') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            files: [
                @if (isset($newsData) && $newsData->image)
                    {
                        source: '{{ Storage::disk('public')->url($newsData->image) }}',
                        options: {
                            type: 'local',
                            file: {
                                name: '{{ basename($newsData->image) }}', // Name of the image
                                type: 'image/jpg' // Adjust based on image type
                            }
                        },
                    }
                @endif
            ],
        });
    </script> --}}

    {{-- <script>
        FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);

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
                    method: 'POST',
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
                    method: 'DELETE',
                },
                load: {
                    url: '{{ route('load', ':filename') }}',
                    method: 'GET',
                },
                fetch: {
                    url: '{{ route('fetch', ':filename') }}',
                    method: 'GET',
                }
            },
            files: [
                @if (isset($newsData) && $newsData->image)
                    {
                        source: '{{ asset('storage/' . $newsData->image) }}',
                        options: {
                            type: 'local',
                            file: {
                                name: '{{ basename($newsData->image) }}',
                                type: 'image/png' // Adjust based on the actual image type
                            }
                        },
                    }
                @endif
            ],
        });
    </script> --}}
@endpush
