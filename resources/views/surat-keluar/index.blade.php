@extends('layouts.main')

    @section('container')
        <div>
            <x-default-notif />

            <x-title-with-add-button title="{{ $judul }}" addUrl="/surat-keluar/tambah" />

            {{-- @if (is_null($ket))
                <div class="d-flex justify-content-end">
                    <div>
                        <button class="btn btn-success btn-sm py-2 fs-6 mx-auto" data-bs-toggle="modal"
                            data-bs-target="#unduhRekapModal">Unduh Rekap</button>
                    </div>
                </div>
            @endif --}}

            <div>
                <form class="row g-3" action="">
                    <x-input-field-filter name="tahun" type="number" placeholder="Tahun" :isSmall="true" />
                    <x-input-field-filter :isLabel="true" label="Tgl Awal" name="tanggalAwal" type="date" />
                    <x-input-field-filter :isLabel="true" label="Tgl Akhir" name="tanggalAkhir" type="date" />
                    <x-input-field-filter name="index" type="number" placeholder="Index" :isSmall="true" />
                    <div class="col-auto">
                        <select name="jenisSurat" class="form-select form-select-sm"
                            value="{{ request('jenisSurat') }}">
                            <option value="">Semua Jenis Surat</option>
                            @foreach ($jenisSurat as $js)
                                <option value="{{ $js->id }}"
                                    {{ request('jenisSurat') == $js->id ? 'selected' : '' }}>
                                    {{ $js->kodeJenisSurat . '-' . $js->keterangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-field-filter name="tujuan" type="text" placeholder="Tujuan" />
                    <x-input-field-filter name="perihal" type="text" placeholder="Perihal" />
                    <x-input-field-filter name="keterangan" type="text" placeholder="Keterangan" />
                    <x-filter-submit-button />
                </form>
            </div>

            @if ($suratKeluar->isEmpty())
                <x-empty-data data='{{ $judul }}' />
            @else
                {{-- start set data table --}}
                @php
                    $tableHeader = ['Indeks', 'Tanggal', 'Tujuan', 'Perihal', 'Keterangan', 'Jenis', 'Aksi'];
                @endphp
                @foreach ($suratKeluar as $sk)
                    @php
                        $rows[] = [
                            $sk->index,
                            $sk->tanggalSurat,
                            $sk->tujuan,
                            $sk->perihal,
                            $sk->keterangan,
                            $sk->jenisSurat->keterangan,
                            '
                            <a href="/surat-keluar/edit/' .
                            $sk->id .
                            '"
                                class="mt-1 btn btn-sm btn-primary"><i class="fa-solid fa-pencil"
                                    style="color: #ffffff;"></i></a>
                            <a href="' .
                            asset('storage/' . $sk->filePath) .
                            '"
                                class="mt-1 btn btn-sm btn-secondary" target="_blank"><i class="fa-solid fa-eye"
                                    style="color: #ffffff;"></i></a>
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
                    {{ $suratKeluar->appends(request()->input())->links() }}
                </x-pagination-links-container>
            @endif
        </div>

        {{-- Modal Unduh Rekap --}}
        <div class="modal fade" id="unduhRekapModal" data-bs-backdrop="static" tabindex="-1"
            aria-labelledby="unduhRekapModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="unduhRekapModalLabel">Rekap File Surat Keluar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="/unduh-rekap-suratkeluar">
                            @csrf
                            {{-- <div class="mb-3">
                <label for="bulanRekap" class="col-form-label">Pilih Bulan</label>
                <input type="month" id="bulanRekap" name="bulanRekap"  class="form-control" required>
              </div> --}}
                            <div class="col-auto">
                                <label for="awal" class="col-form-label"><small>Awal</small></label>
                            </div>
                            <div class="col-auto mb-3">
                                <input name="awal" type="date" id="awal" class="form-control form-control-sm">
                            </div>
                            <div class="col-auto">
                                <label for="akhir" class="col-form-label"><small>Akhir</small></label>
                            </div>
                            <div class="col-auto mb-3">
                                <input name="akhir" type="date" id="akhir" class="form-control form-control-sm">
                            </div>
                            <button type="submit" class="btn btn-success container-fluid">Unduh Rekap</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end of modal --}}

    @endsection
