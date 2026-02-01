@extends('layouts.main')

@section('container')
    {{-- Animations --}}
    <x-animations-style />

    <x-default-page-container>

        {{-- NAVBAR --}}
        <x-navbar title="{{ $title }}" urlTambah="/surat-masuk/tambah" />

        {{-- Pagination Mobile --}}
        <x-mobile-pagination>
            {{ $suratMasuk->appends(request()->input())->links('pagination::custom') }}
        </x-mobile-pagination>

        
        {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
        @include('layouts.mobile-sidebar')
        
        {{-- ================= MOBILE FILTER DRAWER ================= --}}
        <x-mobile-filter-drawer urlFilter="/surat-masuk/index" :withAddOption="true" addOptionUrl="/surat-masuk/tambah">
            <x-range-date-filter />
            <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index" />
            <x-mobile-dropdown-field-filter name='jenisSurat' optionLabelDefault='Semua Jenis' :options="$jenisSurat" />
            <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="Pengirim" />
            <x-input-field-filter :isLabel="false" name="nomorSurat" type="text" placeholder="No Surat" />
            <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal" />
            <x-input-field-filter :isLabel="false" name="status" type="text" placeholder="Status" />
        </x-mobile-filter-drawer>
        
        {{-- ================= DESKTOP FILTER BAR ================= --}}
        <x-desktop-filter-bar urlFilter="/surat-masuk/index">
            <x-range-date-filter />
            <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index" :isSmall="true" />
            <x-desktop-dropdown-field-filter name="jenisSurat" id="jenisSurat" optionLabelDefault="Semua Jenis" :options="$jenisSurat" />
            <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="Pengirim"
            :isMedium="true" />
            <x-input-field-filter :isLabel="false" name="nomorSurat" type="text" placeholder="No Surat"
            :isMedium="true" />
            <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal"
            :isMedium="true" />
            <x-input-field-filter :isLabel="false" name="status" type="text" placeholder="Status"
            :isMedium="true" />
        </x-desktop-filter-bar>
        
        @include('components.alert-session')
        
        @if ($suratMasuk->isEmpty())
            <x-empty-content />
        @else
            {{-- ================= DESKTOP TABLE ================= --}}
            <x-simple-table :headers="['Indeks', 'Jenis', 'Dari', 'Tgl Surat', 'No Surat', 'Perihal', 'Status', 'Aksi']">
                @foreach ($suratMasuk as $sm)
                    <tr class="hover:bg-green-50 transition-colors">
                        <x-td-default>{{ $sm->index }}</x-td-default>
                        <x-td-default>{{ $sm->jenisSurat->nama }}</x-td-default>
                        <x-td-default>{{ $sm->pengirim }}</x-td-default>
                        <x-td-default>{{ $sm->tanggalSurat }}</x-td-default>
                        <x-td-default>{{ $sm->nomorSurat }}</x-td-default>
                        <x-td-default>{{ $sm->perihal }}</x-td-default>
                        <x-td-badge status="{{ $sm->status }}" />
                        <x-td-action>
                            <x-button-with-tooltip variant="warning" tooltip="Edit"
                                url="/surat-masuk/edit/{{ $sm->id }}"><x-heroicon-s-pencil
                                    class="w-4 h-4" /></x-button-with-tooltip>
                            <x-button-with-tooltip variant="light" tooltip="Lihat"
                                url="{{ asset('storage/' . $sm->filePath) }}" target="_blank"><x-heroicon-s-eye
                                    class="w-4 h-4" /></x-button-with-tooltip>
                            <x-button-with-tooltip variant="info" tooltip="Lacak"
                                url="/surat-masuk/lacak-distribusi/{{ $sm->id }}"><x-heroicon-s-magnifying-glass-plus
                                    class="w-4 h-4" /></x-button-with-tooltip>
                            <x-button-with-tooltip variant="success" tooltip="Disposisi"
                                url="/surat-masuk/disposisi/{{ $sm->id }}"><x-heroicon-s-arrow-up-right
                                    class="w-4 h-4" /></x-button-with-tooltip>
                        </x-td-action>
                    </tr>
                @endforeach
            </x-simple-table>
        @endif
        {{-- ================= MOBILE CARD LIST ================= --}}
        <x-mobile-card-container>
            @foreach ($suratMasuk as $sm)
                <x-mobile-card-border>
                    <x-mobile-card-header title1="{{ $sm->nomorSurat }}" title2="{{ $sm->index }}" />
                    <x-mobile-card-text-bold text="{{ $sm->perihal }}" />
                    <x-mobile-card-text-normal text="Dari: {{ $sm->pengirim }}" />
                    <x-mobile-card-text-lite text="{{ $sm->tanggalSurat }}" />
                    <x-mobile-card-text-badge text="{{ $sm->status }}" />
                    <x-mobile-card-text-actions>
                        <x-button-with-tooltip variant="warning" tooltip="Edit"
                            url="/surat-masuk/edit/{{ $sm->id }}">Edit</x-button-with-tooltip>
                        <x-button-with-tooltip variant="light" tooltip="Lihat"
                            url="{{ asset('storage/' . $sm->filePath) }}" target="_blank">Lihat</x-button-with-tooltip>
                        <x-button-with-tooltip variant="info" tooltip="Lacak"
                            url="/surat-masuk/lacak-distribusi/{{ $sm->id }}">Lacak</x-button-with-tooltip>
                        <x-button-with-tooltip variant="success" tooltip="Disposisi"
                            url="/surat-masuk/disposisi/{{ $sm->id }}">Disposisi</x-button-with-tooltip>
                    </x-mobile-card-text-actions>
                </x-mobile-card-border>
            @endforeach
        </x-mobile-card-container>

        {{-- Pagination Desktop --}}
        <x-desktop-pagination>
            {{ $suratMasuk->appends(request()->input())->links('pagination::custom') }}
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
