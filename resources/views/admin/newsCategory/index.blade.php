@extends('layouts.app')

@section('content')



<div class="app-content"> <!--begin::Container-->


    <div class="container-fluid"> <!--begin::Row-->
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-3">
                {{ $message }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <a href="{{ route('news-category.create') }}" >
                            <button type="submit" class="btn btn-primary float-sm-right">Create New Category</button></a>



                    </div> <!-- /.card-header -->


                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Image</th>

                                    <th>Description</th>
                                    <th style="width: 280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>
                                                @if ($category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}"
                                                        alt="{{ $category->title }}" style="width: 50px; height: auto;">
                                                @else
                                                    <p>No image available</p>
                                                @endif
                                            </td>
                                            <td>{!! Str::limit($category->description, 50) !!}</td>
                                            <td>

                                                <a href="{{ route('news-category.show', $category->id)}}"
                                                    class="btn btn-info btn-sm">View</a>

                                                <a href="{{ route('news-category.edit', $category->id)}}"
                                                    class="btn btn-primary btn-sm">Edit</a>

                                                <form action="{{ route('news-category.destroy', $category->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                                </form>


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
                        {{ $categories->links('pagination::bootstrap-5') }}
                        {{-- <ul class="pagination pagination-sm m-0 float-end">
                            <li class="page-item"> <a class="page-link" href="#">&laquo;</a> </li>
                            <li class="page-item"> <a class="page-link" href="#">1</a> </li>
                            <li class="page-item"> <a class="page-link" href="#">2</a> </li>
                            <li class="page-item"> <a class="page-link" href="#">3</a> </li>
                            <li class="page-item"> <a class="page-link" href="#">&raquo;</a> </li>
                        </ul> --}}
                    </div>
                </div> <!-- /.card -->
            </div> <!-- /.col -->
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div> <!--end::App Content-->




@endsection

