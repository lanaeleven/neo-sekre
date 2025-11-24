@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Regulasi" closeUrl="/regulasi/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/regulasi/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $regulasi->id }}">
                <input type="hidden" name="index" value="{{ $regulasi->index }}">
                <input type="hidden" name="tahun" value="{{ $regulasi->tahun }}">

                <x-block-input-container>
                    <div>
                        <x-dropdown-input :label="'Jenis Regulasi'" labelPilihan='Pilih Jenis Regulasi' :name="'jenisRegulasi'"
                            :id="'jenisRegulasi'" :options="$jenisRegulasi" :required="true"
                            selectedId="{{ old('jenisRegulasi', $regulasi->idJenisRegulasi ?? '') }}"></x-dropdown-input>
                    </div>

                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat"
                            value="{{ old('tanggalSurat', $regulasi->tanggalSurat ?? '') }}" :required="true">Tanggal
                            Surat</x-date-input>
                    </div>

                    <div>
                        <x-text-input name="tujuan" id="tujuan" value="{{ old('tujuan', $regulasi->tujuan ?? '') }}"
                            :required="true">Tujuan</x-text-input>
                    </div>

                    <div>
                        <x-text-area-input label="Perihal" name="perihal" id="perihal"
                            value="{{ old('perihal', $regulasi->perihal ?? '') }}" :required="true" />
                    </div>

                    <x-multi-select-input id="units" name="units" label="Pilih unit" :options="$units"
                        :selected="$regulasi->units->pluck('id')->toArray()" />

                    <div>
                        <x-current-file-input id="fileSurat" label="File Surat" fileName="{{ $regulasi->fileName }}"
                            filePath="{{ $regulasi->filePath }}" />
                    </div>

                    <div>
                        <x-file-input id="fileSurat" name="fileSurat" label="Ganti File Surat" :required="false" />
                    </div>

                    <div>
                        <x-text-area-input label="Keterangan" name="keterangan" id="keterangan"
                            value="{{ old('keterangan', $regulasi->keterangan ?? '') }}" :required="true" />
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
