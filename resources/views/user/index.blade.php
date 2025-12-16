@extends('layouts.main')

@section('container')
    <div>
        {{-- Animations --}}
        <x-animations-style />

        <x-default-page-container>
            {{-- NAVBAR --}}
            <x-navbar title="{{ $title }}" urlTambah="/user/tambah" />

            {{-- ================= MOBILE SIDEBAR (MENU) ================= --}}
            @include('layouts.mobile-sidebar')

            @if ($user->isEmpty())
                <x-empty-content />
            @else
                {{-- ================= DESKTOP TABLE ================= --}}
                <x-simple-table :headers="['ID', 'Nama', 'Jabatan', 'Status', 'Aksi']">
                    @foreach ($user as $u)
                        <tr class="hover:bg-green-50 transition-colors">
                            <x-td-default>{{ $u->id }}</x-td-default>
                            <x-td-default>{{ $u->nama }}</x-td-default>
                            <x-td-default>{{ $u->namaJabatan }}</x-td-default>
                            <x-td-default>
                                @if ($u->isAktif)
                                    <span>Aktif</span>
                                @else
                                    <span class="text-red-700">Non Aktif</span>
                                @endif
                            </x-td-default>

                            <x-td-action>
                                <x-button-with-tooltip variant="warning" tooltip="Edit Profil"
                                    url="/user/edit-profil/{{ $u->id }}"><x-heroicon-s-user
                                        class="w-4 h-4" /></x-button-with-tooltip>
                                <x-button-with-tooltip variant="warning" tooltip="Edit Password"
                                    url="/user/edit-password/{{ $u->id }}"><x-heroicon-s-key
                                        class="w-4 h-4" /></x-button-with-tooltip>
                                <x-button-with-tooltip variant="warning" tooltip="Edit Lingkup Unit"
                                    url="/user/edit-lingkup-unit/{{ $u->id }}"><x-heroicon-s-building-office
                                        class="w-4 h-4" /></x-button-with-tooltip>
                                @if ($u->isAktif)
                                    <form action="/user/nonaktifkan" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $u->id }}">
                                        <x-submit-button-with-tooltip tooltip="Nonaktifkan User" variant="danger">
                                            <x-heroicon-s-x-mark class="w-4 h-4" />
                                        </x-submit-button-with-tooltip>
                                    </form>
                                @else
                                    <form action="/user/aktifkan" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $u->id }}">
                                        <x-submit-button-with-tooltip tooltip="Aktifkan User" variant="success">
                                            <x-heroicon-s-check class="w-4 h-4" />
                                        </x-submit-button-with-tooltip>
                                    </form>
                                @endif

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
