@extends('layouts.main')

@section('container')
    <div class="flex flex-col h-screen relative">
        {{-- Navbar --}}
        <div class="bg-white border-b border-gray-200 px-4 py-1 top-0 z-10">
            <div class="flex justify-between items-center">
                <span>E-Sekre</span>
                <span>Surat Masuk</span>
                <div>
                    <x-button-with-link title="Buat Baru" url="/surat-masuk/tambah" />
                </div>
            </div>
            <div id="filter-box" class="flex justify-center">
                <form class="flex gap-1" action="/surat-masuk/index">
                    <x-input-field-filter :isLabel="true" label="Awal" name="tanggalAwal" type="date"
                        :isMediumUp="true" />
                    <x-input-field-filter :isLabel="true" label="Akhir" name="tanggalAkhir" type="date"
                        :isMediumUp="true" />
                    <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index"
                        :isSmall="true" />
                    <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="Pengirim"
                        :isMedium="true" />
                    <x-input-field-filter :isLabel="false" name="nomorSurat" type="text" placeholder="Nomor Surat"
                        :isMedium="true" />
                    <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal"
                        :isMedium="true" />
                    <x-input-field-filter :isLabel="false" name="status" type="text" placeholder="Status"
                        :isMedium="true" />
                    <x-filter-submit-button />
                </form>
            </div>
        </div>
        {{-- Navbar --}}

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto">
            <table class="min-w-full text-sm border-collapse border border-gray-200">
                <thead class="sticky top-0 bg-gray-100 z-10">
                    <tr>
                        <th class="border border-gray-200 px-4 py-2 text-left">Indeks</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">Dari</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">Tgl Surat</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">No Surat</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">Perihal</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">Status</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suratMasuk as $sm)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2">{{ $sm->index }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $sm->pengirim }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $sm->tanggalSurat }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $sm->nomorSurat }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $sm->perihal }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $sm->status }}</td>
                            <td class="border border-gray-200 px-4 py-2">
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
