@props([
    'title' => 'Judul',
    'description' => '0',
    'icon' => null, // contoh: heroicon-s-inbox

    // preset warna: blue, green, red, yellow, purple, gray
    'color' => 'blue',
    'link' => '#',

    // ukuran teks: normal | small
    'size' => 'normal',
])

@php
    // PRESET WARNA
    $colorPresets = [
        'blue' => ['bg' => 'bg-blue-100', 'icon' => 'text-blue-600'],
        'green' => ['bg' => 'bg-green-100', 'icon' => 'text-green-600'],
        'red' => ['bg' => 'bg-red-100', 'icon' => 'text-red-600'],
        'yellow' => ['bg' => 'bg-yellow-100', 'icon' => 'text-yellow-600'],
        'purple' => ['bg' => 'bg-purple-100', 'icon' => 'text-purple-600'],
        'gray' => ['bg' => 'bg-gray-100', 'icon' => 'text-gray-600'],
    ];

    // fallback jika warna tidak ada
    $preset = $colorPresets[$color] ?? $colorPresets['blue'];

    // PRESET UKURAN TEXT
    $sizePresets = [
        'normal' => [
            'title' => 'text-2xl',
            'value' => 'text-base',
            'link' => 'text-sm',
        ],
        'small' => [
            'title' => 'text-2xl',
            'value' => 'text-sm',
            'link' => 'text-xs',
        ],
    ];

    // fallback ke normal jika size tidak valid
    $text = $sizePresets[$size] ?? $sizePresets['normal'];
@endphp

<a class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 border border-gray-100" href="{{ $link }}">
    <div class="flex items-center justify-between">
        <h4 class="{{ $text['title'] }} font-bold text-gray-800 ">{{ $title }}</h4>

        {{-- ICON AREA --}}
        <div class="{{ $preset['bg'] }} {{ $preset['icon'] }} p-3 rounded-xl">
            @if ($icon)
                <x-dynamic-component :component="$icon" class="w-7 h-7" />
            @endif
        </div>
    </div>

    <p class="{{ $text['value'] }} text-gray-600 mt-4">{{ $description }}</p>
</a>
