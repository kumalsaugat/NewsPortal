@extends('layouts.app')

@section('content')


    <div class="app-content">
        <div class="container-fluid">

            @include('admin.message')

            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Create News Category</div>
                        </div>
                        <form action="{{ route('news-category.update', $categoryData->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @include('admin.newsCategory.field')

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('news-category.index')}}" class="btn btn-outline-dark ml-3">Back</a>

                            </div>

                        </form>
                    </div>


                </div>


            </div>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'lists link image table code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | code',
            menubar: false,
        });
    </script>




@endsection

