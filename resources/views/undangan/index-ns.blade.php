@extends('layouts.main')

@section('container')
    <div>
        <x-default-notif />
        <x-title-with-back-button :title="$judul" backUrl="/" />

        <div>
            <form class="row g-3" action="/undangan/index/ns">
                <div class="row g-3">
                    <x-input-field-filter :isLabel="true" label="Tanggal Awal" name="tanggalAwal" type="date" />
                    <x-input-field-filter :isLabel="true" label="Tanggal Akhir" name="tanggalAkhir" type="date" />
                    <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="index" />
                    <x-input-field-filter :isLabel="false" name="judul" type="text" placeholder="judul" />
                    <x-input-field-filter :isLabel="false" name="tempatKegiatan" type="text" placeholder="tempat" />
                    <x-filter-submit-button />
                </div>
            </form>
        </div>

        @if ($undangan->isEmpty())
            <x-empty-data data='{{ $judul }}' />
        @else
            {{-- start set data table --}}
            @php
                $tableHeader = ['Indeks', 'Judul', 'Tempat', 'Waktu Kegiatan', 'Aksi'];
                $rows = [];
                foreach ($undangan as $u) {
                    $waktu = \Carbon\Carbon::parse($u->waktuKegiatan);
                    $rows[] = [
                        $u->index,
                        $u->judul,
                        $u->tempatKegiatan,
                        $waktu->translatedFormat('l, j F Y') . ' - ' . $waktu->translatedFormat('H:i'),
                        '<button class="mt-1 btn btn-sm btn-warning" data-isi="' . htmlspecialchars($u->isi, ENT_QUOTES) . '" onclick="liatData(this)"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></button>' .
                        ($u->filePath
                            ? '<a href="' . asset('storage/' . $u->filePath) . '" class="mt-1 btn btn-sm btn-secondary" target="_blank"><i class="fa-solid fa-file" style="color: #ffffff;"></i></a>'
                            : ''),
                    ];
                }
            @endphp
            {{-- end set data table --}}

            <x-default-table-container>
                <x-default-table :tableHeader="$tableHeader" :rows="$rows" />
            </x-default-table-container>

            <x-mobile-table-container>
                <x-mobile-table :tableHeader="$tableHeader" :rows="$rows" />
            </x-mobile-table-container>

            <div class="modal fade" id="isiModal" tabindex="-1" aria-labelledby="isiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Isi Undangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="isiContainer" style="max-height: 700px; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>

            <x-pagination-links-container>
                {{ $undangan->appends(request()->input())->links() }}
            </x-pagination-links-container>

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
