
@extends('layouts.app')

@section('content')

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
                            <th>@lang('app.news.category')</th>
                            <td>{{ $news->category->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('app.news.user')</th>
                            <td>{{ $news->user->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('app.news.status')</th>
                            <td>{{ $news->status ? 'Active' : 'Inactive' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('app.news.desc')</th>
                            <td>{!! $news->description !!}</td>
                        </tr>
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
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

