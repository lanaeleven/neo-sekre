@extends('layouts.main')

@section('container')
    <x-animations-style />

    <x-default-page-container>

        <x-navbar-form title="Disposisi Surat" closeUrl="/surat-masuk/index" />

        <x-desktop-disposisi-wrapper>
            <x-desktop-disposisi-left-side>
                <x-desktop-disposisi-title-component text="Informasi Surat" />
                <div class="flex justify-center">
                    <form action="/unduh-disposisi" method="post">
                        @csrf
                        <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
                        <x-submit-button-with-tooltip tooltip="Download" variant="success">
                            Unduh Lembar Disposisi
                        </x-submit-button-with-tooltip>
                    </form>
                </div>
                <x-desktop-disposisi-left-side-item text1="Sifat Surat" text2="{{ $suratMasuk->sifatSurat }}" />
                <x-desktop-disposisi-left-side-item text1="Status" text2="{{ $suratMasuk->status }}" />
                <x-desktop-disposisi-left-side-item text1="Indeks" text2="{{ $suratMasuk->index }}" />
                <x-desktop-disposisi-left-side-item text1="Nomor Surat" text2="{{ $suratMasuk->nomorSurat }}" />
                <x-desktop-disposisi-left-side-item text1="Tanggal Surat" text2="{{ $suratMasuk->tanggalSurat }}" />
                <x-desktop-disposisi-left-side-item text1="Tanggal Agenda" text2="{{ $suratMasuk->tanggalAgenda }}" />
                <x-desktop-disposisi-left-side-item text1="Pengirim" text2="{{ $suratMasuk->pengirim }}" />
                <x-desktop-disposisi-left-side-item text1="Perihal" text2="{{ $suratMasuk->perihal }}" />
                <x-desktop-disposisi-left-side-item-viewdownload filePath="{{ $suratMasuk->filePath }}"
                    fileName="{{ $suratMasuk->fileName }}" />
            </x-desktop-disposisi-left-side>


            <x-desktop-disposisi-right-side>
                <x-desktop-disposisi-right-side-top-item>
                    <x-desktop-disposisi-title-component text="Riwayat Terusan" />
                    @if ($distribusiSurat->isNotEmpty())
                        @foreach ($distribusiSurat as $ds)
                            <x-desktop-disposisi-right-side-top-item-child
                                pengirim="{{ $ds->pengirimDisposisi->namaJabatan }}"
                                penerima="{{ $ds->tujuanDisposisi->namaJabatan }}" instruksi="{{ $ds->instruksi }}"
                                waktu="{{ $ds->tanggalDiteruskan }}" />
                        @endforeach
                    @endif
                </x-desktop-disposisi-right-side-top-item>

                @if ($suratMasuk->statusArsip == 1 && auth()->user()->id == 1)
                    <x-desktop-disposisi-buka-arsip idSuratMasuk="{{ $suratMasuk->id }}" />
                @else
                    <x-desktop-teruskan-arsipkan :idSuratMasuk="$suratMasuk->id" :terusan="$terusan" />
                @endif

            </x-desktop-disposisi-right-side>
        </x-desktop-disposisi-wrapper>

        <x-mobile-card-container>
            <x-mobile-card-border>
                <div class="text-center font-semibold p-2">Informasi Surat</div>
                <x-mobile-card-text-bold text="Perihal: {{ $suratMasuk->perihal }}" />
                <x-mobile-card-text-normal text="Sifat: {{ $suratMasuk->sifatSurat }}" />
                <x-mobile-card-text-normal text="Nomor: {{ $suratMasuk->nomorSurat }}" />
                <x-mobile-card-text-normal text="Dari: {{ $suratMasuk->pengirim }}" />
                <x-mobile-card-text-lite text="Tgl Surat: {{ $suratMasuk->tanggalSurat }}" />
                <x-mobile-card-text-lite text="Tgl Agenda: {{ $suratMasuk->tanggalSurat }}" />
                <x-mobile-card-text-badge text="{{ $suratMasuk->status }}" />
                <div class="flex justify-end">
                    <form action="/unduh-disposisi" method="post">
                        @csrf
                        <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
                        <x-submit-button-with-tooltip tooltip="Download" variant="success">
                            Unduh Lembar Disposisi
                        </x-submit-button-with-tooltip>
                    </form>
                </div>
            </x-mobile-card-border>

            <x-mobile-card-border>
                <div class="text-center font-semibold p-2">Riwayat Terusan</div>
                @if ($distribusiSurat->isNotEmpty())
                    @foreach ($distribusiSurat as $ds)
                        <x-desktop-disposisi-right-side-top-item-child pengirim="{{ $ds->pengirimDisposisi->namaJabatan }}"
                            penerima="{{ $ds->tujuanDisposisi->namaJabatan }}" instruksi="{{ $ds->instruksi }}"
                            waktu="{{ $ds->tanggalDiteruskan }}" />
                    @endforeach
                @endif
            </x-mobile-card-border>

            <x-mobile-card-border>
                <div class="text-center font-semibold p-2">Teruskan Surat</div>
                @if ($suratMasuk->statusArsip == 1 && auth()->user()->id == 1)
                    <form action="/surat-masuk/buka-arsip" method="post" id="bukaArsipForm"
                        class="flex justify-center items-center">
                        @csrf
                        <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
                        <x-green-submit-button-option-form formId="bukaArsipForm">
                            Buka Arsip
                        </x-green-submit-button-option-form>
                    </form>
                @else
                    {{-- FORM TERUSKAN --}}
                    <div id="teruskanInputSection">
                        <form action="/surat-masuk/teruskan" id="formTeruskanMobile" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="flex justify-evenly">
                                <input type="hidden" name="idPengirimDisposisi" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">

                                <div>
                                    <x-dropdown-input-no-label labelPilihan="Pilih Tujuan Terusan" :name="'idTujuanDisposisi'"
                                        :id="'idTujuanDisposisi'" :options="$terusan" :required="true" />
                                </div>

                                <div>
                                    <x-file-input-no-label id="fileLampiranTeruskan" name="fileLampiran"
                                        :required="false" />
                                </div>
                            </div>

                            <div>
                                <x-text-area-input-no-label placeholder="Masukkan Instruksi terusan ..." name="instruksi"
                                    id="instruksiTeruskan" value="{{ old('instruksi') }}" :required="true" />
                            </div>
                            <div id="teruskanActionSection" class="flex justify-center">
                                <x-green-submit-button-option-form formId="formTeruskanMobile">
                                    Teruskan
                                </x-green-submit-button-option-form>
                            </div>
                        </form>
                    </div>

                    <hr class="my-4">

                    <div class="text-center font-semibold p-2">Arsipkan Surat</div>

                    {{-- FORM ARSIPKAN --}}
                    <div id="arsipkanInputSection">
                        <form action="/surat-masuk/arsipkan" id="formArsipkanMobile" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
                            <input type="hidden" name="idTujuanDisposisi" value="1">
                            <input type="hidden" name="idPengirimDisposisi" value="{{ auth()->user()->id }}">

                            <div class="flex justify-center">
                                <x-file-input-no-label id="fileLampiranArsip" name="fileLampiran" :required="false" />
                            </div>

                            <div>
                                <x-text-area-input-no-label placeholder="Masukkan keterangan arsip ..." name="instruksi"
                                    id="instruksiArsip" value="{{ old('instruksi') }}" :required="true" />
                            </div>
                            <div id="arsipkanActionSection" class="flex justify-center">
                                <x-green-submit-button-option-form formId="formArsipkanMobile">
                                    Arsipkan
                                </x-green-submit-button-option-form>
                            </div>
                        </form>
                    </div>
                @endif
            </x-mobile-card-border>
        </x-mobile-card-container>
    </x-default-page-container>
@endsection
