@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Tambah Surat Keluar" closeUrl="/surat-keluar/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/surat-keluar/tambah" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idPosisiDisposisi" value="1">
                <input type="hidden" name="status" value="Belum Diteruskan">

                <x-block-input-container>
                    <div>
                        <x-dropdown-input :label="'Jenis Surat'" labelPilihan='Pilih Jenis Surat' :name="'jenisSurat'"
                            :id="'jenisSurat'" :options="$jenisSurat" :required="true"></x-dropdown-input>
                    </div>
                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat" value="{{ old('tanggalSurat') }}"
                            :required="true">Tanggal Surat</x-date-input>
                    </div>
                    <div>
                        <x-text-input name="tujuan" id="tujuan" value="{{ old('tujuan') }}"
                            :required="true">Tujuan</x-text-input>
                    </div>
                    <div>
                        <x-text-area-input label="Perihal" name="perihal" id="perihal" value="{{ old('perihal') }}"
                            :required="true" />
                    </div>
                    <div>
                        <x-file-input id="fileSurat" name="fileSurat" label="Upload Surat" :required="true" />
                    </div>
                    <div>
                        <x-text-area-input label="Keterangan" name="keterangan" id="keterangan"
                            value="{{ old('keterangan') }}" :required="true" />
                    </div>

                </x-block-input-container>

                <x-mobile-submit-container>
                    <x-green-submit-button>
                        Simpan
                    </x-green-submit-button>
                </x-mobile-submit-container>

        </x-form-body-container>

        <x-desktop-submit-container>
            <x-green-submit-button>
                Simpan
            </x-green-submit-button>
        </x-desktop-submit-container>

        </form>

    </x-default-page-container>
@endsection
