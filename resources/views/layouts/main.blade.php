<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body class="h-screen overflow-hidden">

    <div id="page-loading" class="fixed inset-0 bg-white/70 backdrop-blur-sm z-60 hidden items-center justify-center">
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 border-4 border-green-600 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm text-gray-600">Loading...</span>
        </div>
    </div>

    @if (!$isForm)
        <div class="grid grid-cols-1 md:[grid-template-columns:64px_1fr] h-screen overflow-hidden">

            {{-- Sidebar --}}
            <aside class="hidden md:block text-white overflow-y-auto custom-sidebar-scroll"
                style="background: linear-gradient(180deg, #059669, #047857);">
                @can('dashboard-sekre')
                    @include('layouts.sidebar')
                @endcan
                @can('dashboard-not-sekre')
                    @include('layouts.sidebar-ns')
                @endcan
            </aside>

            {{-- Content --}}
            <main class="overflow-hidden">
                <div class="flex flex-col h-full">
                    @yield('container')
                </div>
            </main>

        </div>
    @else
        @yield('container')
    @endif

    <div id="logoutModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-[50] flex items-center justify-center p-4">

        <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">

            <!-- HEADER -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Keluar dari aplikasi</h3>
                <button type="button" onclick="closeLogoutModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
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
                    <button type="submit" onclick="beforeLogout()"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            // Tooltip global (akan ditempatkan di body)
            const tooltip = $('<div id="sidebar-tooltip"></div>')
                .css({
                    position: 'fixed',
                    padding: '4px 8px',
                    background: '#2d3748', // bg-gray-800
                    color: 'white',
                    'border-radius': '4px',
                    'font-size': '12px',
                    'z-index': 999999,
                    display: 'none',
                    'white-space': 'nowrap'
                })
                .appendTo('body');

            // Event hover
            $('.sidebar-item').on('mouseenter', function() {
                const text = $(this).find('.tooltip-sidebar').text();

                tooltip.text(text).fadeIn(100);

                const el = $(this);
                const offset = el.offset();

                // Posisi tooltip di kanan icon
                tooltip.css({
                    top: offset.top + el.outerHeight() / 2 - tooltip.outerHeight() / 2,
                    left: offset.left + el.outerWidth() + 10
                });
            });

            $('.sidebar-item').on('mouseleave', function() {
                tooltip.fadeOut(100);
            });

        });
    </script>

    <script>
        const loading = document.getElementById('page-loading');

        // saat klik link
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('click', () => {
                loading.classList.remove('hidden');
                loading.classList.add('flex');
            });
        });

        // saat submit form
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                loading.classList.remove('hidden');
                loading.classList.add('flex');
            });
        });
    </script>

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

    <script>
        function beforeLogout() {
            closeLogoutModal();

            const loading = document.getElementById('page-loading');
            loading.classList.remove('hidden');
            loading.classList.add('flex');
        }
    </script>

</body>

</html>
