@props([
    'name' => '',
    'id' => '',
    'optionLabelDefault' => '',
    'options' => [],
])

<div class="flex items-center">
    <select name="{{ $name }}" id="{{ $id }}"
        class="
                            border border-gray-300 rounded-md
                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                            text-sm text-gray-700
                            px-2 py-1 bg-white
                            w-[140px]
                        ">
        <option value="">{{ $optionLabelDefault }}</option>

        @foreach ($options as $opt)
            <option value="{{ $opt->id }}" {{ request($name) == $opt->id ? 'selected' : '' }}>
                {{ $opt->label }}
            </option>
        @endforeach
    </select>
</div>
