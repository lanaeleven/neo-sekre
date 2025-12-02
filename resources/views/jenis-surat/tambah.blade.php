@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Tambah Unit" closeUrl="/jenis-surat/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/jenis-surat/tambah" method="post" enctype="multipart/form-data">
                @csrf

                <x-block-input-container>

                    <div>
                        <x-text-input name="kodeJenisSurat" id="kodeJenisSurat" value="{{ old('kodeJenisSurat') }}"
                            :required="true">Kode Jenis Surat</x-text-input>
                    </div>

                    <div>
                        <x-text-input name="keterangan" id="keterangan" value="{{ old('keterangan') }}"
                            :required="true">Keterangan</x-text-input>
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
