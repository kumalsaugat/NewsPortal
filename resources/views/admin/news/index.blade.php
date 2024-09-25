@extends('layouts.app')

@section('content')



    <div class="app-content"> <!--begin::Container-->


        <div class="container-fluid"> <!--begin::Row-->

            @include('admin.message')

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">

                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <!-- Action Buttons -->
                                    <a href="{{ route('news.create') }}">
                                    <button class="btn btn-success"><i class="fa fa-plus"></i>  @lang('app.createNew')</button></a>
                                </div>
                            </div>

                            {{-- <table class="table table-striped" id="myTable">
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
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('news.edit', $new->id) }}"
                                                        class="btn btn-primary btn-sm">
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
                                                <td>
                                                    <a href="{{ route('news.edit', $new->id) }}" class="text-decoration-none">
                                                        {{ $new->title }}
                                                    </a>
                                                </td>
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
                            </table> --}}
                            {!! $dataTable->table() !!}
                        </div> <!-- /.card-body -->
                        {{-- <div class="card-footer clearfix">
                            {{ $news->links('pagination::bootstrap-5') }}

                        </div> --}}
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->

@endsection

@push('scripts')

{!! $dataTable->scripts() !!}


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup status toggles for this module
        setupStatusToggles('.status-toggle', '/news/update-status');

        // Re-initialize the status toggle after DataTable is drawn
        $(document).on('draw.dt', function() {
            setupStatusToggles('.status-toggle', '/news/update-status');
        });
    });
</script>


@endpush
