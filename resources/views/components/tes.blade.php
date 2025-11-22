@props(['id', 'name', 'label' => 'Label', 'options' => [], 'selected' => [], 'required' => false])

<div class="col-span-full">
    <label for="{{ $id }}" class="block text-sm font-medium leading-6 text-gray-900">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    {{-- Tombol Pilih Semua --}}
    <div class="flex items-center gap-2 mt-2">
        <button type="button" id="{{ $id }}-select-all"
            class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">
            Pilih Semua
        </button>

        <button type="button" id="{{ $id }}-clear"
            class="px-2 py-1 text-xs bg-gray-400 text-white rounded hover:bg-gray-500">
            Hapus Pilihan
        </button>
    </div>

    <select name="{{ $name }}[]" id="{{ $id }}" multiple @required($required)
        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 h-40">
        @foreach ($options as $opt)
            <option value="{{ $opt['value'] }}" @selected(in_array($opt['value'], $selected))>
                {{ $opt['label'] }}
            </option>
        @endforeach
    </select>
</div>

{{-- Script untuk select all --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const select = document.getElementById("{{ $id }}");
        const btnSelectAll = document.getElementById("{{ $id }}-select-all");
        const btnClear = document.getElementById("{{ $id }}-clear");

        btnSelectAll.addEventListener("click", () => {
            [...select.options].forEach(opt => opt.selected = true);
        });

        btnClear.addEventListener("click", () => {
            [...select.options].forEach(opt => opt.selected = false);
        });
    });
</script>
