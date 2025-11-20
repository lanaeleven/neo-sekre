@props([
    'id' => '',
    'label' => '',
    'fileName' => '',
    'filePath' => '',
])

<label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
    {{ $label }}
</label>

<div class="mt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between">
    {{-- Nama File --}}
    <div class="text-sm text-gray-800 truncate">
        {{ $fileName }}
    </div>

    {{-- Tombol Aksi --}}
    <div class="mt-2 sm:mt-0 flex gap-2">
        <x-button-with-tooltip tooltip="" url="{{ asset('storage/' . $filePath) }}"
            target="_blank">Lihat</x-button-with-tooltip>
    </div>
</div>
