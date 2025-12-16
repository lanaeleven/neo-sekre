@extends('layouts.main')

@section('container')
    <div>
        {{-- Animations --}}
        <x-animations-style />

        <x-default-page-container>
            {{-- NAVBAR --}}
            <x-navbar title="{{ $title }}" urlTambah="/informasi/tambah" />

            {{-- Pagination Mobile --}}
            <x-mobile-pagination>
                {{ $informasi->appends(request()->input())->links('pagination::custom') }}
            </x-mobile-pagination>

            {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
            @include('layouts.mobile-sidebar')

            <x-mobile-filter-drawer urlFilter="/informasi/index" :withAddOption="true" addOptionUrl="/informasi/tambah">
                <x-range-date-filter />
                <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index" />
                <x-mobile-dropdown-field-filter name='jenisInformasi' optionLabelDefault='Semua Jenis' :options="$jenisInformasi" />
                <x-input-field-filter :isLabel="false" name="judul" type="text" placeholder="Judul" />
            </x-mobile-filter-drawer>

            {{-- ================= DESKTOP FILTER BAR ================= --}}
            <x-desktop-filter-bar urlFilter="/informasi/index">
                <x-range-date-filter />
                <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index"
                    :isSmall="true" />
                <x-desktop-dropdown-field-filter name="jenisInformasi" id="jenisInformasi" optionLabelDefault="Semua Jenis"
                    :options="$jenisInformasi" />
                <x-input-field-filter :isLabel="false" name="judul" type="text" placeholder="Judul"
                    :isSmall="true" />
            </x-desktop-filter-bar>

            @if ($informasi->isEmpty())
                <x-empty-content />
            @else
                {{-- ================= DESKTOP TABLE ================= --}}
                <x-simple-table :headers="['Indeks', 'Judul', 'Jenis', 'Tanggal', 'Aksi']">
                    @foreach ($informasi as $i)
                        <tr class="hover:bg-green-50 transition-colors">
                            <x-td-default>{{ $i->index }}</x-td-default>
                            <x-td-default>{{ $i->judul }}</x-td-default>
                            <x-td-default>{{ $i->jenisInformasi->nama }}</x-td-default>
                            <x-td-default>{{ $i->tanggalSurat }}</x-td-default>
                            <x-td-action>
                                <x-button-with-tooltip variant="warning" tooltip="Edit"
                                    url="/informasi/edit/{{ $i->id }}"><x-heroicon-s-pencil
                                        class="w-4 h-4" /></x-button-with-tooltip>
                                <x-button-with-tooltip variant="light" tooltip="Lihat"
                                    url="{{ asset('storage/' . $i->filePath) }}" target="_blank"><x-heroicon-s-eye
                                        class="w-4 h-4" /></x-button-with-tooltip>
                            </x-td-action>
                        </tr>
                    @endforeach
                </x-simple-table>
            @endif

            {{-- ================= MOBILE CARD LIST ================= --}}
            <x-mobile-card-container>
                @foreach ($informasi as $i)
                    <x-mobile-card-border>
                        <x-mobile-card-header title1="{{ $i->jenisInformasi->nama }}" title2="{{ $i->index }}" />
                        <x-mobile-card-text-bold text="{{ $i->judul }}" />
                        <x-mobile-card-text-lite text="{{ $i->tanggalSurat }}" />
                        <x-mobile-card-text-actions>
                            <x-button-with-tooltip variant="warning" tooltip="Edit"
                                url="/informasi/edit/{{ $i->id }}">Edit</x-button-with-tooltip>
                            <x-button-with-tooltip variant="light" tooltip="Lihat"
                                url="{{ asset('storage/' . $i->filePath) }}" target="_blank">Lihat</x-button-with-tooltip>
                        </x-mobile-card-text-actions>
                    </x-mobile-card-border>
                @endforeach
            </x-mobile-card-container>

            {{-- Pagination Desktop --}}
            <x-desktop-pagination>
                {{ $informasi->appends(request()->input())->links('pagination::custom') }}
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
