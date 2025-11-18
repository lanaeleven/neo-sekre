@props([
    'title' => '',
    'closeUrl' => '',
])
<div class="bg-white border-b border-gray-200 px-4 py-2 shadow-sm">
    <div class="flex items-center justify-between">

        <span class="text-gray-700 font-semibold tracking-wide">
            E-Sekre
        </span>

        <span class="text-gray-600 font-medium">
            {{ $title }}
        </span>

        <div>
            <x-button-with-tooltip size="md" variant="danger" tooltip="Tutup Form"
                url="{{ $closeUrl }}"><x-heroicon-o-x-mark class="w-4 h-4 stroke-4" /></x-button-with-tooltip>
        </div>

    </div>
</div>
