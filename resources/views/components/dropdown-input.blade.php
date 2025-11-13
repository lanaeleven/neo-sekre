@props([
    'id',
    'name',
    'label',
    'labelPilihan' => 'Pilih salah satu',
    'options' => [],
    'selectedId' => null, // <--- ini membuatnya opsional
    'required' => false,
])

<div class="sm:col-span-3">
    <label for="{{ $id }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $label }}</label>
    <div class="mt-2">
        <select id="{{ $id }}" name="{{ $name }}" autocomplete="country-name"
            @if ($required) required @endif
            class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
            <option value="">{{ $labelPilihan }}</option>
            @foreach ($options as $option)
                <option value="{{ $option->id }}" @if ($selectedId == $option->id) selected @endif>{{ $option->nama }}
                </option>
            @endforeach
        </select>
    </div>
</div>
