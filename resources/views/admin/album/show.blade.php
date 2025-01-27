@extends('layouts.app')

@section('content')
    @include('admin.message')

    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Breadcrumbs::render('album.show', $albums) }}
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->


    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Album Details</h4>
                    </div>
                    <div class="card-body mt-3">
                        <table class="table table-striped fixed-table">
                            <tr>
                                <th style="width: 200px;">@lang('app.news.title')</th>
                                <td>{{ $albums->title }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.slug')</th>
                                <td>{{ $albums->slug }}</td>
                            </tr>
                            {{-- <tr>
                                <th style="width: 200px;">@lang('app.news.category')</th>
                                <td>
                                    @if ($news->category)
                                        {{ $news->category->name }}
                                    @else
                                        None
                                    @endif
                                </td>
                            </tr> --}}
                            <tr>
                                <th style="width: 200px;">@lang('app.news.image')</th>
                                <td>
                                    @if ($albums->image)
                                        <a href="{{ asset('storage/images/thumbnails/800px_' . basename($albums->image)) }}" data-fancybox="gallery"
                                            data-caption="{{ $news->title }}">
                                            <img src="{{ asset('storage/images/thumbnails/100px_' . basename($albums->image)) }}"
                                                alt="{{ $albums->title }}" style=" width:100px; height: auto;">
                                        </a>
                                    @else
                                        <p>No image available</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.status')</th>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox"
                                            data-id="{{ $albums->id }}" {{ $albums->status ? 'checked' : '' }}>
                                        <label class="form-check-label" id="statusLabel{{ $albums->id }}"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.desc')</th>
                                <td style="white-space: normal;">{{ $albums->description }}</td>
                                <!-- Add white-space: normal for text wrap -->
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.publish')</th>
                                <td>{{ $albums->date }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.createdAt')</th>
                                <td>{{ $albums->created_at }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.createdBy')</th>
                                <td>{{ optional($albums->createdBy)->name ?? 'N/A' }}</td>
                            </tr>
                            @if ($albums->updated_at && $albums->updatedBy)
                                <tr>
                                    <th style="width: 200px;">@lang('app.updatedAt')</th>
                                    <td>{{ $albums->updated_at }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 200px;">@lang('app.updatedBy')</th>
                                    <td>{{ optional($albums->updatedBy)->name ?? 'N/A' }}</td>
                                </tr>
                            @endif
                        </table>
                        <a href="{{ route('album.index') }}" class="btn btn-warning mt-3 text-white"><i
                                class="fas fa-arrow-left"></i>
                            @lang('app.back')
                        </a>
                        <a href="{{ route('album.create') }}" class="btn btn-success  mt-3"> <i class="fas fa-plus"></i>
                            @lang('app.create')
                        </a>
                        <a href="{{ route('album.edit', $albums->id) }}" class="btn btn-primary mt-3">
                            <i class="fas fa-edit"></i> @lang('app.update')
                        </a>
                        <form id="deleteForm-albums-{{ $albums->id }}" action="{{ route('album.destroy', $albums->id) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <a class="btn btn-danger mt-3" onclick="handleDelete('deleteForm-albums-{{ $albums->id }}')"><i
                                    class="fas fa-trash"></i>
                                @lang('app.delete')
                            </a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Ensure the table header (th) has a fixed width */
        .fixed-table {
            table-layout: fixed;
            /* Ensures that th width is fixed and td can wrap */
            width: 100%;
        }

        .fixed-table th {
            width: 200px;
            white-space: nowrap;
        }

        .fixed-table td {
            width: auto;
            overflow-wrap: break-word;
            /* Allows breaking long words */
            word-wrap: break-word;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupStatusToggles('.status-toggle', '/album/update-status');
        });
    </script>
@endpush
