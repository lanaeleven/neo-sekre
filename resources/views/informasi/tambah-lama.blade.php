@extends('layouts.main')

@section('container')
    <div>
        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <a href="/informasi/index?tahun={{ config('app.tahun') }}" class="btn btn-warning btn-sm"><i
                        class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Tambah Informasi</h3>
            </div>
            <div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <form method="post" id="formTambah" action="/informasi/tambah" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label for="jenisInformasi" class="col-sm-3 col-form-label">Jenis Informasi</label>
                        <div class="col-sm-9">
                            <select name="jenisInformasi" class="form-select" id="jenisInformasi" required>
                                <option value="">Pilih Jenis Informasi</option>
                                @foreach ($jenisInformasi as $jr)
                                    <option value="{{ $jr->id }}" @if ($jr->id == old('jenisInformasi')) selected @endif>
                                        {{ $jr->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                        <div class="col-sm-9">
                            <input name="judul" type="text" class="form-control" id="judul"
                                value="{{ old('judul') }}" required>
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
                        <label for="users" class="col-sm-3 col-form-label">Pilih User (bisa lebih dari satu)</label>
                        <div class="col-sm-9">
                            <select name="users[]" id="users" multiple class="form-select select2" required>
                                <option value="all">Seluruh User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->namaJabatan }}</option>
                                @endforeach
                            </select>
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
