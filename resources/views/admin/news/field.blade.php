<div class="container my-3">
    <div class="row">

        <!-- Left Column -->
        <div class="col-md-6">
            <!-- Title Input -->
            <div class="mb-3">
                <label for="title" class="form-label">
                    <strong>@lang('app.news.title'):<span class="text-danger"> *</span></strong>
                </label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title"
                    value="{{ old('title', $newsData->title ?? '') }}">
                @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category Selection -->
            <div class="form-group mb-3">
                <label for="category_id" class="form-label">
                    <strong>@lang('app.news.category'):<span class="text-danger"> *</span></strong>
                </label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $newsData->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
            <!-- Slug Input -->
            <div class="mb-3">
                <label for="slug" class="form-label">
                    <strong>@lang('app.news.slug'):<span class="text-danger"> *</span></strong>
                </label>
                <input type="text" class="form-control" id="slug" name="slug"
                    placeholder="will be auto generated if left empty"
                    value="{{ old('slug', $newsData->slug ?? '') }}">
                @error('slug')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label"><strong>@lang('app.news.image'):</strong></label>
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

    <!-- Full-width Description Column -->
    <div class="row">
        <div class="col-12">
            <!-- Description Input -->
            <div class="mb-3">
                <label for="description" class="form-label">
                    <strong>@lang('app.news.desc'):<span class="text-danger"> *</span></strong>
                </label>
                <textarea id="description" class="form-control" name="description" placeholder="Enter description...">{{ old('description', $newsData->description ?? '') }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Published Date and Status -->
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-6">
                <!-- Published At -->
                <div class="form-group">
                    <label for="published_at" class="form-label">
                        <strong>@lang('app.news.publish'):<span class="text-danger"> *</span></strong>
                    </label>
                    <input type="datetime-local" name="published_at" class="form-control" id="published_at"
                        value="{{ old('published_at', isset($newsData->published_at) ? $newsData->published_at->format('Y-m-d\TH:i') : '') }}">
                    @error('published_at')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Status Toggle -->
            <div class="mb-3">
                <label for="status" class="form-label">
                    <strong>@lang('app.news.status'):<span class="text-danger"> *</span></strong>
                </label>
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

    document.addEventListener('DOMContentLoaded', (event) => {
        toggleStatusLabel();
    });
</script>
