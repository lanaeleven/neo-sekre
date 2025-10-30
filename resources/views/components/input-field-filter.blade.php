@props([
    'isLabel' => false,
    'label' => 'default label',
    'name' => 'defaultName',
    'type' => 'text',
    'placeholder' => 'default placeholder',
    'isSmall' => false,
    'isMedium' => false,
])

@if ($isLabel)
    <div class="col-auto">
        <label for="{{ $name }}" class="col-form-label"><small>{{ $label }} :</small></label>
    </div>
@endif
<div class="col-auto">
    <input name="{{ $name }}" type="{{ $type }}" id="{{ $name }}"
        class="form-control form-control-sm" placeholder="{{ ucwords($placeholder) }}" value="{{ request($name) }}"
        @if ($isSmall) style="width: 70px" @endif
        @if ($isMedium) style="width: 100px" @endif
        >
</div>
