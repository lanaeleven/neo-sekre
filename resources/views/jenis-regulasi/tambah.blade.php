@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Tambah Jenis Regulasi" closeUrl="/jenis-regulasi/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/jenis-regulasi/tambah" method="post" enctype="multipart/form-data">
                @csrf

                <x-block-input-container>

                    <div>
                        <x-text-input name="kodeJenisRegulasi" id="kodeJenisRegulasi" value="{{ old('kodeJenisRegulasi') }}"
                            :required="true">Kode Jenis Regulasi</x-text-input>
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
