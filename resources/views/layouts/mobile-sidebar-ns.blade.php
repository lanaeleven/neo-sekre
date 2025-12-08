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
            'route' => 'surat-masuk.index-ns',
        ],
        [
            'label' => 'Surat Izin',
            'key' => 'surat izin',
            'route' => 'surat-izin.index-ns',
        ],
        [
            'label' => 'Standar Prosedur Operasional',
            'key' => 'spo',
            'route' => 'spo.index-ns',
        ],
        [
            'label' => 'Regulasi',
            'key' => 'regulasi',
            'route' => 'regulasi.index-ns',
        ],
        [
            'label' => 'Perjanjian Kerja Sama',
            'key' => 'pks',
            'route' => 'pks.index-ns',
        ],
        [
            'label' => 'Informasi',
            'key' => 'informasi',
            'route' => 'informasi.index-ns',
        ],
        [
            'label' => 'Profil Akun',
            'key' => 'profil akun',
            'route' => 'user.atur-akun-ns',
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

        <!-- LOGOUT BUTTON -->
        <form action="/logout" method="post" class="pt-4 border-t">
            @csrf
            <button type="button" onclick="openLogoutModal()"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded text-sm transition-colors">
                Logout
            </button>
        </form>
    </div>
</div>


<!-- LOGOUT MODAL (z-index tinggi agar terlihat di layar kecil) -->
<div id="logoutModalNs"
    class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-[9999] flex items-center justify-center p-4">

    <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">

        <!-- HEADER -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Keluar dari aplikasi</h3>
            <button type="button" onclick="closeLogoutModal()"
                class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- BODY -->
        <div class="p-6">
            <p class="text-gray-600">Anda yakin ingin keluar dari aplikasi?</p>
        </div>

        <!-- FOOTER -->
        <div class="flex items-center justify-center gap-3 p-4 border-t border-gray-200">

            <form action="/logout" method="post">
                @csrf
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded transition-colors">
                    Logout
                </button>
            </form>

            <button type="button" onclick="closeLogoutModal()"
                class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded transition-colors">
                Cancel
            </button>
        </div>
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

<!-- SCRIPT -->
<script>
    function openLogoutModal() {
        document.getElementById('logoutModalNs').classList.remove('hidden');
    }

    function closeLogoutModal() {
        document.getElementById('logoutModalNs').classList.add('hidden');
    }
</script>

<script>
    document.getElementById('openMenu').onclick = () => {
        console.log('openMenu clicked');

        document.getElementById('mobileSidebar').classList.remove('hidden');
    };
    document.getElementById('mobileSidebar').onclick = (e) => {
        if (e.target.id === 'mobileSidebar')
            document.getElementById('mobileSidebar').classList.add('hidden');
    };

    document.getElementById('openFilter').onclick = () =>
        document.getElementById('filterDrawer').classList.remove('hidden');

    document.getElementById('closeFilter').onclick = () =>
        document.getElementById('filterDrawer').classList.add('hidden');

    document.getElementById('filterDrawer').onclick = (e) => {
        if (e.target.id === 'filterDrawer')
            document.getElementById('filterDrawer').classList.add('hidden');
    };
</script>
