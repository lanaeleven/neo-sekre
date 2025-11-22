@props([
    'urlFilter' => '#',
])
<div id="filter-box" class="hidden md:flex justify-center bg-gray-50 border-b border-gray-200 py-2 px-2">
    <form
        class=" grid grid-cols-1 sm:grid-cols-2 md:flex md:flex-wrap md:justify-center items-center gap-1 text-xs w-full max-w-5xl"
        action="{{ $urlFilter }}">
        {{ $slot }}
        <x-submit-button-with-tooltip tooltip="Cari" variant="dark">
            <x-heroicon-s-magnifying-glass class="w-4 h-4" />
        </x-submit-button-with-tooltip>
    </form>
</div>
