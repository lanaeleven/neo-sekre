<div>

    {{-- DESKTOP / TABLET (md ke atas) --}}
    <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{ $desktop ?? $slot }}
    </div>

    {{-- MOBILE (di bawah md) --}}
    <div class="md:hidden px-2 space-y-2 mt-2 overflow-y-auto flex-1">
        {{ $mobile ?? $slot }}
    </div>

</div>
