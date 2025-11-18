@props([
    'status' => '',
])

<td class="border-b border-gray-200 px-4 py-2">
    <span
        class="text-xs font-medium
            @if ($status === 'Diarsipkan') text-green-700 bg-green-100
            @elseif($status === 'Belum Diteruskan') text-red-700 bg-red-100
            @else text-blue-700 bg-blue-100 @endif
            px-2 py-1 rounded">
        {{ $status }}
    </span>
</td>
