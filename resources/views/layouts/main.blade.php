<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="icon" type="image/x-icon" href={{ asset('logo-cmi.png') }}>
</head>

<body class="h-screen pb-24 md:pb-0">

    {{-- LOADING OVERLAY --}}
    <div
        id="page-loading"
        class="fixed inset-0 bg-white/70 backdrop-blur-sm z-[9999] hidden items-center justify-center"
    >
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 border-4 border-green-600 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm text-gray-600">Loading...</span>
        </div>
    </div>

    {{-- LAYOUT --}}
    @if (!$isForm)
        <div class="grid grid-cols-1 md:[grid-template-columns:64px_1fr] h-screen overflow-hidden">

            {{-- SIDEBAR --}}
            <aside class="hidden md:block text-white overflow-y-auto"
                style="background: linear-gradient(180deg, #059669, #047857);">
                @can('dashboard-sekre')
                    @include('layouts.sidebar')
                @endcan
                @can('dashboard-not-sekre')
                    @include('layouts.sidebar-ns')
                @endcan
            </aside>

            {{-- CONTENT --}}
            <main class="overflow-hidden">
                <div class="flex flex-col h-full">
                    @yield('container')
                </div>
            </main>

        </div>
    @else
        @yield('container')
    @endif

    {{-- LOGOUT MODAL --}}
    <div
        id="logoutModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-[50] flex items-center justify-center p-4"
    >
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">

            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Keluar dari aplikasi</h3>
                <button type="button" onclick="closeLogoutModal()"
                    class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>

            <div class="p-6">
                <p class="text-gray-600">Anda yakin ingin keluar dari aplikasi?</p>
            </div>

            <div class="flex justify-center gap-3 p-4 border-t">
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" onclick="beforeLogout()"
                        class="bg-red-600 hover:bg-red-700 text-white py-2 px-6 rounded">
                        Logout
                    </button>
                </form>

                <button type="button" onclick="closeLogoutModal()"
                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- TOOLTIP (SIDEBAR) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {
            const tooltip = $('<div id="sidebar-tooltip"></div>').css({
                position: 'fixed',
                padding: '4px 8px',
                background: '#2d3748',
                color: 'white',
                borderRadius: '4px',
                fontSize: '12px',
                zIndex: 999999,
                display: 'none',
                whiteSpace: 'nowrap'
            }).appendTo('body');

            $('.sidebar-item').on('mouseenter', function () {
                const text = $(this).find('.tooltip-sidebar').text();
                const el = $(this);
                const offset = el.offset();

                tooltip.text(text).fadeIn(100).css({
                    top: offset.top + el.outerHeight() / 2 - tooltip.outerHeight() / 2,
                    left: offset.left + el.outerWidth() + 10
                });
            }).on('mouseleave', () => tooltip.fadeOut(100));
        });
    </script>

    {{-- LOADING CONTROLLER (FINAL & AMAN) --}}
    <script>
        (function () {
            const loading = document.getElementById('page-loading');
            if (!loading) return;

            const show = () => {
                loading.classList.remove('hidden');
                loading.classList.add('flex');
            };

            const hide = () => {
                loading.classList.add('hidden');
                loading.classList.remove('flex');
            };

            // Klik link
            document.addEventListener('click', e => {
                const link = e.target.closest('a[href]');
                if (link && !link.hasAttribute('data-no-loading')) {
                    show();
                }
            });

            // Submit form
            document.addEventListener('submit', () => show());

            // FIX BACK / FORWARD (BFCache)
            window.addEventListener('pageshow', () => hide());

            // Safety
            window.addEventListener('load', () => hide());
        })();

        function openLogoutModal() {
            document.getElementById('logoutModal')?.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal')?.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function beforeLogout() {
            closeLogoutModal();
            document.getElementById('page-loading')?.classList.remove('hidden');
        }
    </script>

</body>
</html>
