@extends('layouts.main')
@section('container')
    <div class="mb-3">

        <div>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @can('dashboard-sekre')
                {{-- DASHBOARD SEKRETARIAT --}}

                {{-- <div class="col">

                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title fw-bold">{{ $suratMasukHariIni }} Surat</h2>
                                    <p class="card-text fs-3">Surat Masuk hari ini</p>
                                    <a href="/surat-masuk/s/hari-ini" class="btn btn-sm btn-primary">Lihat Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title fw-bold">{{ $suratKeluarHariIni }} Surat</h2>
                                    <p class="card-text fs-3">Surat Keluar hari ini</p>
                                    <a href="/surat-keluar/hari-ini" class="btn btn-sm btn-primary">Lihat Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title fw-bold">{{ $suratMasukBulanIni }} Surat</h2>
                                    <p class="card-text fs-3">Surat Masuk bulan ini</p>
                                    <a href="/surat-masuk/s/bulan-ini" class="btn btn-sm btn-primary">Lihat Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title fw-bold">{{ $suratKeluarBulanIni }} Surat</h2>
                                    <p class="card-text fs-3">Surat Keluar bulan ini</p>
                                    <a href="/surat-keluar/bulan-ini" class="btn btn-sm btn-primary">Lihat Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> --}}

                <div class="col">
                    <h3 class="fw-semibold fs-3 mb-3 text-center">DASHBOARD</h3>
                    <div class="row" style="max-height: calc(100vh - 175px); overflow-y: auto;">
                        <div class="card shadow-sm mb-4">
                            <span class="fs-4 fw-semibold d-block ms-3 mt-1">SURAT</span>
                            <div class="card-body py-2 px-3">
                                <div class="row g-3">
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/surat-masuk/index?tahun={{ config('app.tahun') }}" total="{{ $suratMasukBulanIni }}"
                                            :twoRowsTitle="true" title="SURAT MASUK - {{ strtoupper($bulanSekarang) }}"
                                            headerColor='#d4edda' bodyColor='#edf7ef' buttonColor='#81c784'
                                            buttonHoverColor='#66bb6a'>
                                        </x-card-dashboard>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/surat-keluar/index?tahun={{ config('app.tahun') }}" total="{{ $suratKeluarBulanIni }}"
                                            :twoRowsTitle="true" title="SURAT KELUAR - {{ strtoupper($bulanSekarang) }}"
                                            headerColor='#d4edda' bodyColor='#edf7ef' buttonColor='#81c784'
                                            buttonHoverColor='#66bb6a'>
                                        </x-card-dashboard>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/spo/index?tahun={{ config('app.tahun') }}" total="{{ $spoBulanIni }}"
                                            :twoRowsTitle="true" title="SPO - {{ strtoupper($bulanSekarang) }}" headerColor='#d4edda'
                                            bodyColor='#edf7ef' buttonColor='#81c784' buttonHoverColor='#66bb6a'>
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
                                        <x-card-dashboard url="/undangan/index/ns" total="{{ $undangan }}"
                                            :twoRowsTitle="false" title="UNDANGAN" headerColor='#f8d7da' bodyColor='#fbeaea'
                                            buttonColor='#e57373' buttonHoverColor='#ef5350'>
                                        </x-card-dashboard>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/informasi/index/ns?jenisInformasi=1"
                                            total="{{ $pengumuman }}" :twoRowsTitle="false" title="PENGUMUMAN/ HIMBAUAN"
                                            headerColor='#fff3cd' bodyColor='#fff9e6' buttonColor='#ffd54f'
                                            buttonHoverColor='#ffca28'>
                                        </x-card-dashboard>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/informasi/index/ns?jenisInformasi=2"
                                            total="{{ $edaran }}" :twoRowsTitle="false" title="EDARAN"
                                            headerColor='#fff3cd' bodyColor='#fff9e6' buttonColor='#ffd54f'
                                            buttonHoverColor='#ffca28'>
                                        </x-card-dashboard>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END DASHBOARD SEKRETARIAT --}}
            @endcan

            @can('dashboard-not-sekre')
                {{-- DASHBOARD NON SEKRETARIAT --}}

                <div class="col">
                    <h3 class="fw-semibold fs-3 mb-3 text-center">DASHBOARD</h3>
                    <div class="row" style="max-height: calc(100vh - 175px); overflow-y: auto;">
                        <div class="card shadow-sm mb-4">
                            <span class="fs-4 fw-semibold d-block ms-3 mt-1">SURAT</span>
                            <div class="card-body py-2 px-3">
                                <div class="row g-3">
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/surat-masuk/ns/belum-diteruskan"
                                            total="{{ $belumDiteruskan }}" :twoRowsTitle="true" subTitle="SURAT MASUK"
                                            title="BELUM DITERUSKAN" headerColor='#d4edda' bodyColor='#edf7ef'
                                            buttonColor='#81c784' buttonHoverColor='#66bb6a'>
                                        </x-card-dashboard>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/surat-masuk/ns/sudah-diteruskan"
                                            total="{{ $sudahDiteruskan }}" :twoRowsTitle="true" subTitle="SURAT MASUK"
                                            title="SUDAH DITERUSKAN" headerColor='#d4edda' bodyColor='#edf7ef'
                                            buttonColor='#81c784' buttonHoverColor='#66bb6a'>
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
                                        <x-card-dashboard url="/undangan/index/ns" total="{{ $undangan }}"
                                            :twoRowsTitle="false" title="UNDANGAN" headerColor='#f8d7da' bodyColor='#fbeaea'
                                            buttonColor='#e57373' buttonHoverColor='#ef5350'>
                                        </x-card-dashboard>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/informasi/index/ns?jenisInformasi=1"
                                            total="{{ $pengumuman }}" :twoRowsTitle="false" title="PENGUMUMAN/ HIMBAUAN"
                                            headerColor='#fff3cd' bodyColor='#fff9e6' buttonColor='#ffd54f'
                                            buttonHoverColor='#ffca28'>
                                        </x-card-dashboard>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <x-card-dashboard url="/informasi/index/ns?jenisInformasi=2"
                                            total="{{ $edaran }}" :twoRowsTitle="false" title="EDARAN"
                                            headerColor='#fff3cd' bodyColor='#fff9e6' buttonColor='#ffd54f'
                                            buttonHoverColor='#ffca28'>
                                        </x-card-dashboard>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- END DASHBOARD NON SEKRETARIAT --}}
            @endcan
        </div>
    @endsection
