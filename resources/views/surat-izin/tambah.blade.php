@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Tambah Surat Izin" closeUrl="/surat-izin/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/surat-izin/tambah" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idPosisiDisposisi" value="1">
                <input type="hidden" name="status" value="Belum Diteruskan">

                <x-block-input-container>
                    <div>
                        <x-text-input name="nomorSurat" id="nomorSurat" value="{{ old('nomorSurat') }}"
                            :required="true">Nomor Surat</x-text-input>
                    </div>
                    <div>
                        <x-dropdown-input :label="'Sifat Surat'" labelPilihan='Pilih Sifat Surat' :name="'sifatSurat'"
                            :id="'sifatSurat'" :options="$sifatSurat" :required="true"></x-dropdown-input>
                    </div>
                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat" value="{{ old('tanggalSurat') }}"
                            :required="true">Tanggal Surat</x-date-input>
                    </div>
                    <div>
                        <x-date-input name="tanggalAgenda" id="tanggalAgenda" value="{{ old('tanggalAgenda') }}"
                            :required="true">Tanggal Agenda</x-date-input>
                    </div>
                    <div>
                        <x-text-input name="pengirim" id="pengirim" value="{{ old('pengirim') }}"
                            :required="true">Pengirim</x-text-input>
                    </div>
                    <div>
                        <x-dropdown-input :label="'User'" labelPilihan='Pilih User' :name="'idPengirim'" :id="'idPengirim'"
                            :options="$pengirim" :required="true"></x-dropdown-input>
                    </div>

                    <div>
                        <x-text-area-input label="Perihal" name="perihal" id="perihal" value="{{ old('perihal') }}"
                            :required="true" />
                    </div>

                    <div>
                        <x-dropdown-input :label="'Lampiran'" labelPilihan='Keterangan Lampiran' :name="'lampiran'"
                            :id="'lampiran'" :options="$lampiran" :required="true"></x-dropdown-input>
                    </div>

                    <div>
                        <x-file-input id="fileSurat" name="fileSurat" label="Upload Surat" :required="true" />
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

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        new TomSelect('#idPengirim', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
@endsection
