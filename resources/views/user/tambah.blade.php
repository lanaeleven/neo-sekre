@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Tambah User" closeUrl="/user/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/user/tambah" method="post" enctype="multipart/form-data">
                @csrf

                <x-block-input-container>

                    <div>
                        <x-text-input name="namaJabatan" id="namaJabatan" value="{{ old('namaJabatan') }}"
                            :required="true">Jabatan</x-text-input>
                    </div>

                    <div>
                        <x-text-input name="nama" id="nama" value="{{ old('nama') }}"
                            :required="true">Nama</x-text-input>
                    </div>

                    <div>
                        <x-text-input name="email" id="email" value="{{ old('email') }}"
                            :required="true">Email</x-text-input>
                    </div>

                    <div>
                        <x-text-input name="username" id="username" value="{{ old('username') }}"
                            :required="true">Username</x-text-input>
                    </div>

                    <div>
                        <x-new-password />
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
    <x-password-validation-script />
@endsection
