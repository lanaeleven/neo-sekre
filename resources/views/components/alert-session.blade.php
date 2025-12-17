{{-- ALERT SESSION CLOSEABLE --}}
@if (session('success'))
    <div class="alert mb-4 p-3 rounded-lg bg-green-100 text-green-800 border border-green-300 relative">
        <span>{{ session('success') }}</span>
        <button class="close-alert absolute right-2 top-2 text-green-900 hover:text-green-600 text-xl leading-none">
            &times;
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert mb-4 p-3 rounded-lg bg-red-100 text-red-800 border border-red-300 relative">
        <span>{{ session('error') }}</span>
        <button class="close-alert absolute right-2 top-2 text-red-900 hover:text-red-600 text-xl leading-none">
            &times;
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert mb-4 p-3 rounded-lg bg-red-100 text-red-800 border border-red-300 relative">
        <p class="font-semibold">Terjadi kesalahan:</p>
        <ul class="mt-1 list-disc pl-5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <button class="close-alert absolute right-2 top-2 text-red-900 hover:text-red-600 text-xl leading-none">
            &times;
        </button>
    </div>
@endif

<script>
        document.querySelectorAll('.close-alert').forEach(btn => {
            btn.addEventListener('click', function() {
                this.parentElement.style.display = 'none';
            });
        });
    </script>
