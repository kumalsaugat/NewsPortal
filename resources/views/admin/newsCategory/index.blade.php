@extends('layouts.app')

@section('content')



    <div class="app-content"> <!--begin::Container-->


        <div class="container-fluid"> <!--begin::Row-->

            @include('admin.message')

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">


                        <div class="card-header ">
                            <a href="{{ route('news-category.create') }}">
                                <button type="submit" class="btn btn-success float-sm-right "><i class="fas fa-plus"></i> @lang('app.createNew')</button>
                            </a>
                        </div> <!-- /.card-header -->


                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 280px">@lang('app.action')</th>
                                        <th>@lang('app.category.name')</th>
                                        <th>@lang('app.category.image')</th>
                                        <th>@lang('app.category.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <tr class="align-middle">
                                                <td>
                                                    <a href="{{ route('news-category.show', $category->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('news-category.edit', $category->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form id="deleteForm-category-{{ $category->id }}" action="{{ route('news-category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete('deleteForm-category-{{ $category->id }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('news-category.edit', $category->id) }}" class="text-decoration-none">
                                                    {{ $category->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($category->image)

                                                        <a href="{{ asset('storage/' . $category->image) }}"
                                                            data-fancybox="gallery" data-caption="{{ $category->title }}">
                                                            <img src="{{ asset('storage/images/thumbnails/' . basename($category->image)) }}"
                                                                alt="{{ $category->title }}"
                                                                style="width: 50px; height: auto;">
                                                        </a>
                                                    @else
                                                        <p>No image available</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $category->id }}" {{ $category->status ? 'checked' : '' }}>
                                                        <label class="form-check-label" id="statusLabel{{ $category->id }}">
                                                            {{-- Optionally: {{ $category->status ? 'Active' : 'Inactive' }} --}}
                                                        </label>
                                                    </div>
                                                </td>
                                                {{-- <td>{!! Str::limit($category->description, 50) !!}</td> --}}
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Records Not Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $categories->links('pagination::bootstrap-5') }}

                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup status toggles for this module
            setupStatusToggles('.status-toggle', '/news-category/update-status');
        });
    </script>

@endpush

