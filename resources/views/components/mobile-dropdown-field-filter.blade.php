@props([
    'name' => '',
    'optionLabelDefault' => '',
    'options' => [],
])
<div class="w-fit">
    <select name="{{ $name }}"
        class="rounded border border-gray-300 bg-white px-2 py-1 text-xs text-gray-700 focus:border-blue-500 focus:ring-blue-500"
        value="{{ request($name) }}">
        <option value="">{{ $optionLabelDefault }}</option>
        @foreach ($options as $o)
            <option value="{{ $o->id }}" {{ request($name) == $o->id ? 'selected' : '' }}>
                {{ $o->label }}
            </option>
        @endforeach
    </select>
</div>
