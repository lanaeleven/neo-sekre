@props([
    'urlFilter' => '#',
    'withAddOption' => false,
    'addOptionUrl' => '#',
])

<div id="filterDrawer" class="fixed inset-0 bg-black/30 backdrop-blur-sm hidden z-40 md:hidden">

    <div class="w-full max-w-sm bg-white h-full shadow-xl p-4 animate-slideInRight ml-auto">
        @if ($withAddOption)
            <x-button-with-tooltip variant="success" tooltip="Buat Baru" url="{{ $addOptionUrl }}">Buat
                Baru</x-button-with-tooltip>
        @endif
        <h2 class="text-lg font-semibold mb-4 text-green-700 flex justify-between">
            Filter
            <button id="closeFilter" class="text-gray-600 text-xl leading-none">×</button>
        </h2>
        <form class="grid grid-cols-1 gap-2 text-xs" action="{{ $urlFilter }}">
            {{ $slot }}
            <x-filter-submit-button />

        </form>
    </div>
</div>
