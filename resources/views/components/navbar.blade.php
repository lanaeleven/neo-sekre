@props([
    'title' => '',
    'urlTambah' => '#',
])
<div class="bg-white border-b border-gray-200 px-4 py-2 shadow-sm flex items-center justify-between">
    <button id="openMenu" class="md:hidden text-gray-700 text-xl">
        ☰
    </button>
    <span class="hidden md:block  text-green-700 font-semibold tracking-wide">
        E-Sekre
    </span>
    <span class="text-gray-600 font-medium ">
        {{ $title }}
    </span>
    <div class="hidden md:block">
        <x-button-with-link title="Buat Baru" url="{{ $urlTambah }}" variant="success" />
    </div>
    <button id="openFilter" class="md:hidden text-green-700 px-2 py-1 rounded border ml-2">
        <x-heroicon-o-adjustments-horizontal class="w-6 h-6 text-green-700" />
    </button>
</div>
