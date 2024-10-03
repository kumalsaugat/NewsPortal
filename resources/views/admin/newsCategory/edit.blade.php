@extends('layouts.app')

@section('content')

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ Breadcrumbs::render('news-category.edit', $categoryData) }}
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
                            <div class="card-title"><h4>@lang('app.edit') {{ $pageTitle }}</h4></div>
                        </div>
                        <form action="{{ route('news-category.update', $categoryData->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @include('admin.newsCategory.field')

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-edit"></i> @lang('app.update')</button>
                                <a href="{{ route('news-category.index') }}" class="btn btn-warning text-white mt-3"><i class="fas fa-times-circle"></i> @lang('app.cancel')</a>
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
                        source: '{{ asset('storage/images/thumbnails/800px_' . basename($categoryData->image)) }}',
                        options: {
                            type: 'local',
                        },
                    }
                @endif
            ],
        });
    </script>
@endpush
