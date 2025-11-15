@extends('layouts.main')

@section('container')
    <div class="flex flex-col h-screen relative">

        {{-- ================= NAVBAR ================= --}}
        <div class="bg-white border-b border-gray-200 px-4 py-2 shadow-sm flex items-center justify-between">

            {{-- Mobile Menu Button --}}
            <button id="openMenu" class="md:hidden text-gray-700 text-xl">
                ☰
            </button>

            {{-- Logo --}}
            <span class="hidden md:block  text-green-700 font-semibold tracking-wide">
                E-Sekre
            </span>

            {{-- Page Title (hide on small screen) --}}
            <span class="text-gray-600 font-medium ">
                Surat Masuk
            </span>

            {{-- Right Button --}}
            <div class="hidden md:block">
                <x-button-with-link title="Buat Baru" url="/surat-masuk/tambah" variant="success" />
            </div>

            {{-- FILTER button on mobile --}}
            <button id="openFilter" class="md:hidden text-green-700 px-2 py-1 rounded border border-green-600 ml-2">
                Filter
            </button>
        </div>



        {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
        <div id="mobileSidebar" class="fixed inset-0 bg-black/30 backdrop-blur-sm hidden z-50 lg:hidden">

            <div class="w-64 bg-white h-full shadow-xl p-4 animate-slideIn">
                <h2 class="text-lg font-semibold mb-4 text-green-700">Menu</h2>

                <a href="/surat-masuk/index" class="block px-3 py-2 rounded hover:bg-gray-100">Surat Masuk</a>
                <a href="/surat-masuk/tambah" class="block px-3 py-2 rounded hover:bg-gray-100">Tambah Surat Masuk</a>
                <a href="/surat-keluar/index" class="block px-3 py-2 rounded hover:bg-gray-100">Surat Keluar</a>

            </div>
        </div>



        {{-- ================= MOBILE FILTER DRAWER ================= --}}
        <div id="filterDrawer" class="fixed inset-0 bg-black/30 backdrop-blur-sm hidden z-40 md:hidden">

            <div class="w-full max-w-sm bg-white h-full shadow-xl p-4 animate-slideInRight ml-auto">
                <h2 class="text-lg font-semibold mb-4 text-green-700 flex justify-between">
                    Filter Surat

                    <button id="closeFilter" class="text-gray-600 text-xl leading-none">×</button>
                </h2>

                {{-- FILTER FORM (MOBILE) --}}
                <form class="grid grid-cols-1 gap-2 text-xs" action="/surat-masuk/index">

                    <x-input-field-filter :isLabel="true" label="Awal" name="tanggalAwal" type="date" />
                    <x-input-field-filter :isLabel="true" label="Akhir" name="tanggalAkhir" type="date" />
                    <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index" />
                    <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="Pengirim" />
                    <x-input-field-filter :isLabel="false" name="nomorSurat" type="text" placeholder="No Surat" />
                    <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal" />
                    <x-input-field-filter :isLabel="false" name="status" type="text" placeholder="Status" />

                    <x-filter-submit-button />

                </form>
            </div>
        </div>



        {{-- MOBILE + MENU + FILTER Scripts --}}
        <script>
            document.getElementById('openMenu').onclick = () => {
                document.getElementById('mobileSidebar').classList.remove('hidden');
            };
            document.getElementById('mobileSidebar').onclick = (e) => {
                if (e.target.id === 'mobileSidebar')
                    document.getElementById('mobileSidebar').classList.add('hidden');
            };

            // FILTER DRAWER
            document.getElementById('openFilter').onclick = () =>
                document.getElementById('filterDrawer').classList.remove('hidden');

            document.getElementById('closeFilter').onclick = () =>
                document.getElementById('filterDrawer').classList.add('hidden');

            document.getElementById('filterDrawer').onclick = (e) => {
                if (e.target.id === 'filterDrawer')
                    document.getElementById('filterDrawer').classList.add('hidden');
            };
        </script>



        {{-- ================= DESKTOP FILTER BAR ================= --}}
        <div id="filter-box" class="hidden md:flex justify-center bg-gray-50 border-b border-gray-200 py-2 px-2">

            <form class="grid grid-cols-1 sm:grid-cols-2 md:flex md:flex-wrap gap-1 text-xs w-full max-w-4xl"
                action="/surat-masuk/index">

                <x-input-field-filter :isLabel="true" label="Awal" name="tanggalAwal" type="date"
                    :isMediumUp="true" />
                <x-input-field-filter :isLabel="true" label="Akhir" name="tanggalAkhir" type="date"
                    :isMediumUp="true" />
                <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index"
                    :isSmall="true" />
                <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="Pengirim"
                    :isMedium="true" />
                <x-input-field-filter :isLabel="false" name="nomorSurat" type="text" placeholder="No Surat"
                    :isMedium="true" />
                <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal"
                    :isMedium="true" />
                <x-input-field-filter :isLabel="false" name="status" type="text" placeholder="Status"
                    :isMedium="true" />

                <x-filter-submit-button />

            </form>
        </div>



        {{-- ================= DESKTOP TABLE ================= --}}
        <div class="hidden md:block flex-1 overflow-y-auto px-1">

            <table class="min-w-full text-sm border-collapse">
                <thead class="sticky top-0 z-10 text-white" style="background: linear-gradient(180deg, #10b981, #059669);">
                    <tr>
                        <th class="px-4 py-2 font-semibold text-left border-b border-green-700">Indeks</th>
                        <th class="px-4 py-2 font-semibold text-left border-b border-green-700">Dari</th>
                        <th class="px-4 py-2 font-semibold text-left border-b border-green-700">Tgl Surat</th>
                        <th class="px-4 py-2 font-semibold text-left border-b border-green-700">No Surat</th>
                        <th class="px-4 py-2 font-semibold text-left border-b border-green-700">Perihal</th>
                        <th class="px-4 py-2 font-semibold text-left border-b border-green-700">Status</th>
                        <th class="px-4 py-2 font-semibold text-left border-b border-green-700">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @foreach ($suratMasuk as $sm)
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="border-b border-gray-200 px-4 py-2">{{ $sm->index }}</td>
                            <td class="border-b border-gray-200 px-4 py-2">{{ $sm->pengirim }}</td>
                            <td class="border-b border-gray-200 px-4 py-2">{{ $sm->tanggalSurat }}</td>
                            <td class="border-b border-gray-200 px-4 py-2">{{ $sm->nomorSurat }}</td>
                            <td class="border-b border-gray-200 px-4 py-2">{{ $sm->perihal }}</td>

                            {{-- STATUS BADGE --}}
                            <td class="border-b border-gray-200 px-4 py-2">
                                <span
                                    class="text-xs font-medium
                                @if ($sm->status === 'Selesai') text-green-700 bg-green-100
                                @elseif($sm->status === 'Proses') text-amber-700 bg-amber-100
                                @else text-gray-700 bg-gray-100 @endif
                                px-2 py-1 rounded">
                                    {{ $sm->status }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="border-b border-gray-200 px-4 py-2 space-x-1">
                                <x-button-with-tooltip title="E" tooltip="Edit"
                                    url="/surat-masuk/edit/{{ $sm->id }}" />
                                <x-button-with-tooltip title="L" tooltip="Lihat"
                                    url="{{ asset('storage/' . $sm->filePath) }}" target="_blank" />
                                <x-button-with-tooltip title="LL" tooltip="Lacak"
                                    url="/surat-masuk/lacak-distribusi/{{ $sm->id }}" />
                                <x-button-with-tooltip title="D" tooltip="Disposisi"
                                    url="/surat-masuk/disposisi/{{ $sm->id }}" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        {{-- ================= MOBILE CARD LIST ================= --}}
        <div class="md:hidden px-2 space-y-2 mt-2 overflow-y-auto flex-1">

            @foreach ($suratMasuk as $sm)
                <div class="border border-gray-200 rounded-lg p-3 shadow-sm bg-white">

                    <div class="flex justify-between">
                        <span class="text-xs text-gray-400">{{ $sm->nomorSurat }}</span>
                        <span class="font-medium">{{ $sm->index }}</span>
                    </div>

                    <div class="font-medium text-gray-500">{{ $sm->perihal }}</div>
                    <div class="mt-1 text-sm text-gray-700 ">Dari: {{ $sm->pengirim }}</div>
                    <div class="text-sm text-gray-500">{{ $sm->tanggalSurat }}</div>

                    <div class="mt-2">
                        <span
                            class="text-xs px-2 py-1 rounded
                        @if ($sm->status === 'Selesai') bg-green-100 text-green-700
                        @elseif($sm->status === 'Proses') bg-amber-100 text-amber-700
                        @else bg-gray-100 text-gray-700 @endif">
                            {{ $sm->status }}
                        </span>
                    </div>

                    <div class="flex gap-1 mt-3 justify-end">
                        <x-button-with-tooltip title="Edit" tooltip="Edit"
                            url="/surat-masuk/edit/{{ $sm->id }}" />
                        <x-button-with-tooltip title="Lihat" tooltip="Lihat"
                            url="{{ asset('storage/' . $sm->filePath) }}" target="_blank" />
                        <x-button-with-tooltip title="Lacak" tooltip="Lacak"
                            url="/surat-masuk/lacak-distribusi/{{ $sm->id }}" />
                        <x-button-with-tooltip title="Disposisi" tooltip="Disposisi"
                            url="/surat-masuk/disposisi/{{ $sm->id }}" />
                    </div>
                </div>
            @endforeach

        </div>



        {{-- Pagination --}}
        <div class="flex justify-center mt-2 mb-1">
            {{ $suratMasuk->appends(request()->input())->links('pagination::custom') }}
        </div>

        {{-- Footer --}}
        <div class="bg-white border-t border-gray-200 py-1 text-center">
            <span class="text-sm text-gray-500">© 2025 E-Sekre. All rights reserved.</span>
        </div>

    </div>


    {{-- Animations --}}
    <style>
        .animate-slideIn {
            animation: slideIn 0.3s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.25s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }
    </style>
@endsection
