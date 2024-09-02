<div class="card-body">

    <div class="mb-3">
        <label for="name" class="form-label">Category Name:</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" value="{{ old('name', $categoryData->name ?? '') }}">
        @error('name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="slug" class="form-label">Slug:</label>
        <input type="text" class="form-control" id="slug" name="slug" placeholder=" Slug" value="{{ old('slug', $categoryData->slug ?? '') }}">
        @error('slug')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea id="description" class="form-control" name="description">{{ old('description', $categoryData->description ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="image" name="image">
            <label class="input-group-text" for="image">Upload</label>
        </div>
        @if(isset($categoryData) && $categoryData->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $categoryData->image) }}" alt="{{ $categoryData->title }}" class="img-thumbnail" width="150">
            </div>
        @endif
        @error('image')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror

    </div>


</div>
