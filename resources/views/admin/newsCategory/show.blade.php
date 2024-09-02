
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Category Details</h4>
                </div>
                <div class="card-body mt-3">
                    <div>
                        <strong>Title:</strong> {{ $category->name }}
                    </div>
                    <div>
                        <strong>Slug:</strong> {{ $category->slug }}
                    </div>

                    <div>
                        <strong>Image:</strong>
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->title }}" style="width: 50px; height: auto;">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>
                    <a href="{{ route('news-category.index') }}" class="btn btn-primary mt-3">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

