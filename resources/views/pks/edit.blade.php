@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Perjanjian Kerja Sama" closeUrl="/pks/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/pks/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $pks->id }}">
                <input type="hidden" name="index" value="{{ $pks->index }}">
                <input type="hidden" name="tahun" value="{{ $pks->tahun }}">

                <x-block-input-container>
                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat"
                            value="{{ old('tanggalSurat', $pks->tanggalSurat ?? '') }}" :required="true">Tanggal
                            Surat</x-date-input>
                    </div>
                    <div>
                        <x-text-input name="tujuan" id="tujuan" value="{{ old('tujuan', $pks->tujuan ?? '') }}"
                            :required="true">Tujuan</x-text-input>
                    </div>
                    <div>
                        <x-text-area-input label="Perihal" name="perihal" id="perihal"
                            value="{{ old('perihal', $pks->perihal ?? '') }}" :required="true" />
                    </div>
                    <x-multi-select-input id="users" name="users" label="Pilih user" :options="$users"
                        :selected="$pks->users->pluck('id')->toArray()" />
                    <div>
                        <x-current-file-input id="fileSurat" label="File Surat" fileName="{{ $pks->fileName }}"
                            filePath="{{ $pks->filePath }}" />
                    </div>

                    <div>
                        <x-file-input id="fileSurat" name="fileSurat" label="Ganti File Surat" :required="false" />
                    </div>

                    <div>
                        <x-text-area-input label="Keterangan" name="keterangan" id="keterangan"
                            value="{{ old('keterangan', $pks->keterangan ?? '') }}" :required="true" />
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
