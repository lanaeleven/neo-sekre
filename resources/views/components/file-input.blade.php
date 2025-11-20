@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'required' => false,
])

<label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
    {{ $label }}
</label>
<div class="mt-2">
    <input type="file" name="{{ $name }}" id="{{ $id }}"
        @if ($required) required @endif
        class="p-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer 
                   bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                   @error('{{ $name }}') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">

    @error('{{ $name }}')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
