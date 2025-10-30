@extends('layouts.main')

@section('container')
    <div class="div">
    @section('container')
        <div>

            <x-title-with-back-button :title="$judul" backUrl="/" />

            <div>
                <form class="row g-3" action="/informasi/index/ns">
                    <div class="row g-3">
                        <x-input-field-filter :isLabel="true" label="Tanggal Awal" name="tanggalAwal" type="date" />
                        <x-input-field-filter :isLabel="true" label="Tanggal Akhir" name="tanggalAkhir" type="date" />
                        <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="index" />
                        <div class="col-auto">
                            <select name="jenisInformasi" class="form-select form-select-sm"
                                value="{{ request('jenisInformasi') }}">
                                <option value="">Semua Jenis Informasi</option>
                                @foreach ($jenisInformasi as $ji)
                                    <option value="{{ $ji->id }}"
                                        {{ request('jenisInformasi') == $ji->id ? 'selected' : '' }}>{{ $ji->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-field-filter :isLabel="false" name="judul" type="text" placeholder="judul" />
                        <x-filter-submit-button />
                    </div>
                </form>
            </div>

            @if ($informasi->isEmpty())
                <x-empty-data data='{{ $judul }}' />
            @else
                {{-- start set data table --}}
                @php
                    $tableHeader = ['Indeks', 'Judul', 'Jenis', 'Tanggal', 'Aksi'];
                @endphp
                @foreach ($informasi as $i)
                    @php
                        $rows[] = [
                            $i->index,
                            $i->judul,
                            $i->jenisinformasi->nama,
                            $i->tanggalSurat,
                            '<a href="' .
                            asset('storage/' . $i->filePath) .
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
                    {{ $informasi->appends(request()->input())->links() }}
                </x-pagination-links-container>
            @endif
        </div>
    @endsection
