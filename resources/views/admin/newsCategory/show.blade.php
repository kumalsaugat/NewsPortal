
@extends('layouts.app')

@section('content')
@include('admin.message')

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ Breadcrumbs::render('news-category.show', $category) }}
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
                    <h4>Category Details</h4>
                </div>
                <div class="card-body mt-3">
                    <table class="table table-striped fixed-table">
                        <tr>
                            <th style="width: 200px;">@lang('app.category.name')</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.category.slug')</th>
                            <td>{{ $category->slug }}</td>
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.category.image')</th>
                            <td>
                                @if ($category->image)
                                    <a href="{{ asset('storage/images/thumbnails/800px_' . basename($category->image)) }}"
                                        data-fancybox="gallery" data-caption="{{ $category->title }}">
                                        <img src="{{ asset('storage/images/thumbnails/100px_' . basename($category->image)) }}"
                                            alt="{{ $category->title }}"
                                            style=" width:100px; height: auto;">
                                    </a>
                                @else
                                    <p>No image available</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.category.status')</th>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $category->id }}" {{ $category->status ? 'checked' : '' }}>
                                    <label class="form-check-label" id="statusLabel{{ $category->id }}"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.category.desc')</th>
                            <td >{!! nl2br(e($category->description)) !!}</td>  <!-- Add white-space: normal for text wrap -->
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.createdAt')</th>
                            <td>{{ $category->created_at}}</td>
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.createdBy')</th>
                            <td>{{ optional($category->createdBy)->name ?? 'N/A' }}</td>
                        </tr>
                        @if ($category->updated_at && $category->updatedBy)
                            <tr>
                                <th style="width: 200px;">@lang('app.updatedAt')</th>
                                <td>{{$category->updated_at}}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.updatedBy')</th>
                                <td>{{ optional($category->updatedBy)->name ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    </table>
                    <a href="{{ route('news-category.index') }}" class="btn btn-warning mt-3 text-white"><i class="fas fa-arrow-left"></i>
                        @lang('app.back')
                    </a>
                    <a href="{{ route('news-category.create') }}" class="btn btn-success  mt-3"> <i class="fas fa-plus"></i>
                        @lang('app.create')
                    </a>
                    <a href="{{ route('news-category.edit', $category->id) }}" class="btn btn-primary mt-3">
                        <i class="fas fa-edit"></i> @lang('app.update')
                    </a>
                    <form id="deleteForm-category-{{ $category->id }}" action="{{ route('news-category.destroy', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-danger mt-3" onclick="handleDelete('deleteForm-category-{{ $category->id }}')"><i class="fas fa-trash"></i>
                            @lang('app.delete')
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup status toggles for this module
            setupStatusToggles('.status-toggle', '/news-category/update-status');
        });
    </script>

@endpush
