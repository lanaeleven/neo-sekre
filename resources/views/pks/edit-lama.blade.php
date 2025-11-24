@extends('layouts.main')

@section('container')
    <div>

        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <a href="/pks/index?tahun={{ config('app.tahun') }}" class="btn btn-warning btn-sm"><i
                        class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Edit Perjanjian Kerja Sama</h3>
            </div>
            <div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <form method="post" id="formEdit" action="/pks/save" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pks->id }}">
                    <input type="hidden" name="index" value="{{ $pks->index }}">
                    <input type="hidden" name="tahun" value="{{ $pks->tahun }}">
                    <div class="row mb-3">
                        <label for="tanggalSurat" class="col-sm-3 col-form-label">Tanggal Surat</label>
                        <div class="col-sm-9">
                            <input name="tanggalSurat" type="date" class="form-control" id="tanggalSurat"
                                value="{{ $pks->tanggalSurat }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tujuan" class="col-sm-3 col-form-label">Tujuan</label>
                        <div class="col-sm-9">
                            <input name="tujuan" type="text" class="form-control" id="tujuan"
                                value="{{ $pks->tujuan }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="perihal" class="col-sm-3 col-form-label">Perihal</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="perihal" id="perihal" rows="3" required>{{ $pks->perihal }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="direktorat" class="col-sm-3 col-form-label">Direktorat</label>
                        <div class="col-sm-9">
                            <select name="direksi" class="form-select" id="direktorat" required>
                                <option value="">Pilih Direksi</option>
                                @foreach ($direksi as $d)
                                    <option value="{{ $d->id }}" @if ($pks->idDireksi == $d->id) selected @endif>
                                        {{ $d->namaDireksi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="users" class="col-sm-3 col-form-label">Pilih User (bisa lebih dari satu)</label>
                        <div class="col-sm-9">
                            <select name="users[]" id="users" multiple class="form-select select2" required>
                                <option value="all">Seluruh User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if ($pks->users->contains($user->id)) selected @endif>
                                        {{ $user->namaJabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="fileSurat" class="col-sm-3 col-form-label">File Surat</label>
                        <div class="col-sm-9">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                    {{ $pks->fileName }}
                                </div>
                                <div class="col">
                                    <a href="{{ asset('storage/' . $pks->filePath) }}"
                                        class="mt-1 btn btn-success btn-sm" target="_blank">view</a>
                                    <a href="{{ asset('storage/' . $pks->filePath) }}"
                                        class="mt-1 btn btn-primary btn-sm"
                                        download='{{ $pks->fileName }}'>download</a>
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

                    <div class="row mb-3">
                        <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea name="keterangan" class="form-control" name="keterangan" id="keterangan" rows="3">{{ $pks->keterangan }}</textarea>
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
