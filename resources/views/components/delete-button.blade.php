@props([
    'tooltip' => 'Hapus',
    'url' => '/',
    'variant' => 'danger',
    'size' => 'sm',
    'confirmTitle' => 'Hapus Data?',
    'confirmMessage' => 'Data yang dihapus tidak dapat dikembalikan. Apakah kamu yakin ingin melanjutkan?',
])

@php
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md',
        'success' => 'bg-gradient-to-r from-green-600 to-green-700 text-white hover:from-green-700 hover:to-green-800 shadow-sm hover:shadow-md',
        'danger'  => 'bg-red-600 hover:bg-red-700 text-white shadow-sm hover:shadow-md',
        'warning' => 'bg-amber-400 hover:bg-amber-500 text-black shadow-sm hover:shadow-md',
        'info'    => 'bg-cyan-500 hover:bg-cyan-600 text-white shadow-sm hover:shadow-md',
        'dark'    => 'bg-gray-800 hover:bg-black text-white shadow-sm hover:shadow-md',
        'light'   => 'bg-gray-200 hover:bg-gray-300 text-black shadow-sm hover:shadow-md',
    ];

    $sizes = [
        'sm' => 'text-xs px-1 py-1',
        'md' => 'text-sm px-1.5 py-1.5',
        'lg' => 'text-base px-2 py-2',
    ];

    $btnClass = ($variants[$variant] ?? $variants['danger']) . ' ' . ($sizes[$size] ?? $sizes['sm']);
    $uniqueId  = uniqid();
    $formId    = 'delete-form-' . $uniqueId;
    $modalId   = 'delete-modal-' . $uniqueId;
@endphp

{{-- Hidden DELETE form --}}
<form id="{{ $formId }}" action="{{ $url }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- Trigger Button --}}
<div class="relative group inline-block">
    <button type="button"
        onclick="document.getElementById('{{ $modalId }}').classList.remove('hidden')"
        class="rounded transition-all duration-200 flex items-center justify-center cursor-pointer {{ $btnClass }}">
        <span class="flex items-center">
            {{ $slot }}
        </span>
    </button>

    {{-- Tooltip --}}
    <span class="absolute invisible group-hover:visible opacity-0 group-hover:opacity-100
                 bg-gray-800 text-white text-xs rounded-md px-2 py-1 transition-opacity duration-200
                 top-full mt-2 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-lg z-50">
        {{ $tooltip }}
    </span>
</div>

{{-- Modal Konfirmasi --}}
<div id="{{ $modalId }}"
     class="hidden fixed inset-0 z-50 flex items-center justify-center"
     onclick="if(event.target === this) this.classList.add('hidden')">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">

        {{-- Header --}}
        <div class="bg-red-50 px-6 pt-6 pb-4 flex flex-col items-center text-center">
            {{-- Icon --}}
            <div class="bg-red-100 text-red-600 rounded-full p-3 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9 3a1 1 0 00-1 1H5a1 1 0 000 2h1v12a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-3a1 1 0 00-1-1H9zm0 2h6v1H9V5zM7 8h10v10H7V8zm3 2a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1zm4 0a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
            </div>

            {{-- Title --}}
            <h3 class="text-lg font-bold text-gray-800">{{ $confirmTitle }}</h3>
        </div>

        {{-- Body --}}
        <div class="px-6 py-4 text-center">
            <p class="text-sm text-gray-500 leading-relaxed">{{ $confirmMessage }}</p>
        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6 flex gap-3">
            {{-- Batal --}}
            <button type="button"
                onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')"
                class="flex-1 px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition-all duration-200">
                Batal
            </button>

            {{-- Hapus --}}
            <button type="button"
                onclick="document.getElementById('{{ $formId }}').submit()"
                class="flex-1 px-4 py-2 rounded-lg text-sm font-medium bg-red-600 hover:bg-red-700 text-white shadow-sm transition-all duration-200">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>