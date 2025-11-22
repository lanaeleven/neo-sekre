<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body class="h-screen overflow-hidden">

    @if (!$isForm)
        <div class="grid grid-cols-1 md:[grid-template-columns:64px_1fr] h-screen overflow-hidden">

            {{-- Sidebar --}}
            <aside class="hidden md:block text-white overflow-y-auto custom-sidebar-scroll"
                style="background: linear-gradient(180deg, #059669, #047857);">
                @include('layouts.sidebar')
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
</body>

</html>
