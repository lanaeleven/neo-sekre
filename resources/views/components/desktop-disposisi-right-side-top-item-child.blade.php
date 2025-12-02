@props([
    'pengirim' => 'pengirim',
    'penerima' => 'penerima',
    'instruksi' =>
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus debitis esse obcaecati placeat non dolore nulla eligendi exercitationem temporibus accusantium.',
    'waktu' => '2000-11-11 00:00',
])


<div class="bg-white shadow-md rounded-xl px-4 py-2 mb-4 border border-gray-200 hover:shadow-lg transition">
    <div class="text-sm font-semibold text-gray-800 mb-1">
        {{ $pengirim }}
        <span class="text-blue-600">→</span>
        {{ $penerima }}
    </div>

    <div class="text-gray-600 mb-2 leading-relaxed">
        {{ $instruksi }}
    </div>

    <div class="flex justify-end">
        <span class="text-sm text-gray-400 italic">
            {{ $waktu }}
        </span>
    </div>
</div>
