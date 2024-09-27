<div class="card-body">
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            {{-- Username Field --}}
            <div class="mb-3">
                <label for="name" class="form-label"><strong>@lang('app.user.name'):<span class="text-danger">*</span></strong></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                    value="{{ old('name', $userData->name ?? '') }}">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password Field --}}
            @if (!$isEdit)
                <div class="mb-3">
                    <label for="password" class="form-label"><strong>@lang('app.user.password'):<span class="text-danger">*</span></strong></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                    @error('password')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            {{-- Phone Field --}}
            <div class="mb-3">
                <label for="phone" class="form-label"><strong>@lang('app.user.phone'):<span class="text-danger">*</span></strong></label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone"
                    value="{{ old('phone', $userData->phone ?? '') }}">
                @error('phone')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
            {{-- Email Field --}}
            <div class="mb-3">
                <label for="email" class="form-label"><strong>@lang('app.user.email'):<span class="text-danger">*</span></strong></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                    value="{{ old('email', $userData->email ?? '') }}" @if(isset($userData)) readonly @endif>
                @error('email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image Field --}}
            <div class="mb-3">
                <label for="image" class="form-label"><strong>@lang('app.user.image'):</strong></label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                @error('image')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Full Width: Status Field -->
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="status" class="form-label">
                    <strong>@lang('app.news.status'):<span class="text-danger"> *</span></strong>
                </label>
                <div class="form-check form-switch">
                    <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" role="switch"
                        id="status" name="status" value="1"
                        {{ (isset($userData) && $userData->status) || old('status') ? 'checked' : '' }}
                        onchange="toggleStatusLabel()" >
                    <label class="form-check-label" for="status" id="statusLabel">
                        {{ (isset($userData) && $userData->status) || old('status') ? 'Active' : 'Inactive' }}
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
