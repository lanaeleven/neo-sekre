@props(['name' => 'surat', 'value' => 'value', 'urlName' => 'url-name'])
<div class="h-16 w-full bg-white rounded-lg transition p-2 border border-gray-300 flex justify-center items-center">
    <form action="/{{ $urlName }}/buka-arsip" method="post" id="bukaArsipForm"
        class="flex justify-center items-center">
        @csrf
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        <x-green-submit-button-option-form formId="bukaArsipForm">
            Buka Arsip
        </x-green-submit-button-option-form>
    </form>
</div>
