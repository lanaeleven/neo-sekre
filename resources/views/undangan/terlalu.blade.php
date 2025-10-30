@extends('layouts.main')
@section('container')
    <div>
        <x-default-notif />

        {{-- <x-title-with-add-button title="{{ $judul }}" addUrl="/undangan/tambah" /> --}}

        <div class="d-flex justify-content-between align-items-center my-2">
            <div>
            </div>
            <div>
                <h3 class="fw-semibold fs-4 text-center">{{ strtoupper($judul) }}</h3>
            </div>
            <div>
                <a href="/undangan/index" class="btn btn-sm btn-outline-primary">Coming Soon</a>
            </div>
        </div>

        <div>
            <form class="row g-3" action="">
                <x-input-field-filter :isLabel="true" label="Tgl Awal" name="tanggalAwal" type="date" />
                <x-input-field-filter :isLabel="true" label="Tgl Akhir" name="tanggalAkhir" type="date" />
                <x-input-field-filter name="index" type="number" placeholder="Index" :isSmall="true" />
                <x-input-field-filter name="judul" type="text" placeholder="Judul" />
                <x-input-field-filter name="tempatKegiatan" type="text" placeholder="Tempat" />
                <x-filter-submit-button />
            </form>
        </div>

        @if ($undanganTerlalu->isEmpty())
            <x-empty-data data='{{ $judul }}' />
        @else
            @php
                $tableHeader = ['Index', 'Judul Kegiatan', 'Tempat Kegiatan', 'Waktu Kegiatan', 'Aksi'];
                $rows = [];
                foreach ($undanganTerlalu as $u) {
                    $waktu = \Carbon\Carbon::parse($u->waktuKegiatan);
                    $rows[] = [
                        $u->index,
                        $u->judul,
                        $u->tempatKegiatan,
                        $waktu->translatedFormat('l, j F Y') . ' - ' . $waktu->translatedFormat('H:i'),
                        '<a href="/undangan/edit/' .
                        $u->id .
                        '" class="mt-1 btn btn-sm btn-primary"><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></a>
                        <button class="mt-1 btn btn-sm btn-warning" data-isi=\'' .
                        htmlspecialchars($u->isi, ENT_QUOTES) .
                        '\' onclick="liatData(this)"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></button>' .
                        ($u->filePath
                            ? '<a href="' .
                                asset('storage/' . $u->filePath) .
                                '" class="mt-1 btn btn-sm btn-secondary" target="_blank"><i class="fa-solid fa-file" style="color: #ffffff;"></i></a>'
                            : ''),
                    ];
                }
            @endphp

            <x-default-table-container>
                <x-default-table :tableHeader="$tableHeader" :rows="$rows" />
            </x-default-table-container>

            <x-mobile-table-container>
                <x-mobile-table :tableHeader="$tableHeader" :rows="$rows" />
            </x-mobile-table-container>

            <x-pagination-links-container>
                {{ $undanganTerlalu->appends(request()->input())->links() }}
            </x-pagination-links-container>

            <!-- Modal -->
            <div class="modal fade" id="isiModal" tabindex="-1" aria-labelledby="isiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Isi Undangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="isiContainer" style="max-height: 700px; overflow-y: auto;">
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function liatData(el) {
                    const isi = el.getAttribute('data-isi');
                    document.getElementById('isiContainer').innerHTML = isi;
                    new bootstrap.Modal(document.getElementById('isiModal')).show();
                }
            </script>
        @endif
    </div>
@endsection
