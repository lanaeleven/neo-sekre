@extends('layouts.main')

@section('container')
    <div>
        {{-- Animations --}}
        <x-animations-style />

        <x-default-page-container>
            {{-- NAVBAR --}}
            <x-navbar title="{{ $title }}" urlTambah="/jenis-surat-masuk/tambah" />

            {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
            @include('layouts.mobile-sidebar')

            @include('components.alert-session')
            
            @if ($jenisSurat->isEmpty())
                <x-empty-content />
            @else
                {{-- ================= DESKTOP TABLE ================= --}}
                <x-simple-table :headers="['ID', 'Nama', 'Aksi']">
                    @foreach ($jenisSurat as $js)
                        <tr class="hover:bg-green-50 transition-colors">
                            <x-td-default>{{ $js->id }}</x-td-default>
                            <x-td-default>{{ $js->nama }}</x-td-default>
                            <x-td-action>
                                <x-button-with-tooltip variant="warning" tooltip="Edit"
                                    url="/jenis-surat-masuk/edit/{{ $js->id }}"><x-heroicon-s-pencil
                                        class="w-4 h-4" /></x-button-with-tooltip>
                            </x-td-action>
                        </tr>
                    @endforeach
                </x-simple-table>
            @endif

            {{-- Footer --}}
            <x-footer-desktop>
                © 2025 E-Sekre. All rights reserved
            </x-footer-desktop>

        </x-default-page-container>
    @endsection
