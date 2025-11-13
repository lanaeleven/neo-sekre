@props([
    'isLabel' => false,
    'label' => 'default label',
    'name' => 'defaultName',
    'type' => 'text',
    'placeholder' => 'default placeholder',
    'isSmall' => false,
    'isMedium' => false,
    'isMediumUp' => false,
])

<div class="flex items-center">
    @if ($isLabel)
        <label for="{{ $name }}" class="text-sm text-gray-700">
            {{ $label }} :
        </label>
    @endif

    <input name="{{ $name }}" id="{{ $name }}" type="{{ $type }}" value="{{ request($name) }}"
        placeholder="{{ ucwords($placeholder) }}"
        class="
            border border-gray-300 rounded-md
            focus:ring-2 focus:ring-blue-500 focus:border-blue-500
            text-sm text-gray-700 placeholder-gray-400
            px-2 py-1
            @if ($isSmall) w-[70px] @elseif($isMedium) w-[100px] @elseif($isMediumUp) w-[120px] @else w-[180px] @endif
        ">
</div>
