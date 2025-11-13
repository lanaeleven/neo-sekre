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

    <!-- Left Section -->
    <div
        class="w-full md:w-1/2 bg-gradient-to-b from-blue-500 to-blue-900 text-white flex flex-col justify-center items-center p-10 relative overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
        </div>

        <div class="relative z-10 text-center mt-10 md:mt-0">
            <h1 class="text-xl md:text-2xl font-semibold mb-2">Nice to see you again</h1>
            <h2 class="text-4xl md:text-5xl font-bold mb-6">WELCOME BACK</h2>
            <p class="text-sm md:text-base max-w-md mx-auto">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
            </p>
        </div>

        <!-- Logo -->
        <div
            class="absolute top-4 left-4 md:top-6 md:left-6 text-sm tracking-widest font-semibold flex items-center gap-2">
            <div class="w-4 h-4 md:w-5 md:h-5 rounded-full border-2 border-white"></div>
            COMPANY NAME
        </div>
    </div>

    <!-- Right Section -->
    <div class="w-full md:w-1/2 flex justify-center items-center bg-white p-8 md:p-0">
        <div class="w-full max-w-md">
            <h2 class="text-2xl font-bold text-blue-600 mb-2 text-center md:text-left">Login Account</h2>
            <p class="text-gray-500 text-sm mb-6 text-center md:text-left">
                Silakan masuk menggunakan username dan password Anda.
            </p>

            <!-- Laravel Login Form -->
            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <!-- Username -->
                <div>
                    <input type="text" id="username" name="username" placeholder="Username" required
                        class="w-full border rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-400
                        @error('username') border-red-500 @enderror">
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <input type="password" id="password" name="password" placeholder="Password" required
                        class="w-full border rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Show Password -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="passwordToggle" class="accent-blue-600 cursor-pointer"
                        onclick="togglePassword()">
                    <label for="passwordToggle" class="text-sm text-gray-600 cursor-pointer">Show Password</label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-md transition">
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

</body>

</html>
