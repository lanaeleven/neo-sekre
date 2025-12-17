@extends('layouts.main')

@section('container')
    {{-- Animations --}}
    <x-animations-style />

    <x-default-page-container>

        {{-- NAVBAR --}}
        <x-navbar title="{{ $title }}" :showTambahButton="false" />
        @include('components.alert-session')

        {{-- Pagination Mobile --}}
        <x-mobile-pagination>
            {{ $suratIzin->appends(request()->input())->links('pagination::custom') }}
        </x-mobile-pagination>

        {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
        @include('layouts.mobile-sidebar-ns')

        {{-- ================= MOBILE FILTER DRAWER ================= --}}
        <x-mobile-filter-drawer urlFilter="/surat-izin/ns/dikirim">
            <x-range-date-filter />
            <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index" />
            <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="Pengirim" />
            <x-input-field-filter :isLabel="false" name="nomorSurat" type="text" placeholder="No Surat" />
            <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal" />
        </x-mobile-filter-drawer>

        {{-- ================= DESKTOP FILTER BAR ================= --}}
        <x-desktop-filter-bar urlFilter="/surat-izin/ns/dikirim">
            <x-range-date-filter />
            <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index" :isSmall="true" />
            <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="Pengirim"
                :isMedium="true" />
            <x-input-field-filter :isLabel="false" name="nomorSurat" type="text" placeholder="No Surat"
                :isMedium="true" />
            <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal"
                :isMedium="true" />
        </x-desktop-filter-bar>

        @if ($suratIzin->isEmpty())
            <x-empty-content />
        @else
            {{-- ================= DESKTOP TABLE ================= --}}
            <x-simple-table :headers="['Indeks', 'Dari', 'Tgl Surat', 'No Surat', 'Perihal', 'Status', 'Aksi']">
                @foreach ($suratIzin as $si)
                    <tr class="hover:bg-green-50 transition-colors">
                        <x-td-default>{{ $si->index }}</x-td-default>
                        <x-td-default>{{ $si->pengirim }}</x-td-default>
                        <x-td-default>{{ $si->tanggalSurat }}</x-td-default>
                        <x-td-default>{{ $si->nomorSurat }}</x-td-default>
                        <x-td-default>{{ $si->perihal }}</x-td-default>
                        <x-td-badge status="{{ $si->status }}" />
                        <x-td-action>
                            <x-button-with-tooltip variant="info" tooltip="Lacak"
                                url="/surat-izin/lacak-distribusi/{{ $si->id }}"><x-heroicon-s-magnifying-glass-plus
                                    class="w-4 h-4" /></x-button-with-tooltip>
                        </x-td-action>
                    </tr>
                @endforeach
            </x-simple-table>
        @endif

        {{-- ================= MOBILE CARD LIST ================= --}}
        <x-mobile-card-container>
            @foreach ($suratIzin as $si)
                <x-mobile-card-border>
                    <x-mobile-card-header title1="{{ $si->nomorSurat }}" title2="{{ $si->index }}" />
                    <x-mobile-card-text-bold text="{{ $si->perihal }}" />
                    <x-mobile-card-text-normal text="Dari: {{ $si->pengirim }}" />
                    <x-mobile-card-text-lite text="{{ $si->tanggalSurat }}" />
                    <x-mobile-card-text-badge text="{{ $si->status }}" />
                    <x-mobile-card-text-actions>
                        <x-button-with-tooltip variant="info" tooltip="Lacak"
                            url="/surat-izin/lacak-distribusi/{{ $si->id }}">Lacak</x-button-with-tooltip>
                    </x-mobile-card-text-actions>
                </x-mobile-card-border>
            @endforeach
        </x-mobile-card-container>

        {{-- Pagination Desktop --}}
        <x-desktop-pagination>
            {{ $suratIzin->appends(request()->input())->links('pagination::custom') }}
        </x-desktop-pagination>

        {{-- Footer --}}
        <x-footer-desktop>
            © 2025 E-Sekre. All rights reserved
        </x-footer-desktop>

    </x-default-page-container>

    {{-- MOBILE + MENU + FILTER Scripts --}}
    <x-mobile-menu-filter-scripts />
    <x-range-date-filter-script />
    <script>
        document.querySelectorAll('.close-alert').forEach(btn => {
            btn.addEventListener('click', function() {
                this.parentElement.style.display = 'none';
            });
        });
    </script>
@endsection
