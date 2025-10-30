@props([
    'title' => 'default title',
    'backUrl' => '/',
])
<div class="d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ $backUrl }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
    </div>
    <div>
        <h3 class="fw-semibold fs-4 text-center">{{ strtoupper($title) }}</h3>
    </div>
    <div>
    </div>
</div>
