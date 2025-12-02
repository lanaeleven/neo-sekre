@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Tambah Jenis Informasi" closeUrl="/jenis-informasi/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/jenis-informasi/tambah" method="post" enctype="multipart/form-data">
                @csrf

                <x-block-input-container>

                    <div>
                        <x-text-input name="jenisInformasi" id="jenisInformasi" value="{{ old('jenisInformasi') }}"
                            :required="true">Jenis Informasi</x-text-input>
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
