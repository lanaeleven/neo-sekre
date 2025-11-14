@extends('layouts.main')

@section('container')
    <div class="flex flex-col h-screen relative">
        {{-- Navbar --}}
        <div class="bg-white border-b border-gray-200 px-4 py-2 shadow-sm">
            <div class="flex items-center justify-between">

                <!-- Logo / Brand -->
                <span class="text-gray-700 font-semibold tracking-wide">
                    E-Sekre
                </span>

                <!-- Page Title -->
                <span class="text-gray-600 font-medium">
                    Surat Masuk
                </span>

                <!-- Right Button -->
                <div>
                    <x-button-with-link title="Buat Baru" url="/surat-masuk/tambah" variant="success" />
                </div>

            </div>
        </div>

        <div id="filter-box" class="flex justify-center bg-gray-50 border-b border-gray-200 py-1 px-2">

            <form class="flex flex-wrap items-center gap-1 text-xs" action="/surat-masuk/index">

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


        {{-- Navbar --}}

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto px-1">
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
                            <td class="border-b border-gray-200 px-4 py-2">
                                <span
                                    class="text-xs font-medium 
                        {{ $sm->status === 'Selesai'
                            ? 'text-green-700 bg-green-100 px-2 py-1 rounded'
                            : ($sm->status === 'Proses'
                                ? 'text-amber-700 bg-amber-100 px-2 py-1 rounded'
                                : 'text-gray-700 bg-gray-100 px-2 py-1 rounded') }}">
                                    {{ $sm->status }}
                                </span>
                            </td>
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
        {{-- Content --}}

        <div class="flex justify-center ">
            {{ $suratMasuk->appends(request()->input())->links('pagination::custom') }}
        </div>

        <div class="bg-white border-t border-gray-200 py-1 text-center">
            <span class="text-sm text-gray-500">© 2025 E-Sekre. All rights reserved.</span>
        </div>

    </div>
@endsection
