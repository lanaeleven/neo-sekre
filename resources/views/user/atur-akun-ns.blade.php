@extends('layouts.main')
@section('container')
    <x-default-page-container>
        {{-- NAVBAR --}}
        <x-navbar title="{{ $title }}" urlTambah="/surat-masuk/tambah" />

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
            <x-data-master-card title="Pengaturan Informasi Profil" description="Edit informasi profil akun user"
                icon="heroicon-s-user" color="blue" link="/user/edit-profil-ns" />
            <x-data-master-card title="Pengaturan Password Akun" description="Ubah password akun" icon="heroicon-s-key"
                color="red" link="/user/edit-password-ns" />

        </div>

        {{-- END DASHBOARD SEKRETARIAT --}}

    </x-default-page-container>
@endsection
