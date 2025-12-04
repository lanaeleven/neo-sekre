@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Informasi Profil" closeUrl="/user/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/user/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">

                <x-block-input-container>
                    <div>
                        <x-text-input name="nama" id="nama" value="{{ old('nama', $user->nama ?? '') }}"
                            :required="true">Nama</x-text-input>
                    </div>
                    <div>
                        <x-text-input name="namaJabatan" id="namaJabatan"
                            value="{{ old('namaJabatan', $user->namaJabatan ?? '') }}"
                            :required="true">Jabatan</x-text-input>
                    </div>
                    <div>
                        <x-text-input name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
                            :required="true">Email</x-text-input>
                    </div>
                    <div>
                        <x-text-input name="username" id="username" value="{{ old('username', $user->username ?? '') }}"
                            :required="true">Username</x-text-input>
                    </div>

                </x-block-input-container>

        </x-form-body-container>

        <x-desktop-submit-container>
            <x-green-submit-button>
                Simpan
            </x-green-submit-button>
        </x-desktop-submit-container>

        </form>

    </x-default-page-container>
@endsection
