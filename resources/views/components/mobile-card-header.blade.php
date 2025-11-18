@props([
    'title1' => '',
    'title2' => '',
])
<div class="flex justify-between">
    <span class="text-xs text-gray-400">{{ $title1 }}</span>
    <span class="font-medium">{{ $title2 }}</span>
</div>
