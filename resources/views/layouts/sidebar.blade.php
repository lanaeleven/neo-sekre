@php
    $menus = [
        [
            'label' => 'Dashboard',
            'key' => 'dashboard',
            'route' => 'dashboard',
            'icons' => ['active' => 'heroicon-s-home', 'inactive' => 'heroicon-o-home'],
        ],
        [
            'label' => 'Surat Masuk',
            'key' => 'surat masuk',
            'route' => 'surat-masuk.index',
            'icons' => ['active' => 'heroicon-s-inbox', 'inactive' => 'heroicon-o-inbox'],
        ],
        [
            'label' => 'Surat Keluar',
            'key' => 'surat keluar',
            'route' => 'surat-keluar.index',
            'icons' => ['active' => 'heroicon-s-paper-airplane', 'inactive' => 'heroicon-o-paper-airplane'],
        ],
    ];
@endphp

<div class="flex flex-col items-center py-4 space-y-2">
    <div class="p-2 mb-3">
        <img src="{{ asset('assets/logo-cmi.png') }}" alt="Logo" class="h-10 w-auto">
    </div>

    @foreach ($menus as $menu)
        @php
            $isActive = isset($active) && $active === $menu['key'];
        @endphp

        <a href="{{ route($menu['route']) }}"
            class="group relative flex justify-center items-center w-full py-3 border-l-4 transition-all
                  {{ $isActive ? 'border-white bg-green-700' : 'border-transparent hover:bg-green-700' }}">
            <x-dynamic-component :component="$isActive ? $menu['icons']['active'] : $menu['icons']['inactive']"
                class="w-6 h-6 text-white transition-transform duration-200 group-hover:scale-110" />
        </a>
    @endforeach
</div>
