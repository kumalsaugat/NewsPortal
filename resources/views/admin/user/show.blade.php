@extends('layouts.app')

@section('content')
    @include('admin.message')

    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Breadcrumbs::render('user.show', $users) }}
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
                                        <a href="{{ asset('storage/images/thumbnails/800px_' . basename($users->image)) }}" data-fancybox="gallery"
                                            data-caption="{{ $users->title }}">
                                            <img src="{{ asset('storage/images/thumbnails/100px_' . basename($users->image)) }}"
                                                alt="{{ $users->title }}" style=" width:100px; height: auto;">
                                        </a>
                                    @else
                                        <p>No image available</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.user.phone')</th>
                                <td>{{ $users->phone ? $users->phone : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.user.status')</th>
                                <td>
                                    @if (auth()->check() && auth()->id() === $users->id)
                                        <span
                                            style="color: #fff; background-color: {{ $users->status ? '#28a745' : '#dc3545' }};"
                                            class=" {{ $users->status ? 'badge badge-success' : 'badge badge-danger' }}">
                                            {{ $users->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    @else
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox"
                                                data-id="{{ $users->id }}" {{ $users->status ? 'checked' : '' }}>
                                            <label class="form-check-label" id="statusLabel{{ $users->id }}"></label>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.createdAt')</th>
                                <td>{{ $users->created_at }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">@lang('app.createdBy')</th>
                                <td>{{ optional($users->createdBy)->name ?? 'N/A' }}</td>
                            </tr>
                            @if ($users->updated_at && $users->updatedBy)
                                <tr>
                                    <th style="width: 200px;">@lang('app.updatedAt')</th>
                                    <td>{{ $users->updated_at }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 200px;">@lang('app.updatedBy')</th>
                                    <td>{{ optional($users->updatedBy)->name ?? 'N/A' }}</td>
                                </tr>
                            @endif
                        </table>
                        <a href="{{ route('user.index') }}" class="btn btn-warning mt-3 text-white"><i
                                class="fas fa-arrow-left"></i>
                            @lang('app.back')
                        </a>
                        <a href="{{ route('user.create') }}" class="btn btn-success  mt-3"> <i class="fas fa-plus"></i>
                            @lang('app.create')
                        </a>
                        <a href="{{ route('user.edit', $users->id) }}" class="btn btn-primary mt-3">
                            <i class="fas fa-edit"></i> @lang('app.update')
                        </a>
                        <a href="{{ route('password', $users->id) }}" class="btn btn-secondary mt-3">
                            <i class="fas fa-lock"></i> @lang('app.changePassword')
                        </a>
                        @auth
                            @if (auth()->id() !== $users->id)
                                <form id="deleteForm-user-{{ $users->id }}"
                                    action="{{ route('user.destroy', $users->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-danger mt-3"
                                        onclick="handleDelete('deleteForm-user-{{ $users->id }}')"><i
                                            class="fas fa-trash"></i>
                                        @lang('app.delete')
                                    </a>
                                </form>
                            @endif
                        @endauth


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupStatusToggles('.status-toggle', '/user/update-status');
        });
    </script>
@endpush
