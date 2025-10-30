@extends('layouts.main')

@section('container')
    <div>
        <x-default-notif />

        <x-title-with-add-button title="{{ $judul }}" addUrl="/surat-masuk/tambah" />
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#unduhRekapModal">
            Rekap
        </button>

        <div>
            <form class="row g-3" action="/surat-masuk/index">
                <x-input-field-filter :isLabel="false" name="tahun" type="number" placeholder="Tahun" :isSmall="true" />
                <x-input-field-filter :isLabel="true" label="Tgl Awal" name="tanggalAwal" type="date" />
                <x-input-field-filter :isLabel="true" label="Tgl Akhir" name="tanggalAkhir" type="date" />
                <x-input-field-filter :isLabel="false" name="index" type="number" placeholder="Index"
                    :isSmall="true" />
                <x-input-field-filter :isLabel="false" name="pengirim" type="text" placeholder="Pengirim" />
                <x-input-field-filter :isLabel="false" name="nomorSurat" type="text" placeholder="Nomor Surat" />
                <x-input-field-filter :isLabel="false" name="perihal" type="text" placeholder="Perihal" />
                <x-input-field-filter :isLabel="false" name="status" type="text" placeholder="Status" />
                <x-filter-submit-button />
            </form>
        </div>

        @if ($suratMasuk->isEmpty())
            <x-empty-data data='{{ $judul }}' />
        @else
            {{-- start set data table --}}
            @php
                $tableHeader = ['Indeks', 'Dari', 'Tgls Surat', 'No Surat', 'Perihal', 'Status', 'Aksi'];
            @endphp
            @foreach ($suratMasuk as $sm)
                @php
                    $rows[] = [
                        $sm->index,
                        $sm->pengirim,
                        $sm->tanggalSurat,
                        $sm->nomorSurat,
                        $sm->perihal,
                        $sm->status,
                        '
                        <a href="/surat-masuk/edit/' .
                        $sm->id .
                        '" class="mt-1 btn btn-sm btn-primary"><i
                                class="fa-solid fa-pencil" style="color: #ffffff;"></i></a>
                        <a href="' .
                        asset('storage/' . $sm->filePath) .
                        '" class="mt-1 btn btn-sm btn-secondary"
                            target="_blank"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></a>
                        <a href="/surat-masuk/lacak-distribusi/' .
                        $sm->id .
                        '"
                            class="mt-1 btn btn-sm btn-info"><i class="fa-solid fa-shoe-prints fa-rotate-270"
                                style="color: #000000;"></i></a>
                        <a href="/surat-masuk/disposisi/' .
                        $sm->id .
                        '"
                            class="mt-1 btn btn-sm btn-warning"><i class="fa-solid fa-share"
                                style="color: #000000;"></i></a>
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
                {{ $suratMasuk->appends(request()->input())->links() }}
            </x-pagination-links-container>
        @endif
    </div>

    {{-- Modal Unduh Rekap --}}
    <div class="modal fade" id="unduhRekapModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="unduhRekapModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="unduhRekapModalLabel">Rekap File Surat Masuk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" id="formRekap" action="/unduh-rekap-suratmasuk">
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
                        <button type="submit" class="btn btn-success container-fluid">Unduh Rekap
                            {{-- <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="spinnerRekap"></span> --}}
                        </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal --}}


    {{-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    // spinner tombol rekap
    var formRekap = document.getElementById('formRekap'); 
    formRekap.addEventListener('submit', function(event) {
      var submitButtonRekap = formRekap.querySelector('button[type="submit"]');
      if (submitButtonRekap) {
        submitButtonRekap.disabled = true;
        document.getElementById('spinnerRekap').classList.remove('d-none');
      }
    });
  });
</script> --}}

@endsection
