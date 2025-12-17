<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat RSI | Login</title>
    <link rel="icon" type="image/x-icon" href={{ asset('favicon-rsi.png') }}>
    @vite('resources/css/app.css')
</head>

{{-- <body>
    <div class="container">
        @if (session()->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('failed') }}
            </div>
        @endif
    </div>
    <h2 class="text-3xl font-bold underline">Aplikasi Surat</h2>
    <h2 class="text-center text-success fw-bold">RSI Sultan Agung Banjarbaru</h2>

    <div class="card p-4 mt-5 m-auto shadow col-10 col-md-3">
        <img src="/img/logorsi.png" class="card-img-top mb-5" alt="Logo RSI">
        @if (session()->has('blocked'))
            <div class="text-danger text-center mb-2">
                {{ session('blocked') }}
            </div>
        @endif
        <form method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <input type="text"
                    class="form-control @error('username')
            {{ 'is-invalid' }}
            @enderror "
                    id="username" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="passwordToggle" onclick="myFunction()">
                <label class="form-check-label" for="passwordToggle">Show Password</label>
            </div>
            <button type="submit" class="btn btn-success container-fluid py-2 fs-5">Login</button>
        </form>
    </div>
    <script src="/js/script.js"></script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body> --}}

<body class="min-h-screen flex flex-col md:flex-row">

    <div id="page-loading" class="fixed inset-0 bg-white/70 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 border-4 border-green-600 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm text-gray-600">Loading...</span>
        </div>
    </div>


    <!-- Left Section -->
    <div class="w-full md:w-1/2 text-white flex flex-col justify-center items-center p-10 relative overflow-hidden"
        style="background: linear-gradient(180deg, #059669, #047857);">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-50 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
        </div>

        <div class="relative z-10 text-center mt-10 md:mt-0">
            <img src="{{ asset('img/logo-cmi.png') }}" alt="Logo" class="w-20 md:w-28 mx-auto mb-6 drop-shadow-xl">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">E-SEKRE</h2>
            <p class="text-sm md:text-base max-w-md mx-auto">
                Pusat layanan administrasi yang dihadirkan untuk memberikan pengalaman pengelolaan administrasi yang
                lebih rapi, terstruktur, dan mudah diakses.
            </p>
        </div>

        <!-- Logo -->
        <div
            class="absolute top-4 left-4 md:top-6 md:left-6 text-sm tracking-widest font-semibold flex items-center gap-2">
            YAYASAN CITRA BABUR RAHMAN MADINATUL ILMI
        </div>
    </div>

    <!-- Right Section -->
    <div class="w-full md:w-1/2 flex justify-center items-center bg-white p-8 md:p-0">
        <div class="w-full max-w-md">
            @include('components.alert-session')
            <h2 class="text-2xl font-semibold text-emerald-700 mb-2 text-center md:text-left">LOGIN</h2>
            <p class="text-gray-500 text-sm mb-6 text-center md:text-left">
                Silakan masuk menggunakan username dan password Anda.
            </p>

            <!-- Laravel Login Form -->
            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <!-- Username -->
                <div>
                    <input type="text" id="username" name="username" placeholder="Username" required
                        class="w-full border rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-emerald-400
                        @error('username') border-red-500 @enderror">
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <input type="password" id="password" name="password" placeholder="Password" required
                        class="w-full border rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>

                <!-- Show Password -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="passwordToggle" class="accent-emerald-600 cursor-pointer"
                        onclick="togglePassword()">
                    <label for="passwordToggle" class="text-sm text-gray-600 cursor-pointer">Show Password</label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-md transition">
                    Login
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }
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

</body>

</html>
