@props([
    'subTitle' => '',
    'title' => '',
    'twoRowsTitle' => false,
    'total' => 0,
    'url' => '#',
    'headerColor' => '#fff',
    'bodyColor' => '#fff',
    'buttonColor' => '#fff',
    'buttonHoverColor' => '#fff',
])

<div class="card shadow-sm" style="background-color: {{ $bodyColor }};">
    <div class="d-flex justify-content-between card-header" style="min-height: 60px; background-color: {{ $headerColor }};">
        <div>
            @if ($twoRowsTitle)
                <span class="fs-6 d-block" style="line-height: 1.0;">{{ $subTitle }}</span>
            @endif
            <span class="fs-5 fw-semibold d-block" style="line-height: 1.3;">{{ $title }}</span>
        </div>
    </div>
    <div class="card-body py-2">
        <h1 class="fw-semibold text-center m-0" style="font-size: 70px;">
            {{ $total }}
        </h1>
    </div>
    <a href="{{ $url }}" class="btn btn-success"
        style="border-top-left-radius: 0; border-top-right-radius: 0; border-bottom-left-radius: 0.25rem; border-bottom-right-radius: 0.25rem;background-color: {{ $buttonColor }}; color: white; border: none;"
        onmouseover="this.style.backgroundColor='{{ $buttonHoverColor }}';" onmouseout="this.style.backgroundColor='{{ $buttonColor }}';">Lihat
        Selengkapnya</a>
</div>
