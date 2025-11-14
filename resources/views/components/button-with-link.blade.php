@props([
    'title' => 'Button',
    'url' => '/',
    'variant' => 'primary',
])

@php
    $variants = [
        // Biru elegan
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm 
                      hover:shadow-md transition-all duration-200',

        // Hijau elegant gradient
        'success' => 'bg-gradient-to-r from-green-600 to-green-700 text-white 
                      hover:from-green-700 hover:to-green-800 shadow-sm hover:shadow-md duration-200',

        // Merah
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-sm 
                     hover:shadow-md duration-200',

        // Kuning/amber
        'warning' => 'bg-amber-400 hover:bg-amber-500 text-black shadow-sm 
                      hover:shadow-md duration-200',

        // Info (cyan)
        'info' => 'bg-cyan-500 hover:bg-cyan-600 text-white shadow-sm 
                   hover:shadow-md duration-200',

        // Dark
        'dark' => 'bg-gray-800 hover:bg-black text-white shadow-sm 
                   hover:shadow-md duration-200',

        // Light
        'light' => 'bg-gray-200 hover:bg-gray-300 text-black shadow-sm 
                    hover:shadow-md duration-200',
    ];

    $btnClass = $variants[$variant] ?? $variants['primary'];
@endphp

<a href="{{ $url }}" class="px-3 py-1.5 rounded text-sm {{ $btnClass }}">
    {{ $title }}
</a>
