@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit SPO" closeUrl="/spo/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/spo/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $spo->id }}">
                <input type="hidden" name="index" value="{{ $spo->index }}">
                <input type="hidden" name="tahun" value="{{ $spo->tahun }}">

                <x-block-input-container>
                    <x-multi-select-input id="units" name="units" label="Pilih unit" :options="$units"
                        :selected="$spo->units->pluck('id')->toArray()" />
                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat"
                            value="{{ old('tanggalSurat', $spo->tanggalSurat ?? '') }}" :required="true">Tanggal
                            Surat</x-date-input>
                    </div>
                    <div>
                        <x-text-input name="tujuan" id="tujuan" value="{{ old('tujuan', $spo->tujuan ?? '') }}"
                            :required="true">Tujuan</x-text-input>
                    </div>
                    <div>
                        <x-text-area-input label="Perihal" name="perihal" id="perihal"
                            value="{{ old('perihal', $spo->perihal ?? '') }}" :required="true" />
                    </div>
                    <div>
                        <x-current-file-input id="fileSurat" label="File Surat" fileName="{{ $spo->fileName }}"
                            filePath="{{ $spo->filePath }}" />
                    </div>

                    <div>
                        <x-file-input id="fileSurat" name="fileSurat" label="Ganti File Surat" :required="false" />
                    </div>

                    <div>
                        <x-text-area-input label="Keterangan" name="keterangan" id="keterangan"
                            value="{{ old('keterangan', $spo->keterangan ?? '') }}" :required="true" />
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
