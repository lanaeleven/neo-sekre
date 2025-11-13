@extends('layouts.main')

@section('container')
    <div>
        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <a href="/surat-masuk/index?tahun={{ config('app.tahun') }}" class="btn btn-warning btn-sm"><i
                        class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Tambah Surat Masuk</h3>
            </div>
            <div>

            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <form method="post" id="formTambah" action="/surat-masuk/tambah" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="idPosisiDisposisi" value="1">
                    <input type="hidden" name="status" value="Belum Diteruskan">

                    <div class="row mb-3">
                        <label for="tanggalAgenda" class="col-sm-3 col-form-label">Tanggal Agenda</label>
                        <div class="col-sm-9">
                            <input name="tanggalAgenda" type="date" class="form-control" id="tanggalAgenda"
                                value="{{ old('tanggalAgenda') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="sifatSurat" class="col-sm-3 col-form-label">Sifat Surat</label>
                        <div class="col-sm-9">
                            <select name="sifatSurat" class="form-select" id="sifatSurat" required>
                                <option value="">Pilih Sifat Surat</option>
                                <option value="Biasa" @if (old('sifatSurat') == 'Biasa') selected @endif>Biasa</option>
                                <option value="Rahasia" @if (old('sifatSurat') == 'Rahasia') selected @endif>Rahasia</option>
                                <option value="Segera" @if (old('sifatSurat') == 'Segera') selected @endif>Segera</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nomorSurat" class="col-sm-3 col-form-label">Nomor Surat</label>
                        <div class="col-sm-9">
                            <input name="nomorSurat" type="text" class="form-control" id="nomorSurat"
                                value="{{ old('nomorSurat') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tanggalSurat" class="col-sm-3 col-form-label">Tanggal Surat</label>
                        <div class="col-sm-9">
                            <input name="tanggalSurat" type="date" class="form-control" id="tanggalSurat"
                                value="{{ old('tanggalSurat') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="lampiran" class="col-sm-3 col-form-label">Lampiran</label>
                        <div class="col-sm-9">
                            <select name="lampiran" class="form-select" id="lampiran" required>
                                <option value="">Ada / Tidak Ada</option>
                                <option value="Ada" @if (old('lampiran') == 'Ada') selected @endif>Ada</option>
                                <option value="Tidak Ada" @if (old('lampiran') == 'Tidak Ada') selected @endif>Tidak Ada
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="pengirim" class="col-sm-3 col-form-label">Pengirim</label>
                        <div class="col-sm-9">
                            <input name="pengirim" type="text" class="form-control" id="pengirim"
                                value="{{ old('pengirim') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="idPengirim" class="col-sm-3 col-form-label">User</label>
                        <div class="col-sm-9">
                            {{-- <select name="idPengirim" class="form-select" id="idPengirim" required>
                    <option value="">Pilih User</option>
                    @foreach ($pengirim as $p)
                  
                    <option value="{{ $p->id }}" @if (old('idPengirim') == $p->id)
                      selected
                      @endif>{{ $p->namaJabatan }}</option>

                    @endforeach
                    <option value="lainnya">Lainnya</option>
                  </select> --}}
                            <select name="idPengirim" id="idPengirim" class="form-select select2-single" required>
                                <option value="">Pilih User</option>
                                @foreach ($pengirim as $p)
                                    <option value="{{ $p->id }}" @if (old('idPengirim') == $p->id) selected @endif>
                                        {{ $p->namaJabatan }}</option>
                                @endforeach
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="direksi" class="col-sm-3 col-form-label">Direktorat</label>
                        <div class="col-sm-9">
                            <select name="direksi" class="form-select" id="direksi" required>
                                <option value="">Pilih Direksi</option>
                                @foreach ($direksi as $d)
                                    <option value="{{ $d->id }}" @if (old('direksi') == $d->id) selected @endif>
                                        {{ $d->namaDireksi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="perihal" class="col-sm-3 col-form-label">Perihal</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="perihal" id="perihal" rows="3" required>{{ old('perihal') }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="fileSurat" class="col-sm-3 col-form-label">Upload Surat</label>
                        <div class="col-sm-9">
                            <input name="fileSurat" class="form-control @error('fileSurat') is-invalid @enderror"
                                type="file" id="fileSurat" required>
                            @error('fileSurat')
                                <div id="fileSurat" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div>
                            <button type="submit" class="btn btn-success mt-3">Tambah
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                    id="spinnerTambah"></span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="/js/multiple-select.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // spinner tombol tambah
            var formTambah = document.getElementById('formTambah');
            formTambah.addEventListener('submit', function(event) {
                var submitButtonTambah = formTambah.querySelector('button[type="submit"]');
                if (submitButtonTambah) {
                    submitButtonTambah.disabled = true;
                    document.getElementById('spinnerTambah').classList.remove('d-none');
                }
            });
        });
    </script>
@endsection
