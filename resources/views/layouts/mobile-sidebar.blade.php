@php
    $menus = [
        [
            'label' => 'Dashboard',
            'key' => 'dashboard',
            'route' => 'dashboard',
        ],
        [
            'label' => 'Surat Masuk',
            'key' => 'surat masuk',
            'route' => 'surat-masuk.index',
        ],
        [
            'label' => 'Surat Izin',
            'key' => 'surat izin',
            'route' => 'surat-izin.index',
        ],
        [
            'label' => 'Surat Keluar',
            'key' => 'surat keluar',
            'route' => 'surat-keluar.index',
        ],
        [
            'label' => 'Standar Prosedur Operasional',
            'key' => 'spo',
            'route' => 'spo.index',
        ],
        [
            'label' => 'Regulasi',
            'key' => 'regulasi',
            'route' => 'regulasi.index',
        ],
        [
            'label' => 'Perjanjian Kerja Sama',
            'key' => 'pks',
            'route' => 'pks.index',
        ],
        [
            'label' => 'Informasi',
            'key' => 'informasi',
            'route' => 'informasi.index',
        ],
    ];
@endphp

<!-- MOBILE SIDEBAR OVERLAY -->
<div id="mobileSidebar" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 lg:hidden">

    <!-- SIDEBAR -->
    <div class="w-72 bg-white h-full shadow-2xl p-5 rounded-r-2xl flex flex-col animate-[slideIn_0.3s_ease-out]">

        <h2 class="font-semibold mb-5 text-green-700 text-lg tracking-wide">
            Menu
        </h2>

        <!-- LIST MENU -->
        <div class="space-y-2 flex-1">
            @foreach ($menus as $menu)
                @php
                    $isActive = isset($active) && $active === $menu['key'];
                @endphp

                <a href="{{ route($menu['route']) }}"
                    class="
                        block px-4 py-2.5 rounded-lg transition-all text-sm
                        hover:bg-green-50 hover:text-green-700
                        {{ $isActive ? 'bg-green-100 text-green-700 font-semibold shadow-sm' : 'text-gray-700' }}
                    ">
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </div>

        <div class="text-center">
            <span class="text-sm text-gray-600">
                {{ auth()->user()->nama }}
            </span>
        </div>
        <!-- LOGOUT BUTTON -->
        <button type="button" onclick="openLogoutModal()"
            class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded text-sm transition-colors">
            Logout
        </button>
    </div>
</div>

<!-- ANIMATION -->
<style>
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
