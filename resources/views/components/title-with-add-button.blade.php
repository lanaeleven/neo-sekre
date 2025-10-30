@props([
    'title' => 'default title',
    'addUrl' => '/',
])
<div class="d-flex justify-content-between align-items-center my-2">
    <div>
    </div>
    <div>
        <h3 class="fw-semibold fs-4 text-center">{{ strtoupper($title) }}</h3>
    </div>
    <div>
        <a href="{{ $addUrl }}" class="btn btn-primary btn-sm">Tambah</a>
    </div>
</div>
