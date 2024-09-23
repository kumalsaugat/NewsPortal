<div class="container my-3">
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            <!-- Name Input -->
            <div class="mb-3">
                <label for="name" class="form-label">
                    <strong>@lang('app.category.name'):<span class="text-danger">*</span></strong>
                </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name"
                    value="{{ old('name', $categoryData->name ?? '') }}">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description Input -->
            <div class="mb-3">
                <label for="description" class="form-label">
                    <strong>@lang('app.category.desc'):</strong>
                </label>
                <textarea id="description" class="form-control" rows="4" name="description" placeholder="Enter description...">{{ old('description', $categoryData->description ?? '') }}</textarea>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
            <!-- Slug Input -->
            <div class="mb-3">
                <label for="slug" class="form-label">
                    <strong>@lang('app.category.slug'):<span class="text-danger">*</span></strong>
                </label>
                <input type="text" class="form-control" id="slug" name="slug" placeholder="will be auto generated if left empty"
                    value="{{ old('slug', $categoryData->slug ?? '') }}">
                @error('slug')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label"><strong>@lang('app.category.image'):</strong></label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <input type="hidden" name="uploaded_image" value="{{ old('uploaded_image') }}">
                @error('image')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Status Toggle -->
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="status" class="form-label">
                    <strong>@lang('app.category.status'):<span class="text-danger">*</span></strong>
                </label>
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
