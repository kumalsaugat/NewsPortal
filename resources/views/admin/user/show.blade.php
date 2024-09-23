
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
                            <th style="width: 200px;">@lang('app.user.name')</th>
                            <td>{{ $users->name }}</td>
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.user.email')</th>
                            <td>{{ $users->email }}</td>
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.user.image')</th>
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
                            <th style="width: 200px;">@lang('app.createdAt')</th>
                            <td>{{ $users->created_at}}</td>
                        </tr>
                        <tr>
                            <th style="width: 200px;">@lang('app.createdBy')</th>
                            <td>{{ optional($users->createdBy)->name ?? 'N/A' }}</td>
                        </tr>
                        @if ($users->updated_at && $users->updatedBy)
                            <tr>
                                <th style="width: 200px;">@lang('app.updatedAt')</th>
                                <td>{{$users->updated_at}}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.updatedBy')</th>
                                <td>{{ optional($users->updatedBy)->name ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    </table>
                    <a href="{{ route('user.index') }}" class="btn btn-warning mt-3 text-white"><i class="fas fa-arrow-left"></i>
                        @lang('app.back')
                    </a>
                    {{-- <a href="{{ route('user.create') }}" class="btn btn-success  mt-3"> <i class="fas fa-plus"></i>
                        @lang('app.createNew')
                    </a> --}}
                    <a href="{{ route('user.edit', $users->id) }}" class="btn btn-primary mt-3">
                        <i class="fas fa-edit"></i> @lang('app.update')
                    </a>
                    <form id="deleteForm-user-{{ $users->id }}" action="{{ route('user.destroy', $users->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-danger mt-3" onclick="handleDelete('deleteForm-user-{{ $users->id }}')"><i class="fas fa-trash"></i>
                            @lang('app.delete')
                        </a>
                    </form>


                </div>

            </div>
        </div>
    </div>
</div>
@endsection

