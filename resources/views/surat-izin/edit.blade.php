@extends('layouts.main')

@section('container')
    <div class="flex flex-col h-screen relative">
        {{-- Navbar --}}
        <x-navbar-form title="Edit Surat Izin" closeUrl="/surat-izin/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/surat-izin/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $suratIzin->id }}">
                <input type="hidden" name="index" value="{{ $suratIzin->index }}">
                <input type="hidden" name="tahun" value="{{ $suratIzin->tahun }}">

                <x-block-input-container>
                    <div>
                        <x-text-input name="status" id="status" :required="true" :readonly="true"
                            value="{{ old('status', $suratIzin->status ?? '') }}">Status
                            Surat</x-text-input>
                    </div>
                    <div>
                        <x-text-input name="nomorSurat" id="nomorSurat" :required="true"
                            value="{{ old('nomorSurat', $suratIzin->nomorSurat ?? '') }}">Nomor Surat</x-text-input>
                    </div>
                    <div>
                        <x-dropdown-input :label="'Sifat Surat'" labelPilihan='Pilih Sifat Surat' :name="'sifatSurat'"
                            :id="'sifatSurat'" :options="$sifatSurat" :required="true"
                            selectedId="{{ old('sifatSurat', $suratIzin->sifatSurat ?? '') }}"></x-dropdown-input>
                    </div>
                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat" :required="true"
                            value="{{ old('tanggalSurat', $suratIzin->tanggalSurat ?? '') }}">Tanggal
                            Surat</x-date-input>
                    </div>
                    <div>
                        <x-date-input name="tanggalAgenda" id="tanggalAgenda" :required="true"
                            value="{{ old('tanggalAgenda', $suratIzin->tanggalAgenda ?? '') }}">Tanggal
                            Agenda</x-date-input>
                    </div>

                    <div>
                        <x-text-input name="pengirim" id="pengirim" value="{{ old('pengirim') }}" :required="true"
                            value="{{ old('pengirim', $suratIzin->pengirim ?? '') }}">Pengirim</x-text-input>
                    </div>

                    <div>
                        <x-dropdown-input :label="'User'" labelPilihan='Pilih User' :name="'idPengirim'" :id="'idPengirim'"
                            :options="$pengirim" :required="true"
                            selectedId="{{ old('pengirim', $suratIzin->idPengirim ?? '') }}"></x-dropdown-input>
                    </div>

                    <div>
                        <x-text-area-input label="Perihal" name="perihal" id="perihal" value="{{ old('perihal') }}"
                            :required="true" value="{{ old('perihal', $suratIzin->perihal ?? '') }}" />
                    </div>

                    <div>
                        <x-dropdown-input :label="'Lampiran'" labelPilihan='Keterangan Lampiran' :name="'lampiran'"
                            :id="'lampiran'" :options="$lampiran" :required="true"
                            selectedId="{{ old('lampiran', $suratIzin->lampiran ?? '') }}"></x-dropdown-input>
                    </div>


                    <div>
                        <x-current-file-input id="fileSurat" label="File Surat" fileName="{{ $suratIzin->fileName }}"
                            filePath="{{ $suratIzin->filePath }}" />
                    </div>

                    <div>
                        <x-file-input id="fileSurat" name="fileSurat" label="Ganti File Surat" :required="false" />
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

    </div>

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
