@extends('layouts.main')
@section('container')
    <x-default-page-container>
        {{-- NAVBAR --}}
        <x-navbar title="{{ $title }}" :showTambahButton="false" :showFilterButton="false"/>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
            <x-data-master-card title="User" description="Pengaturan Pengguna Aplikasi" icon="heroicon-s-users"
                color="green" link="/user/index" />
            <x-data-master-card title="Unit"
                description="Pengaturan Unit yang terkait dengan pengguna aplikasi, unit digunakan pada SPO dan Regulasi"
                icon="heroicon-s-building-office" color="green" link="/unit/index" />
            <x-data-master-card title="Jenis Surat Masuk"
                description="Pengaturan Jenis Surat yang akan dipakai pada Surat Masuk" icon="heroicon-s-paper-airplane"
                color="green" link="/jenis-surat-masuk/index" />
            <x-data-master-card title="Jenis Surat Keluar"
                description="Pengaturan Jenis Surat yang akan dipakai pada Surat Keluar" icon="heroicon-s-paper-airplane"
                color="green" link="/jenis-surat/index" />
            <x-data-master-card title="Jenis Regulasi"
                description="Pengaturan Jenis Regulasi yang akan dipakai pada Regulasi" icon="heroicon-s-building-library"
                color="green" link="/jenis-regulasi/index" />
            <x-data-master-card title="Jenis Informasi"
                description="Pengaturan Jenis Informasi yang akan dipakai pada Informasi"
                icon="heroicon-s-chat-bubble-bottom-center-text" color="green" link="/jenis-informasi/index" />
        </div>

        {{-- END DASHBOARD SEKRETARIAT --}}

    </x-default-page-container>
@endsection
