@extends('layouts.app')

@section('content')


    <div class="app-content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Create News Category</div>
                        </div>
                        <form action="{{ route('news-category.update', $categoryData->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $categoryData->name }}"  placeholder="Enter Category Name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug:</label>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $categoryData->slug }}" placeholder=" Slug" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea id="description" class="form-control" name="description" >{{ $categoryData->description }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image:</label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" id="image" name="image">

                                        <label class="input-group-text" for="image">Upload</label>

                                    </div>
                                    @if ($categoryData->image)
                                            <img src="{{ asset('storage/' . $categoryData->image) }}"
                                                alt="{{ $categoryData->title }}" class="img-thumbnail mt-2" width="150">
                                        @endif
                                    @error('image')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('news-category.index')}}" class="btn btn-outline-dark ml-3">Back</a>

                            </div>

                        </form>
                    </div>


                </div>


            </div>
        </div>
    </div>





@endsection

