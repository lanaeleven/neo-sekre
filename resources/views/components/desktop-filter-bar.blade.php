@props([
    'urlFilter' => '#',
])
<div id="filter-box" class="hidden md:flex justify-center bg-gray-50 border-b border-gray-200 py-2 px-2">
    <form class="grid grid-cols-1 sm:grid-cols-2 md:flex md:flex-wrap gap-1 text-xs w-full max-w-4xl"
        action="{{ $urlFilter }}">
        {{ $slot }}
        <x-filter-submit-button />
    </form>
</div>
