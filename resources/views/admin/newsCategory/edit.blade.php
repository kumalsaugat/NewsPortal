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
@endpush
