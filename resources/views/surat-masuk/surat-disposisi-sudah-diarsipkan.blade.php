@extends('layouts.main')

@section('container')
    <div class="div">

        <x-title-with-back-button title="surat masuk - sudah diarsipkan" backUrl="/" />
        
        <div>
            <form class="row g-1" action="/surat-masuk/ns/sudah-diarsipkan">
                    <x-input-field-filter :isLabel="true" label="Tanggal Awal" name="tanggalAwal" type="date" />
                    <x-input-field-filter :isLabel="true" label="Tanggal Akhir" name="tanggalAkhir" type="date" />
                    <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="index" :isSmall="true" />
                    <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="pengirim" :isMedium="true" />
                    <x-input-field-filter :isLabel="false" name="nomorSurat" type="text"
                        placeholder="nomor surat" :isMedium="true" />
                    <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="perihal" :isMedium="true" />
                    <x-filter-submit-button />
            </form>
        </div>
        
        @if ($suratMasuk->isEmpty())
            <x-empty-data data='Surat Masuk yang Sudah Diarsipkan' />
        @else
            {{-- start set data table --}}
            @php
                $tableHeader = ['Indeks', 'Direktorat', 'Dari', 'Tgl Surat', 'No Surat', 'Perihal', 'Status', 'Aksi'];
            @endphp
            @foreach ($suratMasuk as $sm)
                @php
                    $rows[] = [
                        $sm->index,
                        $sm->direksi->namaDireksi ?? '',
                        $sm->pengirim,
                        $sm->tanggalSurat,
                        $sm->nomorSurat,
                        $sm->perihal,
                        $sm->status,
                        '<a href="/surat-masuk/lacak-distribusi/' .
                        $sm->id .
                        '"class="mt-1 btn btn-info" style="font-size: 0.8rem; padding: 1px 6px;"><i class="fa-solid fa-shoe-prints fa-rotate-270" style="color: #000000;"></i></a>',
                    ];
                @endphp
            @endforeach
            {{-- end set data table --}}

            <x-default-table-container>
                <x-default-table :tableHeader="$tableHeader" :rows="$rows" />
            </x-default-table-container>

            <x-mobile-table-container>
                <x-mobile-table :tableHeader="$tableHeader" :rows="$rows" />
            </x-mobile-table-container>

            <x-pagination-links-container>
                {{ $suratMasuk->appends(request()->input())->links() }}
            </x-pagination-links-container>
        @endif

    </div>
@endsection
