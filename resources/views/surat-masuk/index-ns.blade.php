@extends('layouts.main')
@section('container')
    <x-default-page-container>
        {{-- NAVBAR --}}
        <x-navbar title="{{ $title }}" urlTambah="#" />

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
            <x-data-master-card title="Belum Diteruskan"
                description="Surat masuk yang ditujukan kepada Anda namun belum Anda Teruskan (proses)"
                icon="heroicon-s-exclamation-triangle" color="red" link="{{ route('surat-masuk.belum-diteruskan') }}" />
            <x-data-master-card title="Sudah Diteruskan"
                description="Surat masuk yang pernah ditujukan kepada Anda dan sudah pernah Anda teruskan (proses)"
                icon="heroicon-s-check-circle" color="green" link="{{ route('surat-masuk.sudah-diteruskan') }}" />
            <x-data-master-card title="Sudah Diarsipkan"
                description="Surat masuk yang pernah ditujukan kepada Anda dan statusnya sudah arsip (selesai)"
                icon="heroicon-s-briefcase" color="green" link="{{ route('surat-masuk.sudah-diarsipkan') }}" />
            <x-data-master-card title="Surat Anda" description="Surat masuk dengan pengirim atas nama Anda"
                icon="heroicon-s-arrow-top-right-on-square" color="blue" link="{{ route('surat-masuk.yang-dikirim') }}" />
        </div>

        {{-- END DASHBOARD SEKRETARIAT --}}

    </x-default-page-container>
@endsection
