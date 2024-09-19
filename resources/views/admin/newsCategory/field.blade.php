<div class="card-body">

    <div class="mb-3">
        <label for="name" class="form-label"><strong>@lang('app.category.name'):<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" value="{{ old('name', $categoryData->name ?? '') }}">
        @error('name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="slug" class="form-label"><strong>@lang('app.category.slug'):<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="slug" name="slug" placeholder=" Slug" value="{{ old('slug', $categoryData->slug ?? '') }}">
        @error('slug')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">@lang('app.category.desc'):</label>
        <textarea id="description" class="form-control" name="description">{{ old('description', $categoryData->description ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">@lang('app.category.image'):</label>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <input type="hidden" name="uploaded_image" value="{{ old('uploaded_image') }}">
        @error('image')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror

    </div>

    <div class="mb-3">
        <label for="status" class="form-label"><strong>@lang('app.category.status'):<span class="text-danger">*</span></label>
        <div class="form-check form-switch">
            <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" role="switch"
                id="status" name="status" value="1"
                {{ (isset($categoryData) && $categoryData->status) || old('status') ? 'checked' : '' }}
                onchange="toggleStatusLabel()">
            <label class="form-check-label" for="status" id="statusLabel">
                {{ (isset($categoryData) && $categoryData->status) || old('status') ? 'Active' : 'Inactive' }}
            </label>
        </div>
        @error('status')
            <div class="form-text text-danger">{{ $message }}</div>
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
