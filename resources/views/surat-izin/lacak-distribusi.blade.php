@extends('layouts.main')

@section('container')
    {{-- Animations --}}
    <x-animations-style />

    <x-default-page-container>

        <x-navbar-form title="Disposisi Surat" closeUrl="/surat-izin/index" />

        <x-desktop-disposisi-wrapper>
            <x-desktop-disposisi-left-side>
                <x-desktop-disposisi-title-component text="Informasi Surat" />
                <div class="flex justify-center">
                    <form action="/unduh-disposisi-surat-izin" method="post">
                        @csrf
                        <input type="hidden" name="idSuratIzin" value="{{ $suratIzin->id }}">
                        <x-submit-button-with-tooltip tooltip="Download" variant="success">
                            Unduh Lembar Disposisi
                        </x-submit-button-with-tooltip>
                    </form>
                </div>
                <x-desktop-disposisi-left-side-item text1="Sifat Surat" text2="{{ $suratIzin->sifatSurat }}" />
                <x-desktop-disposisi-left-side-item text1="Status" text2="{{ $suratIzin->status }}" />
                <x-desktop-disposisi-left-side-item text1="Indeks" text2="{{ $suratIzin->index }}" />
                <x-desktop-disposisi-left-side-item text1="Nomor Surat" text2="{{ $suratIzin->nomorSurat }}" />
                <x-desktop-disposisi-left-side-item text1="Tanggal Surat" text2="{{ $suratIzin->tanggalSurat }}" />
                <x-desktop-disposisi-left-side-item text1="Tanggal Agenda" text2="{{ $suratIzin->tanggalAgenda }}" />
                <x-desktop-disposisi-left-side-item text1="Pengirim" text2="{{ $suratIzin->pengirim }}" />
                <x-desktop-disposisi-left-side-item text1="Perihal" text2="{{ $suratIzin->perihal }}" />
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
            </x-desktop-disposisi-right-side>
        </x-desktop-disposisi-wrapper>

        <x-mobile-card-container>
            <x-mobile-card-border>
                <div class="text-center font-semibold p-2">Informasi Surat</div>
                <x-mobile-card-text-bold text="Perihal: {{ $suratIzin->perihal }}" />
                <x-mobile-card-text-normal text="Sifat: {{ $suratIzin->sifatSurat }}" />
                <x-mobile-card-text-normal text="Nomor: {{ $suratIzin->nomorSurat }}" />
                <x-mobile-card-text-normal text="Dari: {{ $suratIzin->pengirim }}" />
                <x-mobile-card-text-lite text="Tgl Surat: {{ $suratIzin->tanggalSurat }}" />
                <x-mobile-card-text-lite text="Tgl Agenda: {{ $suratIzin->tanggalSurat }}" />
                <x-mobile-card-text-badge text="{{ $suratIzin->status }}" />
                <div class="flex justify-end">
                    <form action="/unduh-disposisi" method="post">
                        @csrf
                        <input type="hidden" name="idSuratIzin" value="{{ $suratIzin->id }}">
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
        </x-mobile-card-container>


    </x-default-page-container>


@endsection
