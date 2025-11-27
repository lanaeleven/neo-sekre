@props([
    'title' => 'Judul',
    'value' => '0',
    'icon' => null, // contoh: heroicon-s-inbox

    // preset warna: blue, green, red, yellow, purple, gray
    'color' => 'blue',

    'dateText' => 'Hari ini',
    'link' => '#',
    'linkText' => 'Lihat selengkapnya',
    'linkJustify' => 'end',

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
            'title' => 'text-base',
            'value' => 'text-4xl',
            'link' => 'text-sm',
        ],
        'small' => [
            'title' => 'text-sm',
            'value' => 'text-2xl',
            'link' => 'text-xs',
        ],
    ];

    // fallback ke normal jika size tidak valid
    $text = $sizePresets[$size] ?? $sizePresets['normal'];
@endphp

<div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 border border-gray-100">
    <div class="flex items-center justify-between">

        {{-- ICON AREA --}}
        <div class="{{ $preset['bg'] }} {{ $preset['icon'] }} p-3 rounded-xl">
            @if ($icon)
                <x-dynamic-component :component="$icon" class="w-7 h-7" />
            @endif
        </div>

        <span class="text-xs font-medium text-gray-400">{{ $dateText }}</span>
    </div>

    <h4 class="{{ $text['title'] }} text-gray-600 mt-4">{{ $title }}</h4>
    <p class="{{ $text['value'] }} font-bold text-gray-800">{{ $value }}</p>

    <div class="flex items-center justify-{{ $linkJustify }}">
        <a href="{{ $link }}"
            class="mt-3 {{ $text['link'] }} text-slate-700 font-semibold hover:underline hover:text-slate-900 transition">
            {{ $linkText }}
        </a>
    </div>
</div>
