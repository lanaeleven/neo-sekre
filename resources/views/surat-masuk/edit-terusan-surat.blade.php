@extends('layouts.main')

@section('container')

    <div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <a href="/surat-masuk/lacak-distribusi/{{ $idSuratMasuk }}" class="btn btn-warning btn-sm"><i
                        class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Edit Terusan Surat</h3>
            </div>
            <div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <form method="POST" id="formEdit" action="/terusan-surat">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idTerusanSurat" value="{{ $terusanSurat->id }}">
                    <input type="hidden" name="idSuratMasuk" value="{{ $idSuratMasuk }}">

                    <div class="row mb-3">
                        <label for="tujuan" class="col-sm-3 col-form-label">Oleh</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text"
                                value="{{ $terusanSurat->pengirimDisposisi->namaJabatan }}"
                                aria-label="Disabled input example" disabled readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tujuan" class="col-sm-3 col-form-label">Kepada</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text"
                                value="{{ $terusanSurat->tujuanDisposisi->namaJabatan }}"
                                aria-label="Disabled input example" disabled readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="waktuDiteruskan" class="col-sm-3 col-form-label">Waktu Diteruskan</label>
                        <div class="col-sm-9">
                            <input name="waktuDiteruskan" type="datetime-local" class="form-control" id="waktuDiteruskan"
                                value="{{ \Carbon\Carbon::parse($terusanSurat->tanggalDiteruskan)->format('Y-m-d\TH:i') }}"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="instruksi" class="col-sm-3 col-form-label">Instruksi</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="instruksi" id="instruksi" rows="3" disabled readonly>{{ $terusanSurat->instruksi }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div>
                            <button type="submit" class="btn btn-success mt-3">Simpan
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                    id="spinnerEdit"></span>
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
            // spinner tombol edit
            var formEdit = document.getElementById('formEdit');
            formEdit.addEventListener('submit', function(event) {
                var submitButtonEdit = formEdit.querySelector('button[type="submit"]');
                if (submitButtonEdit) {
                    submitButtonEdit.disabled = true;
                    document.getElementById('spinnerEdit').classList.remove('d-none');
                }
            });
        });
    </script>

@endsection
