@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Informasi" closeUrl="/informasi/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/informasi/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $informasi->id }}">
                <input type="hidden" name="index" value="{{ $informasi->index }}">
                <input type="hidden" name="tahun" value="{{ $informasi->tahun }}">

                <x-block-input-container>
                    <div>
                        <x-dropdown-input :label="'Jenis Informasi'" labelPilihan='Pilih Jenis Informasi' :name="'jenisInformasi'"
                            :id="'jenisInformasi'" :options="$jenisInformasi" :required="true"
                            selectedId="{{ old('jenisInformasi', $informasi->idJenisInformasi ?? '') }}"></x-dropdown-input>
                    </div>

                    <div>
                        <x-text-input name="judul" id="judul" value="{{ old('judul', $informasi->judul ?? '') }}"
                            :required="true">Judul</x-text-input>
                    </div>

                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat"
                            value="{{ old('tanggalSurat', $informasi->tanggalSurat ?? '') }}" :required="true">Tanggal
                            Surat</x-date-input>
                    </div>

                    <x-multi-select-input id="users" name="users" label="Pilih unit" :options="$users"
                        :selected="$informasi->users->pluck('id')->toArray()" />

                    <div>
                        <x-current-file-input id="fileSurat" label="File Surat" fileName="{{ $informasi->fileName }}"
                            filePath="{{ $informasi->filePath }}" />
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

    </x-default-page-container>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    @stack('scripts')
@endsection
