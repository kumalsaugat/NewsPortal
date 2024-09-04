<div class="card-body">

    <div class="mb-3">
        <label for="title" class="form-label"><strong>Title:<span class="text-danger">*</span></strong></label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ old('title', $newsData->title ?? '') }}">
        @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="slug" class="form-label"><strong>Slug:<span class="text-danger">*</span></strong></label>
        <input type="text" class="form-control" id="slug" name="slug" placeholder=" Slug" value="{{ old('slug', $newsData->slug ?? '') }}">
        @error('slug')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label"><strong>Description:<span class="text-danger">*</span></label>
        <textarea id="description" class="form-control" name="description">{{ old('description', $newsData->description ?? '') }}</textarea>
        @error('description')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="image" name="image">
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

    <div class="form-group mb-3">
        <label for="category_id" class="form-label"><strong>Category:<span class="text-danger">*</span></label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $newsData->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="status" class="form-label"><strong>Status:<span class="text-danger">*</span></label>
        <div class="form-check form-switch">
            <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" role="switch"
                   id="status" name="status" value="1"
                   {{ (isset($newsData) && $newsData->status) || old('status') ? 'checked' : '' }}
                   onchange="toggleStatusLabel()">
            <label class="form-check-label" for="status" id="statusLabel">
                {{ (isset($newsData) && $newsData->status) || old('status') ? 'Active' : 'Inactive' }}
            </label>
        </div>
        @error('status')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="published_at">Publish Date:</label>
        <input type="datetime-local" name="published_at" class="form-control" id="published_at"
            value="{{ old('published_at', isset($newsData->published_at) ? $newsData->published_at->format('Y-m-d\TH:i') : '') }}">
        @error('published_at')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

</div>

<script>
    function toggleStatusLabel() {
        const statusCheckbox = document.getElementById('status');
        const statusLabel = document.getElementById('statusLabel');

        if (statusCheckbox.checked) {
            statusLabel.textContent = 'Active';
        } else {
            statusLabel.textContent = 'Inactive';
        }
    }

    // Initialize the label text based on the checkbox's initial state
    document.addEventListener('DOMContentLoaded', (event) => {
        toggleStatusLabel();
    });
</script>


