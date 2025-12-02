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


            {{-- ================= DESKTOP TABLE ================= --}}
            <x-simple-table :headers="['ID', 'Nama', 'Jabatan', 'Level', 'Atasan', 'Aksi']">
                @foreach ($user as $u)
                    <tr class="hover:bg-green-50 transition-colors">
                        <x-td-default>{{ $u->id }}</x-td-default>
                        <x-td-default>{{ $u->nama }}</x-td-default>
                        <x-td-default>{{ $u->namaJabatan }} @if ($u->isKhusus)
                                (Akun Khusus)
                            @endif </x-td-default>
                        <x-td-default>
                            @if (is_null($u->strukturOrganisasi))
                                Belum Diisi
                            @else
                                @switch($u->strukturOrganisasi->levelJabatan)
                                    @case(1)
                                        Sekretariat
                                    @break

                                    @case(2)
                                        Direktur
                                    @break

                                    @case(3)
                                        Kabag/Kabid
                                    @break

                                    @case(4)
                                        Kains/Kasubbag/Kasi/Penjab
                                    @break

                                    @case(5)
                                        Komite/Tim
                                    @break

                                    @default
                                @endswitch
                            @endif
                        </x-td-default>
                        <x-td-default>
                            @if (is_null($u->strukturOrganisasi))
                                Belum Diisi
                            @else
                                {{ $u->strukturOrganisasi->atasan->namaJabatan }}
                            @endif
                        </x-td-default>
                        <x-td-action>
                            <x-button-with-tooltip variant="warning" tooltip="Edit"
                                url="/user/edit/{{ $u->id }}"><x-heroicon-s-pencil
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
