@extends('layouts.main')

@section('container')
    <div>
        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <a href="/undangan/index?tahun={{ config('app.tahun') }}" class="btn btn-warning btn-sm"><i
                        class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Tambah Undangan</h3>
            </div>
            <div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <form method="post" id="formTambah" action="/undangan/tambah" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                        <div class="col-sm-9">
                            <input name="judul" type="text" class="form-control" id="judul"
                                value="{{ old('judul') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tempatKegiatan" class="col-sm-3 col-form-label">Tempat Kegiatan</label>
                        <div class="col-sm-9">
                            <input name="tempatKegiatan" type="text" class="form-control" id="tempatKegiatan"
                                value="{{ old('tempatKegiatan') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="waktuKegiatan" class="col-sm-3 col-form-label">Waktu Kegiatan</label>
                        <div class="col-sm-9">
                            <input name="waktuKegiatan" type="datetime-local" class="form-control" id="waktuKegiatan"
                                value="{{ old('waktuKegiatan') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="isi" class="block text-sm font-medium leading-6 text-gray-900">Isi Undangan</label>
                        <div class="mt-2">
                            <input id="isi" type="hidden" name="isi">
                            <trix-editor input="isi" rows="3" class="trix-editor"></trix-editor>
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
                                type="file" id="fileSurat">
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
