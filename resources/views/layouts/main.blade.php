<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
</head>

<body class="h-screen overflow-hidden">

    @if (!$isForm)
        <div class="grid grid-cols-1 md:[grid-template-columns:64px_1fr] h-screen overflow-hidden">

            {{-- Sidebar --}}
            <aside class="hidden md:block bg-green-600 text-white overflow-y-auto custom-sidebar-scroll">
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
</body>

</html>
