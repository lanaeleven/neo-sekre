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
            'icons' => ['active' => 'heroicon-s-inbox-arrow-down', 'inactive' => 'heroicon-o-inbox-arrow-down'],
        ],
        [
            'label' => 'Surat Keluar',
            'key' => 'surat keluar',
            'route' => 'surat-keluar.index',
            'icons' => ['active' => 'heroicon-s-paper-airplane', 'inactive' => 'heroicon-o-paper-airplane'],
        ],
        [
            'label' => 'Standar Prosedur Operasional',
            'key' => 'spo',
            'route' => 'spo.index',
            'icons' => ['active' => 'heroicon-s-document-text', 'inactive' => 'heroicon-o-document-text'],
        ],
        [
            'label' => 'Regulasi',
            'key' => 'regulasi',
            'route' => 'regulasi.index',
            'icons' => ['active' => 'heroicon-s-building-library', 'inactive' => 'heroicon-o-building-library'],
        ],
        [
            'label' => 'Perjanjian Kerja Sama',
            'key' => 'pks',
            'route' => 'pks.index',
            'icons' => ['active' => 'heroicon-s-user-group', 'inactive' => 'heroicon-o-user-group'],
        ],
        [
            'label' => 'Informasi',
            'key' => 'informasi',
            'route' => 'informasi.index',
            'icons' => [
                'active' => 'heroicon-s-chat-bubble-bottom-center-text',
                'inactive' => 'heroicon-o-chat-bubble-bottom-center-text',
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
    <form action="/logout" method="post">
        @csrf
        <button type="button" onclick="openLogoutModal()"
            class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded text-sm transition-colors">
            Logout
        </button>

        <!-- Modal Backdrop -->
        <div id="logoutModal"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">

            <!-- Modal Content -->
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">

                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Keluar dari aplikasi
                    </h3>
                    <button type="button" onclick="closeLogoutModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <p class="text-gray-600">
                        Anda yakin ingin keluar dari aplikasi?
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-center gap-3 p-4 border-t border-gray-200">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded transition-colors">
                        Logout
                    </button>
                    <button type="button" onclick="closeLogoutModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded transition-colors">
                        Cancel
                    </button>
                </div>

            </div>
        </div>
    </form>

    <script>
        function openLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scroll
        }

        // Close modal when clicking outside
        document.getElementById('logoutModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLogoutModal();
            }
        });
    </script>
</div>
