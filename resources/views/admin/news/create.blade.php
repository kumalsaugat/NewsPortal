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
                                <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i> @lang('app.submit')</button>
                                <a href="{{ route('news.index') }}" class="btn btn-warning text-white mt-3"><i class="fas fa-times-circle"></i> @lang('app.cancel')</a>


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


    {{-- <script>
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

        // If there's an old image, load it into FilePond
        const oldImagePath = document.querySelector('#image_path').value;
        if (oldImagePath) {
            pond.addFile(`{{ asset('storage') }}/${oldImagePath}`).then(() => {
                console.log('Image restored');
            });
        }
    </script> --}}

<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateType);

    const pond = FilePond.create(document.querySelector('#image'), {
        acceptedFileTypes: ['image/*'],
        server: {
            process: {
                url: '{{ route('upload') }}',  // Temporary upload route
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                onload: (response) => {
                    const data = JSON.parse(response);
                    document.querySelector('input[name="uploaded_image"]').value = data.path; // Store temp file path
                    return data.path;
                }
            },
            revert: {
                url: '{{ route('revert') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            load: '{{ old('uploaded_image') }}', // Restore the temporarily uploaded image
        }
    });

    // If there's an old uploaded image, load it into FilePond
    @if (old('uploaded_image'))
        pond.addFile("{{ asset('storage/' . old('uploaded_image')) }}");
    @endif
</script>
@endpush
