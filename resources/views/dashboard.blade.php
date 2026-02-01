@extends('layouts.main')
@section('container')
    <x-default-page-container>
        {{-- NAVBAR --}}
        <x-navbar title="{{ $title }}" :showTambahButton="false" :showFilterButton="false"/>

        @can('dashboard-sekre')
            @include('layouts.mobile-sidebar')

            {{-- DASHBOARD SEKRETARIAT --}}

            <x-mobile-card-container>
                <x-dashboard-card title="Surat Masuk" value="{{ $suratMasukBulanIni }}" icon="heroicon-s-inbox-arrow-down"
                    color="green" dateText="Bulan ini"
                    link="/surat-masuk/index?tanggalAwal={{ $awalBulan }}&tanggalAkhir={{ $akhirBulan }}" />
                <x-dashboard-card title="Pengumuman/Himbauan" value="{{ $pengumuman }}"
                    icon="heroicon-s-speaker-wave" color="yellow" dateText=""
                    link="/informasi/index/ns?jenisInformasi=1" />
                <x-dashboard-card title="Edaran" value="{{ $edaran }}" icon="heroicon-s-chat-bubble-bottom-center-text"
                    color="yellow" dateText="" link="/informasi/index/ns?jenisInformasi=2" />
            </x-mobile-card-container>

            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                <x-dashboard-card title="Surat Masuk" value="{{ $suratMasukBulanIni }}" icon="heroicon-s-inbox-arrow-down"
                    linkJustify="start" color="green" dateText="Bulan ini"
                    link="/surat-masuk/index?tanggalAwal={{ $awalBulan }}&tanggalAkhir={{ $akhirBulan }}" />
                <x-dashboard-card title="Pengumuman/Himbauan" value="{{ $pengumuman }}"
                    icon="heroicon-s-speaker-wave" linkJustify="start" color="yellow" dateText=""
                    link="/informasi/index?jenisInformasi=1" />
                <x-dashboard-card title="Edaran" value="{{ $edaran }}" icon="heroicon-s-chat-bubble-bottom-center-text"
                    linkJustify="start" color="yellow" dateText="" link="/informasi/index?jenisInformasi=2" />
            </div>

            {{-- END DASHBOARD SEKRETARIAT --}}
        @endcan

        @can('dashboard-not-sekre')
            {{-- DASHBOARD NON SEKRETARIAT --}}
            @include('layouts.mobile-sidebar-ns')

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                <x-dashboard-card title="Surat Masuk Belum Diteruskan" value="{{ $belumDiteruskan }}"
                    icon="heroicon-s-inbox-arrow-down" linkJustify="start" color="green" dateText=""
                    link="/surat-masuk/ns/belum-diteruskan" />
                <x-dashboard-card title="Pengumuman/Himbauan" value="{{ $pengumuman }}"
                    icon="heroicon-s-speaker-wave" linkJustify="start" color="yellow" dateText=""
                    link="/informasi/index/ns?jenisInformasi=1" />
                <x-dashboard-card title="Edaran" value="{{ $edaran }}"
                    icon="heroicon-s-chat-bubble-bottom-center-text" linkJustify="start" color="yellow" dateText=""
                    link="/informasi/index/ns?jenisInformasi=2" />
            </div>

            <x-mobile-card-container>
                <x-dashboard-card title="Surat Masuk Belum Diteruskan" value="{{ $belumDiteruskan }}"
                    icon="heroicon-s-inbox-arrow-down" color="green" dateText=""
                    link="/surat-masuk/ns/belum-diteruskan" />
                <x-dashboard-card title="Pengumuman/Himbauan" value="{{ $pengumuman }}"
                    icon="heroicon-s-speaker-wave" color="yellow" dateText=""
                    link="/informasi/index/ns?jenisInformasi=1" />
                <x-dashboard-card title="Edaran" value="{{ $edaran }}"
                    icon="heroicon-s-chat-bubble-bottom-center-text" color="yellow" dateText=""
                    link="/informasi/index/ns?jenisInformasi=2" />
            </x-mobile-card-container>



            {{-- END DASHBOARD NON SEKRETARIAT --}}
        @endcan
    </x-default-page-container>
    <x-mobile-menu-filter-scripts />
@endsection
