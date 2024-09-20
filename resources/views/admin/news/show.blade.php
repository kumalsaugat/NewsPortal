
@extends('layouts.app')

@section('content')
@include('admin.message')
<div class="container">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>News Details</h4>
                </div>
                <div class="card-body mt-3">
                    <table class="table table-striped">
                        <tr>
                            <th>@lang('app.news.title')</th>
                            <td>{{ $news->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('app.news.slug')</th>
                            <td>{{ $news->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('app.news.category')</th>
                            <td>
                                @if ($news->category)
                                    {{ $news->category->name }}
                                @else
                                    None
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('app.news.image')</th>
                            <td>
                                @if ($news->image)
                                    <a href="{{ asset('storage/' . $news->image) }}"
                                        data-fancybox="gallery" data-caption="{{ $news->title }}">
                                        <img src="{{ asset('storage/images/thumbnails/' . basename($news->image)) }}"
                                            alt="{{ $news->title }}" style="width: 50px; height: auto;">
                                    </a>
                                @else
                                    <p>No image available</p>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>@lang('app.news.status')</th>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $news->id }}" {{ $news->status ? 'checked' : '' }}>
                                    <label class="form-check-label" id="statusLabel{{ $news->id }}"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('app.news.desc')</th>
                            <td>{!! $news->description !!}</td>
                        </tr>
                        <tr>
                            <th>Published At</th>
                            <td>{{ $news->published_at }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $news->created_at}}</td>
                        </tr>
                        <tr>
                            <th>Created By</th>
                            <td>{{ optional($news->createdBy)->name ?? 'N/A' }}</td>
                        </tr>
                        @if ($news->updated_at && $news->updatedBy)
                            <tr>
                                <th>Updated At</th>
                                <td>{{$news->updated_at}}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{ optional($news->updatedBy)->name ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    </table>
                    <a href="{{ route('news.index') }}" class="btn btn-secondary mt-3">
                        @lang('app.back')
                    </a>
                    <a href="{{ route('news.create') }}" class="btn btn-success mt-3">
                        @lang('app.createNew')
                    </a>
                    <a href="{{ route('news.edit',$news->id) }}" class="btn btn-warning mt-3">
                        @lang('app.edit')
                    </a>
                    <form id="deleteForm-news-{{ $news->id }}" action="{{ route('news.destroy', $news->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <a onclick="handleDelete('deleteForm-news-{{ $news->id }}')" class="btn btn-warning mt-3">
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
            setupStatusToggles('.status-toggle', '/news/update-status');
        });
    </script>

@endpush

