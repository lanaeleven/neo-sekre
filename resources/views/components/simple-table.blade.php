@props([
    'headers' => [],
])

<div class="hidden md:block flex-1 overflow-y-auto px-1">

    <table class="min-w-full text-sm border-collapse">
        <thead class="sticky top-0 z-10 bg-slate-100 text-slate-700">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-4 py-2 font-medium text-left">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>


        <tbody class="bg-white">
            {{ $slot }}
        </tbody>
    </table>
</div>
