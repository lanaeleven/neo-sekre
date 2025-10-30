@extends('layouts.main')

@section('container')
    <div>

        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <a href="/informasi/index?tahun={{ config('app.tahun') }}" class="btn btn-warning btn-sm"><i
                        class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Edit Informasi</h3>
            </div>
            <div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <form method="post" id="formEdit" action="/informasi/save" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $informasi->id }}">
                    <input type="hidden" name="index" value="{{ $informasi->index }}">
                    <input type="hidden" name="tahun" value="{{ $informasi->tahun }}">
                    <div class="row mb-3">
                        <label for="jenisInformasi" class="col-sm-3 col-form-label">Jenis Informasi</label>
                        <div class="col-sm-9">
                            <select name="jenisInformasi" class="form-select" id="jenisInformasi" required>
                                <option value="">Pilih Jenis Informasi</option>
                                @foreach ($jenisInformasi as $ji)
                                    <option value="{{ $ji->id }}" @if ($informasi->idJenisInformasi == $ji->id) selected @endif>
                                        {{ $ji->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                        <div class="col-sm-9">
                            <input name="judul" type="text" class="form-control" id="judul"
                                value="{{ $informasi->judul }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tanggalSurat" class="col-sm-3 col-form-label">Tanggal Surat</label>
                        <div class="col-sm-9">
                            <input name="tanggalSurat" type="date" class="form-control" id="tanggalSurat"
                                value="{{ $informasi->tanggalSurat }}" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="users" class="col-sm-3 col-form-label">Pilih User (bisa lebih dari satu)</label>
                        <div class="col-sm-9">
                            <select name="users[]" id="users" multiple class="form-select select2" required>
                                <option value="all">Seluruh User</option>
                                @foreach ($users as $users)
                                    <option value="{{ $users->id }}" @if ($informasi->users->contains($users->id)) selected @endif>
                                        {{ $users->namaJabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="fileSurat" class="col-sm-3 col-form-label">File Surat</label>
                        <div class="col-sm-9">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                    {{ $informasi->fileName }}
                                </div>
                                <div class="col">
                                    <a href="{{ asset('storage/' . $informasi->filePath) }}"
                                        class="mt-1 btn btn-success btn-sm" target="_blank">view</a>
                                    <a href="{{ asset('storage/' . $informasi->filePath) }}"
                                        class="mt-1 btn btn-primary btn-sm"
                                        download='{{ $informasi->fileName }}'>download</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="fileSurat" class="col-sm-3 col-form-label">Ganti File Surat</label>
                        <div class="col-sm-9">
                            <input name="fileSurat" class="form-control" type="file" id="fileSurat">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success mt-3">Simpan
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                id="spinnerEdit"></span>
                        </button>
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
