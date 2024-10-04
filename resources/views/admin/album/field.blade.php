<div class="container my-3">
    <div class="row">

        <!-- Left Column -->
        <div class="col-md-8">
            <!-- Title Input -->
            <div class="mb-3">
                <label for="title" class="form-label">
                    <strong>@lang('app.album.title'):<span class="text-danger"> *</span></strong>
                </label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title"
                    value="{{ old('title', $albumData->title ?? '') }}">
                @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Slug Input -->
            <div class="mb-3">
                <label for="slug" class="form-label">
                    <strong>@lang('app.album.slug'):<span class="text-danger"> *</span></strong>
                </label>
                <input type="text" class="form-control" id="slug" name="slug"
                    placeholder="will be auto generated if left empty" value="{{ old('slug', $albumData->slug ?? '') }}">
                @error('slug')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <!-- Date Input -->
            <div class="mb-3">
                <label for="date" class="form-label"><strong>@lang('app.album.date'):<span class="text-danger"> *</span></strong></label>
                <input type="datetime-local" onclick="this.showPicker()" class="form-control" id="date" name="date"
                    value="{{ old('date', $albumData->date ?? '') }}">
                @error('date')
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
                    <strong>@lang('app.album.desc'):</strong>
                </label>
                <textarea id="description" class="form-control" name="description" placeholder="Enter description...">{{ old('description', $albumData->description ?? '') }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>


    <!-- Image Upload -->
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label for="image" class="form-label"><strong>@lang('app.album.image'):</strong></label>
                <input type="file" class="form-control" id="image" name="image[]" multiple data-max-files="5">
                <input type="hidden" name="uploaded_images" value="{{ old('uploaded_images') }}">
                @error('image')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
`   </div>

    <!-- Status Toggle -->
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="status" class="form-label">
                    <strong>@lang('app.album.status'):<span class="text-danger"> *</span></strong>
                </label>
                <div class="form-check form-switch">
                    <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" role="switch"
                        id="status" name="status" value="1"
                        {{ (isset($albumData) && $albumData->status) || old('status') ? 'checked' : '' }}
                        onchange="toggleStatusLabel()">
                    <label class="form-check-label" for="status" id="statusLabel">
                        {{ (isset($albumData) && $albumData->status) || old('status') ? 'Active' : 'Inactive' }}
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
