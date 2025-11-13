@props([
    'title' => 'button',
    'tooltip' => 'tooltip',
    'url' => '/',
    'target' => '_self',
])

<div class="relative group inline-block">
    <a href="{{ $url }}" target="{{ $target }}"
        class="bg-blue-500 hover:bg-blue-700 text-white text-sm py-1 px-2 rounded">{{ $title }}</a>
    <span
        class="absolute invisible group-hover:visible opacity-0 group-hover:opacity-100
                 bg-gray-800 text-white text-sm rounded-md px-2 py-1 transition-opacity duration-0
                 top-full mt-2 left-1/2 -translate-x-1/2 whitespace-nowrap z-5">
        {{ $tooltip }}
    </span>
</div>
