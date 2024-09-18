
@extends('layouts.app')

@section('content')
@include('admin.message')
<div class="container">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Category Details</h4>
                </div>
                <div class="card-body mt-3">
                    <table class="table table-striped">
                        <tr>
                            <th>Title</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $category->slug }}</td>
                        </tr>
                        <tr>
                            <th>Image</th>
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
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $category->status }}</td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{!! $category->description !!}</td>
                        </tr>
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $category->created_at}}</td>
                        </tr>
                        <tr>
                            <th>Created By:</th>
                            <td>{{ optional($category->createdBy)->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Updated At:</th>
                            <td>{{$category->updated_at}}</td>
                        </tr>
                        <tr>
                            <th>Updated By:</th>
                             <td>{{ optional($category->updatedBy)->name ?? 'N/A' }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('news-category.index') }}" class="btn btn-secondary mt-3">
                        @lang('app.back')
                    </a>
                    <a href="{{ route('news-category.create') }}" class="btn btn-success mt-3">
                        @lang('app.createNew')
                    </a>
                    <a href="{{ route('news-category.edit',$category->id) }}" class="btn btn-warning mt-3">
                        @lang('app.edit')
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

