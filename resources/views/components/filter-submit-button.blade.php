@props([
    'title' => 'Cari',
])

<div>
    <button type="submit"
        class="cursor-pointer inline-flex items-center justify-center
               bg-gray-800 hover:bg-black text-white shadow-sm 
                   hover:shadow-md duration-200
               rounded-md
               px-2.5 py-1.5
               text-sm transition-colors">
        {{ $title }}
    </button>
</div>
