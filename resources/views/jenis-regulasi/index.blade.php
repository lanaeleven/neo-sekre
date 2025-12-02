@extends('layouts.main')

@section('container')
    <div>
        {{-- Animations --}}
        <x-animations-style />

        <x-default-page-container>
            {{-- NAVBAR --}}
            <x-navbar title="{{ $title }}" urlTambah="/jenis-regulasi/tambah" />

            {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
            @include('layouts.mobile-sidebar')


            {{-- ================= DESKTOP TABLE ================= --}}
            <x-simple-table :headers="['ID', 'Kode Jenis Regulasi', 'Keterangan', 'Aksi']">
                @foreach ($jenisRegulasi as $jr)
                    <tr class="hover:bg-green-50 transition-colors">
                        <x-td-default>{{ $jr->id }}</x-td-default>
                        <x-td-default>{{ $jr->kodeJenisRegulasi }}</x-td-default>
                        <x-td-default>{{ $jr->keterangan }}</x-td-default>
                        <x-td-action>
                            <x-button-with-tooltip variant="warning" tooltip="Edit"
                                url="/jenis-regulasi/edit/{{ $jr->id }}"><x-heroicon-s-pencil
                                    class="w-4 h-4" /></x-button-with-tooltip>
                        </x-td-action>
                    </tr>
                @endforeach
            </x-simple-table>

            {{-- Footer --}}
            <x-footer-desktop>
                © 2025 E-Sekre. All rights reserved
            </x-footer-desktop>

        </x-default-page-container>
    @endsection
