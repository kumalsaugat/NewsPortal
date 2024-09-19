
@extends('layouts.app')

@section('content')
@include('admin.message')
<div class="container">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>User Details</h4>
                </div>
                <div class="card-body mt-3">
                    <table class="table table-striped">
                        <tr>
                            <th>@lang('app.user.name')</th>
                            <td>{{ $users->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('app.user.email')</th>
                            <td>{{ $users->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('app.user.image')</th>
                            <td>
                                @if ($users->image)
                                    <a href="{{ asset('storage/' . $users->image) }}"
                                        data-fancybox="gallery" data-caption="{{ $users->title }}">
                                        <img src="{{ asset('storage/images/thumbnails/' . basename($users->image)) }}"
                                            alt="{{ $users->title }}" style="width: 50px; height: auto;">
                                    </a>
                                @else
                                    <p>No image available</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $users->created_at}}</td>
                        </tr>
                        <tr>
                            <th>Created By</th>
                            <td>{{ optional($users->createdBy)->name ?? 'N/A' }}</td>
                        </tr>
                        @if ($users->updated_at && $users->updatedBy)
                            <tr>
                                <th>Updated At</th>
                                <td>{{$users->updated_at}}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{ optional($users->updatedBy)->name ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    </table>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">
                        @lang('app.back')
                    </a>
                    <a href="{{ route('user.create') }}" class="btn btn-success mt-3">
                        @lang('app.createNew')
                    </a>
                    <a href="{{ route('user.edit',$users->id) }}" class="btn btn-warning mt-3">
                        @lang('app.edit')
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

