@extends('layouts.main')
@section('container')
    <x-default-page-container>
        {{-- NAVBAR --}}
        <x-navbar title="{{ $title }}" urlTambah="/surat-masuk/tambah" />

        @can('dashboard-sekre')
            @include('layouts.mobile-sidebar')

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- DASHBOARD SEKRETARIAT --}}
            <x-mobile-card-container>
                <x-dashboard-card title="Surat Masuk" value="{{ $suratMasukBulanIni }}" icon="heroicon-s-inbox-arrow-down"
                    size="small" color="green" dateText="Bulan ini" />
                <x-dashboard-card title="Surat Keluar" value="{{ $suratKeluarBulanIni }}" icon="heroicon-s-paper-airplane"
                    size="small" color="green" dateText="Bulan ini" />
                <x-dashboard-card title="SPO" value="{{ $spoBulanIni }}" icon="heroicon-s-document-text" size="small"
                    color="green" dateText="Bulan ini" />
                <x-dashboard-card title="Udangan" value="{{ $undangan }}" icon="heroicon-s-envelope" size="small"
                    color="red" dateText="Yang akan datang" />
                <x-dashboard-card title="Pengumuman/Himbauan" value="{{ $pengumuman }}"
                    icon="heroicon-s-chat-bubble-bottom-center-text" size="small" color="yellow" dateText="Bulan Ini" />
                <x-dashboard-card title="Edaran" value="{{ $edaran }}" icon="heroicon-s-chat-bubble-bottom-center-text"
                    size="small" color="yellow" dateText="Bulan Ini" />
            </x-mobile-card-container>

            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                <x-dashboard-card title="Surat Masuk" value="{{ $suratMasukBulanIni }}" icon="heroicon-s-inbox-arrow-down"
                    linkJustify="start" color="green" dateText="Bulan ini" />
                <x-dashboard-card title="Surat Keluar" value="{{ $suratKeluarBulanIni }}" icon="heroicon-s-paper-airplane"
                    linkJustify="start" color="green" dateText="Bulan ini" />
                <x-dashboard-card title="SPO" value="{{ $spoBulanIni }}" icon="heroicon-s-document-text"
                    linkJustify="start" color="green" dateText="Bulan ini" />
                <x-dashboard-card title="Undangan" value="{{ $undangan }}" icon="heroicon-s-envelope" linkJustify="start"
                    color="red" dateText="Yang akan datang" />
                <x-dashboard-card title="Pengumuman/Himbauan" value="{{ $pengumuman }}"
                    icon="heroicon-s-chat-bubble-bottom-center-text" linkJustify="start" color="yellow" dateText="Bulan ini" />
                <x-dashboard-card title="Edaran" value="{{ $edaran }}" icon="heroicon-s-chat-bubble-bottom-center-text"
                    linkJustify="start" color="yellow" dateText="Bulan ini" />
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

            <div class="col">
                <h3 class="fw-semibold fs-3 mb-3 text-center">DASHBOARD</h3>
                <div class="row" style="max-height: calc(100vh - 175px); overflow-y: auto;">
                    <div class="card shadow-sm mb-4">
                        <span class="fs-4 fw-semibold d-block ms-3 mt-1">SURAT</span>
                        <div class="card-body py-2 px-3">
                            <div class="row g-3">
                                <div class="col-sm-3 mb-2">
                                    <x-card-dashboard url="/surat-masuk/ns/belum-diteruskan" total="{{ $belumDiteruskan }}"
                                        :twoRowsTitle="true" subTitle="SURAT MASUK" title="BELUM DITERUSKAN" headerColor='#d4edda'
                                        bodyColor='#edf7ef' buttonColor='#81c784' buttonHoverColor='#66bb6a'>
                                    </x-card-dashboard>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <x-card-dashboard url="/surat-masuk/ns/sudah-diteruskan" total="{{ $sudahDiteruskan }}"
                                        :twoRowsTitle="true" subTitle="SURAT MASUK" title="SUDAH DITERUSKAN"
                                        headerColor='#d4edda' bodyColor='#edf7ef' buttonColor='#81c784'
                                        buttonHoverColor='#66bb6a'>
                                    </x-card-dashboard>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <x-card-dashboard url="/surat-masuk/ns/sudah-diarsipkan" total="{{ $arsip }}"
                                        :twoRowsTitle="true" subTitle="SURAT MASUK" title="DIARSIPKAN" headerColor='#d4edda'
                                        bodyColor='#edf7ef' buttonColor='#81c784' buttonHoverColor='#66bb6a'>
                                    </x-card-dashboard>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <x-card-dashboard url="/surat-masuk/ns/dikirim" total="{{ $dikirim }}"
                                        :twoRowsTitle="false" title="SURAT KELUAR" headerColor='#d1ecf1' bodyColor='#eaf7fa'
                                        buttonColor='#64b5f6' buttonHoverColor='#42a5f5'>
                                    </x-card-dashboard>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card shadow-sm">
                        <span class="fs-4 fw-semibold d-block ms-3 mt-1">PAPAN INFORMASI</span>
                        <div class="card-body py-2 px-3">
                            <div class="row g-3">
                                <div class="col-sm-3 mb-2 ">
                                    <x-card-dashboard url="/undangan/index/ns" total="{{ $undangan }}" :twoRowsTitle="false"
                                        title="UNDANGAN" headerColor='#f8d7da' bodyColor='#fbeaea' buttonColor='#e57373'
                                        buttonHoverColor='#ef5350'>
                                    </x-card-dashboard>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <x-card-dashboard url="/informasi/index/ns?jenisInformasi=1" total="{{ $pengumuman }}"
                                        :twoRowsTitle="false" title="PENGUMUMAN/ HIMBAUAN" headerColor='#fff3cd'
                                        bodyColor='#fff9e6' buttonColor='#ffd54f' buttonHoverColor='#ffca28'>
                                    </x-card-dashboard>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <x-card-dashboard url="/informasi/index/ns?jenisInformasi=2" total="{{ $edaran }}"
                                        :twoRowsTitle="false" title="EDARAN" headerColor='#fff3cd' bodyColor='#fff9e6'
                                        buttonColor='#ffd54f' buttonHoverColor='#ffca28'>
                                    </x-card-dashboard>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- END DASHBOARD NON SEKRETARIAT --}}
        @endcan
    </x-default-page-container>
    <x-mobile-menu-filter-scripts />
@endsection
