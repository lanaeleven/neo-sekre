@extends('layouts.main')
@section('container')
    <div>
        <x-default-notif />

        <x-title-with-add-button title="{{ $judul }}" addUrl="/informasi/tambah" />

        <div>
            <form class="row g-3" action="">
                <x-input-field-filter name="tahun" type="number" placeholder="Tahun" :isSmall="true" />
                <x-input-field-filter :isLabel="true" label="Tgl Awal" name="tanggalAwal" type="date" />
                <x-input-field-filter :isLabel="true" label="Tgl Akhir" name="tanggalAkhir" type="date" />
                <x-input-field-filter name="index" type="number" placeholder="Index" :isSmall="true" />
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
                <x-input-field-filter name="judul" type="text" placeholder="Judul" />
                <x-filter-submit-button />
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
                        '
                        <a href="/informasi/edit/' .
                        $i->id .
                        '" class="mt-1 btn btn-sm btn-primary"><i
                                class="fa-solid fa-pencil" style="color: #ffffff;"></i></a>
                        <a href="' .
                        asset('storage/' . $i->filePath) .
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
                {{ $informasi->appends(request()->input())->links() }}
            </x-pagination-links-container>
        @endif
    </div>
@endsection
