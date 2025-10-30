@extends('layouts.main')

@section('container')
    <div class="div">
    @section('container')
        <div>
            <x-title-with-back-button :title="$judul" backUrl="/" />
            
            <div>
                <form class="row g-3" action="/pks/index/ns">
                    <div class="row g-3">
                        <x-input-field-filter :isLabel="true" label="Tanggal Awal" name="tanggalAwal" type="date"/>
                        <x-input-field-filter :isLabel="true" label="Tanggal Akhir" name="tanggalAkhir"
                            type="date" />
                        <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="index" />
                        <x-input-field-filter :isLabel="false" name="tujuan" type="text" placeholder="tujuan" />
                        <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="perihal" />
                        <x-input-field-filter :isLabel="false" name="keterangan" type="text"
                            placeholder="keterangan" />
                        <x-filter-submit-button />
                    </div>
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
                            '<a href="' .
                            asset('storage/' . $p->filePath) .
                            '"class="mt-1 btn btn-sm btn-secondary" target="_blank"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></a>',
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
