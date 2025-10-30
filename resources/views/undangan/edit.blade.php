@extends('layouts.main')

@section('container')
    <div>

        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <a href="/undangan/index" class="btn btn-warning btn-sm"><i
                        class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Edit Undangan</h3>
            </div>
            <div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <form method="post" id="formEdit" action="/undangan/save" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $undangan->id }}">
                    <input type="hidden" name="index" value="{{ $undangan->index }}">
                    <input type="hidden" name="tahun" value="{{ $undangan->tahun }}">

                    <div class="row mb-3">
                        <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                        <div class="col-sm-9">
                            <input name="judul" type="text" class="form-control" id="judul"
                                value="{{ $undangan->judul }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tempatKegiatan" class="col-sm-3 col-form-label">tempatKegiatan</label>
                        <div class="col-sm-9">
                            <input name="tempatKegiatan" type="text" class="form-control" id="tempatKegiatan"
                                value="{{ $undangan->tempatKegiatan }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="waktuKegiatan" class="col-sm-3 col-form-label">Waktu Kegiatan</label>
                        <div class="col-sm-9">
                            <input name="waktuKegiatan" type="datetime-local" class="form-control" id="waktuKegiatan"
                                value="{{ $undangan->waktuKegiatan }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="isi" class="block text-sm font-medium leading-6 text-gray-900">Isi Undangan</label>
                        <div class="mt-2">
                            <input id="isi" type="hidden" name="isi" value="{{ $undangan->isi }}">
                            <trix-editor input="isi" rows="3" class="trix-editor"></trix-editor>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="users" class="col-sm-3 col-form-label">Pilih User (bisa lebih dari satu)</label>
                        <div class="col-sm-9">
                            <select name="users[]" id="users" multiple class="form-select select2" required>
                                <option value="all">Seluruh User</option>
                                @foreach ($users as $users)
                                    <option value="{{ $users->id }}" @if ($undangan->users->contains($users->id)) selected @endif>
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
                                    {{ $undangan->fileName }}
                                </div>
                                <div class="col">
                                    <a href="{{ asset('storage/' . $undangan->filePath) }}"
                                        class="mt-1 btn btn-success btn-sm" target="_blank">view</a>
                                    <a href="{{ asset('storage/' . $undangan->filePath) }}"
                                        class="mt-1 btn btn-primary btn-sm"
                                        download='{{ $undangan->fileName }}'>download</a>
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
