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
            'route' => 'surat-masuk.index-ns',
            'icons' => ['active' => 'heroicon-s-inbox-arrow-down', 'inactive' => 'heroicon-o-inbox-arrow-down'],
        ],
        [
            'label' => 'Standar Prosedur Operasional',
            'key' => 'spo',
            'route' => 'spo.index-ns',
            'icons' => ['active' => 'heroicon-s-document-text', 'inactive' => 'heroicon-o-document-text'],
        ],
        [
            'label' => 'Regulasi',
            'key' => 'regulasi',
            'route' => 'regulasi.index-ns',
            'icons' => ['active' => 'heroicon-s-building-library', 'inactive' => 'heroicon-o-building-library'],
        ],
        [
            'label' => 'Perjanjian Kerja Sama',
            'key' => 'pks',
            'route' => 'pks.index-ns',
            'icons' => ['active' => 'heroicon-s-user-group', 'inactive' => 'heroicon-o-user-group'],
        ],
        [
            'label' => 'Informasi',
            'key' => 'informasi',
            'route' => 'informasi.index-ns',
            'icons' => [
                'active' => 'heroicon-s-chat-bubble-bottom-center-text',
                'inactive' => 'heroicon-o-chat-bubble-bottom-center-text',
            ],
        ],
        [
            'label' => 'Profil Akun',
            'key' => 'profil akun',
            'route' => 'user.atur-akun-ns',
            'icons' => [
                'active' => 'heroicon-s-user',
                'inactive' => 'heroicon-o-user',
            ],
        ],
    ];
@endphp

<div class="flex flex-col items-center py-4 space-y-1">
    <div class="p-2 mb-3">
        <img src="{{ asset('img/logo-cmi.png') }}" alt="Logo" class="h-10 w-auto">
    </div>

    @foreach ($menus as $menu)
        @php
            $isActive = isset($active) && $active === $menu['key'];
        @endphp

        <div class="sidebar-item w-full flex justify-center cursor-pointer relative">
            <a href="{{ route($menu['route']) }}"
                class="
                    flex justify-center items-center w-full py-3 border-l-4 transition-all duration-300
                    {{ $isActive
                        ? 'border-white bg-gradient-to-b from-emerald-600 to-emerald-700'
                        : 'border-transparent hover:bg-gradient-to-b hover:from-emerald-500 hover:to-emerald-600' }}
                ">
                <x-dynamic-component :component="$isActive ? $menu['icons']['active'] : $menu['icons']['inactive']"
                    class="w-6 h-6 text-white transition-transform duration-200 group-hover:scale-110" />
            </a>

            {{-- Tooltip placeholder --}}
            <span class="tooltip-sidebar hidden">{{ $menu['label'] }}</span>
        </div>
    @endforeach
    <div class="w-full flex justify-center mt-2">
        <button type="button" onclick="openLogoutModal()"
            class="w-8 h-8 flex items-center justify-center bg-red-600 hover:bg-red-700 text-white rounded transition-colors"
            title="Logout">
            <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6" />
        </button>
    </div>

</div>
