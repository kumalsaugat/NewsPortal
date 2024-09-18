@extends('layouts.app')

@section('content')



    <div class="app-content"> <!--begin::Container-->


        <div class="container-fluid"> <!--begin::Row-->

            @include('admin.message')

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">

                        <div class="card-header ">
                            <a href="{{ route('news.create') }}">
                                <button type="submit" class="btn btn-success float-sm-right ">@lang('app.createNew')</button></a>
                        </div> <!-- /.card-header -->


                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 280px">@lang('app.action')</th>
                                        <th>@lang('app.news.title')</th>
                                        <th>@lang('app.news.category')</th>
                                        <th>@lang('app.news.image')</th>
                                        <th>@lang('app.news.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($news->isNotEmpty())
                                        @foreach ($news as $new)
                                            <tr class="align-middle">
                                                <td>
                                                    <a href="{{ route('news.show', $new->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('news.edit', $new->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form id="deleteForm-news-{{ $new->id }}" action="{{ route('news.destroy', $new->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete('deleteForm-news-{{ $new->id }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>{{ $new->title }}</td>
                                                <td>
                                                    @if ($new->category)
                                                        {{ $new->category->name }}
                                                    @else
                                                        None
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($new->image)
                                                    <a href="{{ asset('storage/' . $new->image) }}"
                                                        data-fancybox="gallery" data-caption="{{ $new->title }}">
                                                        <img src="{{ asset('storage/images/thumbnails/' . basename($new->image)) }}"
                                                            alt="{{ $new->title }}" style="width: 50px; height: auto;">
                                                    </a>
                                                    @else
                                                        <p>No image available</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $new->id }}" {{ $new->status ? 'checked' : '' }}>
                                                        <label class="form-check-label" id="statusLabel{{ $new->id }}">
                                                            {{-- Optionally: {{ $new->status ? 'Active' : 'Inactive' }} --}}
                                                        </label>
                                                    </div>
                                                </td>
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
                            {{ $news->links('pagination::bootstrap-5') }}

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
            setupStatusToggles('.status-toggle', '/news/update-status');
        });
    </script>

@endpush
