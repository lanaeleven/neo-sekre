@extends('layouts.main')

@section('container')
    <div>
        {{-- Animations --}}
        <x-animations-style />

        <x-default-page-container>
            {{-- NAVBAR --}}
            <x-navbar title="{{ $title }}" urlTambah="/spo/tambah" />

            {{-- Pagination Mobile --}}
            <x-mobile-pagination>
                {{ $spo->appends(request()->input())->links('pagination::custom') }}
            </x-mobile-pagination>

            {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
            @include('layouts.mobile-sidebar')

            <x-mobile-filter-drawer urlFilter="/spo/index" :withAddOption="true" addOptionUrl="/spo/tambah">
                <x-range-date-filter />
                <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index" />
                <x-input-field-filter :isLabel="false" name="tujuan" type="text" placeholder="Tujuan" />
                <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal" />
                <x-input-field-filter :isLabel="false" name="keterangan" type="text" placeholder="Keterangan" />
            </x-mobile-filter-drawer>

            {{-- ================= DESKTOP FILTER BAR ================= --}}
            <x-desktop-filter-bar urlFilter="/spo/index">
                <x-range-date-filter />
                <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index"
                    :isSmall="true" />
                <x-input-field-filter :isLabel="false" name="tujuan" type="text" placeholder="Tujuan"
                    :isSmall="true" />
                <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal"
                    :isSmall="true" />
                <x-input-field-filter :isLabel="false" name="keterangan" type="text" placeholder="Keterangan"
                    :isMedium="true" />
            </x-desktop-filter-bar>

            @include('components.alert-session')
            
            @if ($spo->isEmpty())
                <x-empty-content />
            @else
                {{-- ================= DESKTOP TABLE ================= --}}
                <x-simple-table :headers="['Indeks', 'Tanggal', 'Tujuan', 'Perihal', 'Keterangan', 'Aksi']">
                    @foreach ($spo as $s)
                        <tr class="hover:bg-green-50 transition-colors">
                            <x-td-default>{{ $s->index }}</x-td-default>
                            <x-td-default>{{ $s->tanggalSurat }}</x-td-default>
                            <x-td-default>{{ $s->tujuan }}</x-td-default>
                            <x-td-default>{{ $s->perihal }}</x-td-default>
                            <x-td-default>{{ $s->keterangan }}</x-td-default>
                            <x-td-action>
                                <x-button-with-tooltip variant="warning" tooltip="Edit"
                                    url="/spo/edit/{{ $s->id }}"><x-heroicon-s-pencil
                                        class="w-4 h-4" /></x-button-with-tooltip>
                                <x-button-with-tooltip variant="light" tooltip="Lihat"
                                    url="{{ asset('storage/' . $s->filePath) }}" target="_blank"><x-heroicon-s-eye
                                        class="w-4 h-4" /></x-button-with-tooltip>
                            </x-td-action>
                        </tr>
                    @endforeach
                </x-simple-table>
            @endif

            {{-- ================= MOBILE CARD LIST ================= --}}
            <x-mobile-card-container>
                @foreach ($spo as $s)
                    <x-mobile-card-border>
                        <x-mobile-card-header title1="{{ $s->tanggalSurat }}" title2="{{ $s->index }}" />
                        <x-mobile-card-text-bold text="{{ $s->perihal }}" />
                        <x-mobile-card-text-normal text="Dari: {{ $s->tujuan }}" />
                        <x-mobile-card-text-lite text="{{ $s->keterangan }}" />
                        <x-mobile-card-text-actions>
                            <x-button-with-tooltip variant="warning" tooltip="Edit"
                                url="/spo/edit/{{ $s->id }}">Edit</x-button-with-tooltip>
                            <x-button-with-tooltip variant="light" tooltip="Lihat"
                                url="{{ asset('storage/' . $s->filePath) }}" target="_blank">Lihat</x-button-with-tooltip>
                        </x-mobile-card-text-actions>
                    </x-mobile-card-border>
                @endforeach
            </x-mobile-card-container>

            {{-- Pagination Desktop --}}
            <x-desktop-pagination>
                {{ $spo->appends(request()->input())->links('pagination::custom') }}
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
