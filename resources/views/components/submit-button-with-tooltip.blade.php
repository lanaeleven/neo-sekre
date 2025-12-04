@props([
    'tooltip' => 'Tooltip',
    'variant' => 'primary',
    'size' => 'sm',
    'type' => 'submit',
])

@php
    // Variants
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md',
        'success' =>
            'bg-gradient-to-r from-green-600 to-green-700 text-white hover:from-green-700 hover:to-green-800 shadow-sm hover:shadow-md',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-sm hover:shadow-md',
        'warning' => 'bg-amber-400 hover:bg-amber-500 text-black shadow-sm hover:shadow-md',
        'info' => 'bg-cyan-500 hover:bg-cyan-600 text-white shadow-sm hover:shadow-md',
        'dark' => 'bg-gray-800 hover:bg-black text-white shadow-sm hover:shadow-md',
        'light' => 'bg-gray-200 hover:bg-gray-300 text-black shadow-sm hover:shadow-md',
    ];

    // Sizes
    $sizes = [
        'sm' => 'text-xs px-1 py-1',
        'md' => 'text-sm px-1.5 py-1.5',
        'lg' => 'text-base px-2 py-2',
    ];

    $btnClass = ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<div class="relative group inline-block">
    <button type="{{ $type }}"
        class="cursor-pointer rounded transition-all duration-200 flex items-center justify-center {{ $btnClass }}">
        <span class="flex items-center">
            {{ $slot }}
        </span>
    </button>

    {{-- Tooltip --}}
    <span
        class="absolute invisible group-hover:visible opacity-0 group-hover:opacity-100
               bg-gray-800 text-white text-xs rounded-md px-2 py-1 transition-opacity duration-200
               top-full mt-2 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-lg z-50">
        {{ $tooltip }}
    </span>
</div>
