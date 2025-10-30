@extends('layouts.main')
@section('container')
    <div>
        <x-default-notif />

        <x-title-with-add-button title="{{ $judul }}" addUrl="/pks/tambah" />

        <div>
            <form class="row g-3" action="">
                <x-input-field-filter name="tahun" type="number" placeholder="Tahun" :isSmall="true" />
                <x-input-field-filter :isLabel="true" label="Tgl Awal" name="tanggalAwal" type="date" />
                <x-input-field-filter :isLabel="true" label="Tgl Akhir" name="tanggalAkhir" type="date" />
                <x-input-field-filter name="index" type="number" placeholder="Index" :isSmall="true" />
                <x-input-field-filter name="tujuan" type="text" placeholder="Tujuan" />
                <x-input-field-filter name="perihal" type="text" placeholder="Perihal" />
                <x-input-field-filter name="keterangan" type="text" placeholder="Keterangan" />
                <x-filter-submit-button />
            </form>
        </div>

        @if ($pks->isEmpty())
            <x-empty-data data='{{ $judul }}' />
        @else
            {{-- start set data table --}}
            @php
                $tableHeader = ['Indeks', 'Tanggal', 'Tujuan', 'Perihal', 'Direktorat', 'Keterangan', 'Aksi'];
            @endphp
            @foreach ($pks as $p)
                @php
                    $rows[] = [
                        $p->index,
                        $p->tanggalSurat,
                        $p->tujuan,
                        $p->perihal,
                        $p->direksi->namaDireksi,
                        $p->keterangan,
                        '
                        <a href="/pks/edit/' .
                        $p->id .
                        '" class="mt-1 btn btn-sm btn-primary"><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></a>
                        <a href="' .
                        asset('storage/' . $p->filePath) .
                        '" class="mt-1 btn btn-sm btn-secondary"
                            target="_blank"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></a>
                        ',
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
                {{ $pks->appends(request()->input())->links() }}
            </x-pagination-links-container>
        @endif
    </div>
@endsection
