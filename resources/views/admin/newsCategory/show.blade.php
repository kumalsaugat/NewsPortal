@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>
    <p>{!! $category->description !!}</p>
    <a href="{{ route('news-category.index') }}" class="btn btn-secondary">Back to Categories</a>
</div>
@endsection
