@props([
    'title' => 'Cari',
])

<div>
    <button type="submit"
        class="inline-flex items-center justify-center
               bg-gray-600 hover:bg-gray-700
               text-white rounded-md
               px-2.5 py-1.5
               text-sm transition-colors duration-150">
        {{ $title }}
    </button>
</div>
