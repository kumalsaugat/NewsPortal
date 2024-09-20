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
                        <form action="{{ route('user.update', $userData->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        {{-- Name Field --}}
                                        <div class="mb-3">
                                            <label for="name" class="form-label"><strong>@lang('app.user.name'):<span class="text-danger">*</span></strong></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                                                value="{{ old('name', $userData->name ?? '') }}">
                                            @error('name')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Email Field --}}
                                        <div class="mb-3">
                                            <label for="email" class="form-label"><strong>@lang('app.user.email'):<span class="text-danger">*</span></strong></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                                                value="{{ old('email', $userData->email ?? '') }}">
                                            @error('email')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        {{-- Image Field --}}
                                        <div class="mb-3">
                                            <label for="image" class="form-label"><strong>@lang('app.user.image'):</strong></label>
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                            @error('image')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-edit"></i> @lang('app.update')</button>
                                <a href="{{ route('user.index') }}" class="btn btn-warning text-white mt-3"><i class="fas fa-times-circle"></i> @lang('app.cancel')</a>

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
                @if (isset($userData) && $userData->image)
                    {
                        source: '{{ asset('storage/' . $userData->image) }}',
                        options: {
                            type: 'local',
                        },
                    }
                @endif
            ],
        });
    </script>
@endpush
