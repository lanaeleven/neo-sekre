@extends('layouts.main')

@section('container')
    <div>
        {{-- Animations --}}
        <x-animations-style />

        <x-default-page-container>
            {{-- NAVBAR --}}
            <x-navbar title="{{ $title }}" urlTambah="/surat-keluar/tambah" />

            {{-- Pagination Mobile --}}
            <x-mobile-pagination>
                {{ $suratKeluar->appends(request()->input())->links('pagination::custom') }}
            </x-mobile-pagination>

            {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
            @include('layouts.mobile-sidebar')

            <x-mobile-filter-drawer urlFilter="/surat-keluar/index">
                <x-range-date-filter />
                <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index" />
                <x-mobile-dropdown-field-filter name='jenisSurat' optionLabelDefault='Semua Jenis' :options="$jenisSurat" />
                <x-input-field-filter :isLabel="false" name="tujuan" type="text" placeholder="Tujuan" />
                <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal" />
                <x-input-field-filter :isLabel="false" name="keterangan" type="text" placeholder="Keterangan" />
            </x-mobile-filter-drawer>

            {{-- ================= DESKTOP FILTER BAR ================= --}}
            <x-desktop-filter-bar urlFilter="/surat-keluar/index">
                <x-range-date-filter />
                <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index"
                    :isSmall="true" />
                <x-desktop-dropdown-field-filter name="jenisSurat" id="jenisSurat" optionLabelDefault="Semua Jenis"
                    :options="$jenisSurat" />
                <x-input-field-filter :isLabel="false" name="tujuan" type="text" placeholder="Tujuan"
                    :isSmall="true" />
                <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal"
                    :isSmall="true" />
                <x-input-field-filter :isLabel="false" name="keterangan" type="text" placeholder="Keterangan"
                    :isMedium="true" />
            </x-desktop-filter-bar>

            {{-- ================= DESKTOP TABLE ================= --}}
            <x-simple-table :headers="['Indeks', 'Tanggal', 'Tujuan', 'Perihal', 'Keterangan', 'Jenis', 'Aksi']">
                @foreach ($suratKeluar as $sk)
                    <tr class="hover:bg-green-50 transition-colors">
                        <x-td-default>{{ $sk->index }}</x-td-default>
                        <x-td-default>{{ $sk->tanggalSurat }}</x-td-default>
                        <x-td-default>{{ $sk->tujuan }}</x-td-default>
                        <x-td-default>{{ $sk->perihal }}</x-td-default>
                        <x-td-default>{{ $sk->keterangan }}</x-td-default>
                        <x-td-default>{{ $sk->jenisSurat->keterangan }}</x-td-default>
                        <x-td-action>
                            <x-button-with-tooltip variant="warning" tooltip="Edit"
                                url="/surat-keluar/edit/{{ $sk->id }}"><x-heroicon-s-pencil
                                    class="w-4 h-4" /></x-button-with-tooltip>
                            <x-button-with-tooltip variant="light" tooltip="Lihat"
                                url="{{ asset('storage/' . $sk->filePath) }}" target="_blank"><x-heroicon-s-eye
                                    class="w-4 h-4" /></x-button-with-tooltip>
                        </x-td-action>
                    </tr>
                @endforeach
            </x-simple-table>

            {{-- ================= MOBILE CARD LIST ================= --}}
            <x-mobile-card-container>
                @foreach ($suratKeluar as $sk)
                    <x-mobile-card-border>
                        <x-mobile-card-header title1="{{ $sk->jenisSurat->keterangan }}" title2="{{ $sk->index }}" />
                        <x-mobile-card-text-bold text="{{ $sk->perihal }}" />
                        <x-mobile-card-text-normal text="Dari: {{ $sk->tujuan }}" />
                        <x-mobile-card-text-lite text="{{ $sk->tanggalSurat }}" />
                        <x-mobile-card-text-lite text="{{ $sk->keterangan }}" />
                        <x-mobile-card-text-actions>
                            <x-button-with-tooltip variant="warning" tooltip="Edit"
                                url="/surat-keluar/edit/{{ $sk->id }}">Edit</x-button-with-tooltip>
                            <x-button-with-tooltip variant="light" tooltip="Lihat"
                                url="{{ asset('storage/' . $sk->filePath) }}" target="_blank">Lihat</x-button-with-tooltip>
                        </x-mobile-card-text-actions>
                    </x-mobile-card-border>
                @endforeach
            </x-mobile-card-container>

            {{-- Pagination Desktop --}}
            <x-desktop-pagination>
                {{ $suratKeluar->appends(request()->input())->links('pagination::custom') }}
            </x-desktop-pagination>

            {{-- Footer --}}
            <x-footer-desktop>
                © 2025 E-Sekre. All rights reserved
            </x-footer-desktop>

        </x-default-page-container>

        {{-- MOBILE + MENU + FILTER Scripts --}}
        <x-mobile-menu-filter-scripts />
        <x-range-date-filter-script />
    @endsection
