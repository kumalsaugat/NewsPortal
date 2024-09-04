@extends('layouts.app')

@push('styles')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@section('content')


    <div class="app-content">
        <div class="container-fluid">

            @include('admin.message')

            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Edit News</div>
                        </div>
                        <form action="{{ route('news.update', $newsData->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @include('admin.news.field')

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('news.index')}}" class="btn btn-outline-dark ml-3">Back</a>

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

@push('scripts')
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>


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
