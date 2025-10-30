@extends('layouts.main')
@section('container')
    <div>
        <x-default-notif />

        <x-title-with-add-button title="{{ $judul }}" addUrl="/spo/tambah" />

        {{-- <div class="d-flex justify-content-end">
            <div>
                <button class="btn btn-success btn-sm py-2 fs-6 mx-auto" data-bs-toggle="modal"
                    data-bs-target="#unduhRekapModal">Unduh Rekap</button>
            </div>
        </div> --}}

        <div>
            <form class="row g-3" action="/spo/index">
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

        @if ($spo->isEmpty())
            <x-empty-data data='{{ $judul }}' />
        @else
            {{-- start set data table --}}
            @php
                $tableHeader = ['Indeks', 'Tanggal', 'Tujuan', 'Perihal', 'Direktorat', 'Keterangan', 'Aksi'];
            @endphp
            @foreach ($spo as $s)
                @php
                    $rows[] = [
                        $s->index,
                        $s->tanggalSurat,
                        $s->tujuan,
                        $s->perihal,
                        $s->direksi->namaDireksi,
                        $s->keterangan,
                        '
                        <a href="/spo/edit/' . $s->id . '" class="mt-1 btn btn-sm btn-primary"><i
                                class="fa-solid fa-pencil" style="color: #ffffff;"></i></a>
                        <a href="'. asset('storage/' . $s->filePath) .'" class="mt-1 btn btn-sm btn-secondary"
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
                {{ $spo->appends(request()->input())->links() }}
            </x-pagination-links-container>
        @endif
    </div>

    {{-- Modal Unduh Rekap --}}
    <div class="modal fade" id="unduhRekapModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="unduhRekapModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="unduhRekapModalLabel">Rekap File Standar Prosedur Operasional</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="/unduh-rekap-spo">
                        @csrf
                        <div class="mb-3">
                            <label for="bulanRekap" class="col-form-label">Pilih Bulan</label>
                            <input type="month" id="bulanRekap" name="bulanRekap" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success container-fluid">Unduh Rekap</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}

@endsection
