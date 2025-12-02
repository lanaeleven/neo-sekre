@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Unit" closeUrl="/jenis-informasi/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/jenis-informasi/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $jenisInformasi->id }}">

                <x-block-input-container>
                    <div>
                        <x-text-input name="jenisInformasi" id="jenisInformasi"
                            value="{{ old('jenisInformasi', $jenisInformasi->nama ?? '') }}" :required="true">Nama
                            Unit</x-text-input>
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
