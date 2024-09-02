<div class="card-body">

    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ old('title', $newsData->title ?? '') }}">
        @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="slug" class="form-label">Slug:</label>
        <input type="text" class="form-control" id="slug" name="slug" placeholder=" Slug" value="{{ old('slug', $newsData->slug ?? '') }}">
        @error('slug')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea id="description" class="form-control" name="description">{{ old('description', $newsData->description ?? '') }}</textarea>
        @error('description')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="image" name="image">
            <label class="input-group-text" for="image">Upload</label>
        </div>
        @if(isset($newsData) && $newsData->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $newsData->image) }}" alt="{{ $newsData->title }}" class="img-thumbnail" width="150">
            </div>
        @endif
        @error('image')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror

    </div>

    <div class="mb-3">
        <label for="user_id" class="form-label"><strong>User:</strong></label>
        <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user_id">
            <option value="">Select User</option>

        </select>
        @error('user_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>


</div>
