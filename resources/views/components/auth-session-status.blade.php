@props(['status'])

@if ($status)
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $status }}
</div>
@endif
