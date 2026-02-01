@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Jenis Surat Masuk" closeUrl="/jenis-surat-masuk/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/jenis-surat-masuk/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $jenisSurat->id }}">

                <x-block-input-container>
                    <div>
                        <x-text-input name="nama" id="nama"
                            value="{{ old('nama', $jenisSurat->nama ?? '') }}" :required="true">Nama</x-text-input>
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
