@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Tambah Informasi" closeUrl="/informasi/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/informasi/tambah" method="post" enctype="multipart/form-data">
                @csrf

                <x-block-input-container>
                    <div>
                        <x-dropdown-input :label="'Jenis Informasi'" labelPilihan='Pilih Jenis Informasi' :name="'jenisInformasi'"
                            :id="'jenisInformasi'" :options="$jenisInformasi" :required="true"></x-dropdown-input>
                    </div>

                    <div>
                        <x-text-input name="judul" id="judul" value="{{ old('judul') }}"
                            :required="true">Judul</x-text-input>
                    </div>

                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat" value="{{ old('tanggalSurat') }}"
                            :required="true">Tanggal Surat</x-date-input>
                    </div>

                    <x-multi-select-input id="users" name="users" label="Pilih user" :options="$users" />

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
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    @stack('scripts')
@endsection
