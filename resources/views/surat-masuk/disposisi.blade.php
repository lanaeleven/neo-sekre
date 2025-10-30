@extends('layouts.main')

@section('container')

    <div>
        <div class="d-flex justify-content-between align-items-center my-2">
            <div>
                <button onclick="history.back()" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-left"
                        style="color: #000;"></i></button>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Disposisi Surat</h3>
            </div>
            <div>
                <form action="/unduh-disposisi" method="post">
                    @csrf
                    <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
                    <button type="submit" class="btn btn-success btn-sm">Unduh Lembar Disposisi</button>
                </form>

            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-9 d-none d-md-block">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th colspan="2" class="text-center">
                                Status: {{ $suratMasuk->status }}
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <table class="table">
                                    <tbody>

                                        <tr>
                                            <td>Indeks</td>
                                            <td>{{ $suratMasuk->index }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Surat</td>
                                            <td>{{ $suratMasuk->tanggalSurat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Dari</td>
                                            <td>
                                                {{ $suratMasuk->pengirim }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Direksi</td>
                                            <td>{{ $suratMasuk->direksi->namaDireksi }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Nomor Surat</td>
                                            <td>{{ $suratMasuk->nomorSurat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Agenda</td>
                                            <td>{{ $suratMasuk->tanggalAgenda }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sifat Surat</td>
                                            <td>{{ $suratMasuk->sifatSurat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Perihal</td>
                                            <td>{{ $suratMasuk->perihal }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div>
                                        File surat: {{ $suratMasuk->fileName }}
                                    </div>
                                    <div class="ms-2">
                                        <a href="{{ asset('storage/' . $suratMasuk->filePath) }}"
                                            class="mt-1 btn btn-success btn-sm" target="_blank">view</a>
                                        <a href="{{ asset('storage/' . $suratMasuk->filePath) }}"
                                            class="mt-1 btn btn-primary btn-sm"
                                            download='{{ $suratMasuk->fileName }}'>download</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>

            {{-- Detail Surat untuk mobile device --}}
            <div class="col-12 d-md-none d-lg-none d-xl-none d-xxl-none mb-5">
                <div class="card shadow">
                    <table class="table table-bordered">
                        <tr>
                            <th>Status</th>
                            <td>{{ $suratMasuk->status }}</td>
                        </tr>
                        <tr>
                            <th>Indeks</th>
                            <td>{{ $suratMasuk->index }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Surat</th>
                            <td>{{ $suratMasuk->nomorSurat }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Surat</th>
                            <td>{{ $suratMasuk->tanggalSurat }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Agenda</th>
                            <td>{{ $suratMasuk->tanggalAgenda }}</td>
                        </tr>
                        <tr>
                            <th>Sifat Surat</th>
                            <td>{{ $suratMasuk->sifatSurat }}</td>
                        </tr>
                        <tr>
                            <th>Direksi</th>
                            <td>{{ $suratMasuk->direksi->namaDireksi }}</td>
                        </tr>
                        <tr>
                            <th>Perihal</th>
                            <td>{{ $suratMasuk->perihal }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center"><a
                                    href="{{ asset('storage/' . $suratMasuk->filePath) }}"
                                    class="mt-1 btn btn-primary btn-sm" download='{{ $suratMasuk->fileName }}'>Download
                                    Surat</a></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

        @if ($distribusiSurat->isNotEmpty())
            <div class="row d-flex justify-content-center">
                <h5 class="text-center fw-bold">Terusan Sebelumnya</h5>
                @foreach ($distribusiSurat as $ds)
                    <div class="col-9 my-3 d-none d-md-block">
                        <form>
                            <div class="row mb-3">
                                <label for="tujuan" class="col-sm-3 col-form-label">Oleh</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text"
                                        value="{{ $ds->pengirimDisposisi->namaJabatan }}"
                                        aria-label="Disabled input example" disabled readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tujuan" class="col-sm-3 col-form-label">Kepada</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text"
                                        value="{{ $ds->tujuanDisposisi->namaJabatan }}" aria-label="Disabled input example"
                                        disabled readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tujuan" class="col-sm-3 col-form-label">Tanggal Diteruskan</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="datetime" value="{{ $ds->tanggalDiteruskan }}"
                                        aria-label="Disabled input example" disabled readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="instruksi" class="col-sm-3 col-form-label">Instruksi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="instruksi" id="instruksi" rows="3" disabled readonly>{{ $ds->instruksi }}</textarea>
                                </div>
                            </div>

                        </form>
                        <hr>
                    </div>

                    {{-- Terusan surat untuk mobile device --}}
                    <div class="d-md-none d-lg-none d-xl-none d-xxl-none container my-2">
                        <div class="card">
                            <div class="card-header fw-bold">
                                Oleh: {{ $ds->pengirimDisposisi->namaJabatan }}
                            </div>
                            <div class="card-header fw-bold">
                                Kepada: {{ $ds->tujuanDisposisi->namaJabatan }}
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Tanggal Diteruskan: {{ $ds->tanggalDiteruskan }}</li>
                            </ul>
                            <div class="card-footer">
                                Instruksi: {{ $ds->instruksi }}
                            </div>
                        </div>
                        <hr>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="row d-flex justify-content-center">
            @if ($suratMasuk->statusArsip == 0)
                <h5 class="text-center fw-bold mb-3">Teruskan Surat</h5>
                <div class="col-12 col-md-9">
                    <form action="/surat-masuk/teruskan" id="formTeruskan" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="idPengirimDisposisi" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">

                        <div class="row mb-3">
                            <label for="idTujuanDisposisi" class="col-sm-3 col-form-label">Teruskan Kepada</label>
                            <div class="col-sm-9">
                                {{-- <select name="idTujuanDisposisi" class="form-select" id="idTujuanDisposisi" required>
                                    <option value="">Pilih Tujuan Disposisi</option>
                                    @foreach ($terusan as $t)
                                        <option value="{{ $t->id }}">{{ $t->namaJabatan }}</option>
                                    @endforeach
                                </select> --}}

                                <select name="idTujuanDisposisi" id="idTujuanDisposisi" class="form-select select2-single"
                                    required>
                                    <option value="">Pilih Tujuan Disposisi</option>
                                    @foreach ($terusan as $t)
                                        <option value="{{ $t->id }}">{{ $t->namaJabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="instruksi" class="col-sm-3 col-form-label">Instruksi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="instruksi" id="instruksi" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fileLampiran" class="col-sm-3 col-form-label">Tambah Lampiran (Opsional)</label>
                            <div class="col-sm-9">
                                <input name="fileLampiran"
                                    class="form-control @error('fileLampiran') is-invalid @enderror" type="file"
                                    id="fileLampiran">
                                @error('fileLampiran')
                                    <div id="fileLampiran" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <div>
                                <button type="button" class="btn btn-success mx-3" data-bs-toggle="modal"
                                    data-bs-target="#modalTeruskan">Teruskan</button>
                            </div>

                            <!-- Modal Tombol Teruskan -->
                            <div class="modal fade" data-bs-backdrop="static" id="modalTeruskan" tabindex="-1"
                                aria-labelledby="modalTeruskanLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modalTeruskanLabel">Teruskan Surat</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Pastikan tujuan disposisi dan instruksi sudah benar
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <button type="submit" class="btn btn-success">Teruskan
                                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                                    aria-hidden="true" id="spinnerTeruskan"></span>
                                            </button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
            @endif
            @if ($suratMasuk->statusArsip == 0)
                <form action="/surat-masuk/arsipkan" id="formArsipkan" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
                    <input type="hidden" name="idTujuanDisposisi" value="1">
                    <input type="hidden" name="idPengirimDisposisi" value="{{ auth()->user()->id }}">
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalArsipkan">Arsipkan</button>
                    </div>

                    <!-- Modal Tombol Arsipkan -->
                    <div class="modal fade" data-bs-backdrop="static" id="modalArsipkan" tabindex="-1"
                        aria-labelledby="modalArsipkanLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalArsipkanLabel">Arsipkan Surat</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Surat yang sudah diarsipkan tidak akan bisa diteruskan lagi. Apakah Anda Yakin?
                                    <div class="row my-3">
                                        <label for="instruksi" class="col-sm-3 col-form-label">Keterangan</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="instruksi" id="instruksi" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <label for="fileLampiranArsip" class="col-sm-3 col-form-label">Lampiran
                                            (Opsional)</label>
                                        <div class="col-sm-9">
                                            <input name="fileLampiranArsip"
                                                class="form-control @error('fileLampiranArsip') is-invalid @enderror"
                                                type="file" id="fileLampiranArsip">
                                            @error('fileLampiranArsip')
                                                <div id="fileLampiranArsip" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Arsipkan
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                            aria-hidden="true" id="spinnerArsipkan"></span>
                                    </button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif

            @if ($suratMasuk->statusArsip == 1 && auth()->user()->id == 1)
                <form action="/surat-masuk/buka-arsip" method="post">
                    @csrf
                    <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
                    <div class="d-flex justify-content-center mt-3">
                        <div>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modalBukaArsip">Buka Arsip</button>
                        </div>
                    </div>

                    <!-- Modal Tombol Buka Arsip -->
                    <div class="modal fade" data-bs-backdrop="static" id="modalBukaArsip" tabindex="-1"
                        aria-labelledby="modalBukaArsipLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalBukaArsipLabel">Buka Arsip</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Anda Yakin Ingin Membuka Status Arsip?
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="submit" class="btn btn-danger">Buka Arsip</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="/js/multiple-select.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // spinner tombol teruskan
            var formTeruskan = document.getElementById('formTeruskan');
            formTeruskan.addEventListener('submit', function(event) {
                var submitButtonTeruskan = formTeruskan.querySelector('button[type="submit"]');
                if (submitButtonTeruskan) {
                    submitButtonTeruskan.disabled = true;
                    document.getElementById('spinnerTeruskan').classList.remove('d-none');
                }
            });

            // spinner tombol artsipkan
            var formArsipkan = document.getElementById('formArsipkan');
            formArsipkan.addEventListener('submit', function(event) {
                var submitButtonArsipkan = formArsipkan.querySelector('button[type="submit"]');
                if (submitButtonArsipkan) {
                    submitButtonArsipkan.disabled = true;
                    document.getElementById('spinnerArsipkan').classList.remove('d-none');
                }
            });


        });
    </script>
@endsection
