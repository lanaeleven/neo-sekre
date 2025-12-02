@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Jenis Surat" closeUrl="/jenis-surat/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/jenis-surat/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $jenisSurat->id }}">

                <x-block-input-container>
                    <div>
                        <x-text-input name="kodeJenisSurat" id="kodeJenisSurat"
                            value="{{ old('kodeJenisSurat', $jenisSurat->kodeJenisSurat ?? '') }}" :required="true">Kode
                            Jenis Surat</x-text-input>
                    </div>
                    <div>
                        <x-text-input name="keterangan" id="keterangan"
                            value="{{ old('keterangan', $jenisSurat->keterangan ?? '') }}"
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
