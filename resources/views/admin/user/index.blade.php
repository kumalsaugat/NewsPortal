@extends('layouts.app')

@section('content')



    <div class="app-content"> <!--begin::Container-->


        <div class="container-fluid"> <!--begin::Row-->

            @include('admin.message')

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">

                        <div class="card-header ">
                            {{-- <a href="{{ route('user.create') }}">
                                <button type="submit" class="btn btn-primary float-sm-right ">Create User</button>
                            </a> --}}
                        </div>


                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th >Action</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->isNotEmpty())
                                        @foreach ($users as $user)
                                            <tr class="align-middle">
                                                <td>
                                                    <a href="{{ route('user.show', $user->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @auth
                                                        {{-- Only show the delete button if the authenticated user is not the same as the user being deleted --}}
                                                        @if (auth()->id() !== $user->id)
                                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endauth

                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if ($user->image)
                                                    <a href="{{ asset('storage/' . $user->image) }}"
                                                        data-fancybox="gallery" data-caption="{{ $user->title }}">
                                                        <img src="{{ asset('storage/' . $user->image) }}"
                                                            alt="{{ $user->title }}" style="width: 50px; height: auto;">
                                                    </a>
                                                    @else
                                                        <p>No image available</p>
                                                    @endif
                                                </td>


                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Records Not Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $users->links('pagination::bootstrap-5') }}

                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->



@endsection

