@props([
    'title' => 'button',
    'url' => '/',
])

<a href={{ $url }} class="bg-blue-500 hover:bg-blue-700 text-white text-sm py-1 px-2 rounded">
    {{ $title }}
</a>
