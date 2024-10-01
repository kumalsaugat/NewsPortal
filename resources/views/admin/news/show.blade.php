@extends('layouts.app')

@section('content')
    @include('admin.message')

    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Breadcrumbs::render('news.edit', $news) }}
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
                        <h4>News Details</h4>
                    </div>
                    <div class="card-body mt-3">
                        <table class="table table-striped fixed-table">
                            <tr>
                                <th style="width: 200px;">@lang('app.news.title')</th>
                                <td>{{ $news->title }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.slug')</th>
                                <td>{{ $news->slug }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.category')</th>
                                <td>
                                    @if ($news->category)
                                        {{ $news->category->name }}
                                    @else
                                        None
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.image')</th>
                                <td>
                                    @if ($news->image)
                                        <a href="{{ asset('storage/' . $news->image) }}" data-fancybox="gallery"
                                            data-caption="{{ $news->title }}">
                                            <img src="{{ asset('storage/images/thumbnails/' . basename($news->image)) }}"
                                                alt="{{ $news->title }}" style="width: 50px; height: auto;">
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
                                            data-id="{{ $news->id }}" {{ $news->status ? 'checked' : '' }}>
                                        <label class="form-check-label" id="statusLabel{{ $news->id }}"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.desc')</th>
                                <td style="white-space: normal;">{!! $news->description !!}</td>
                                <!-- Add white-space: normal for text wrap -->
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.news.publish')</th>
                                <td>{{ $news->published_at }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.createdAt')</th>
                                <td>{{ $news->created_at }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.createdBy')</th>
                                <td>{{ optional($news->createdBy)->name ?? 'N/A' }}</td>
                            </tr>
                            @if ($news->updated_at && $news->updatedBy)
                                <tr>
                                    <th style="width: 200px;">@lang('app.updatedAt')</th>
                                    <td>{{ $news->updated_at }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 200px;">@lang('app.updatedBy')</th>
                                    <td>{{ optional($news->updatedBy)->name ?? 'N/A' }}</td>
                                </tr>
                            @endif
                        </table>
                        <a href="{{ route('news.index') }}" class="btn btn-warning mt-3 text-white"><i
                                class="fas fa-arrow-left"></i>
                            @lang('app.back')
                        </a>
                        <a href="{{ route('news.create') }}" class="btn btn-success  mt-3"> <i class="fas fa-plus"></i>
                            @lang('app.createNew')
                        </a>
                        <a href="{{ route('news.edit', $news->id) }}" class="btn btn-primary mt-3">
                            <i class="fas fa-edit"></i> @lang('app.update')
                        </a>
                        <form id="deleteForm-news-{{ $news->id }}" action="{{ route('news.destroy', $news->id) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <a class="btn btn-danger mt-3" onclick="handleDelete('deleteForm-news-{{ $news->id }}')"><i
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
            setupStatusToggles('.status-toggle', '/news/update-status');
        });
    </script>
@endpush
