@props([
    'text' => '',
])
<div class="mt-2">
    <span
        class="text-xs px-2 py-1 rounded
        @if ($text === 'Diarsipkan') text-green-700 bg-green-100
        @elseif($text === 'Belum Diteruskan') text-red-700 bg-red-100
         @else text-blue-700 bg-blue-100 @endif">
        {{ $text }}
    </span>
</div>
