@props(['filePath' => '#', 'fileName' => '#'])
<div class="pb-1 mb-1 border-b border-gray-200">
    <div class="text-sm">File Surat: <x-button-with-tooltip variant="light" tooltip="Lihat"
            url="{{ asset('storage/' . $filePath) }}" target="_blank"><x-heroicon-s-eye
                class="w-4 h-4" /></x-button-with-tooltip></div>
    <div class="text-sm">
        {{ $fileName }}
    </div>
</div>
