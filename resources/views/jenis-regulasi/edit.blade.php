
@extends('layouts.main')

@section('container')
    
<div>

  <div class="d-flex justify-content-between align-items-center my-4">
    <div>
      <a href="/jenis-regulasi/index" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
    </div>
    <div>
      <h3 class="fw-bold fs-4 text-center">Edit Jenis Regulasi</h3>
    </div>
    <div>
    </div>
  </div>

    <div class="d-flex justify-content-center">
        <div class="col-6">
            <form method="post" action="/jenis-regulasi/save">
              @csrf
                <input type="hidden" name="id" value="{{ $jenisRegulasi->id }}">

                <div class="row mb-3">
                    <label for="kodeJenisRegulasi" class="col-sm-3 col-form-label">Kode Jenis Regulasi</label>
                    <div class="col-sm-9">
                      <input name="kodeJenisRegulasi" type="text" class="form-control @error('kodeJenisRegulasi') is-invalid @enderror" id="kodeJenisRegulasi" value="{{ $jenisRegulasi->kodeJenisRegulasi }}" required>
                      @error('kodeJenisRegulasi')
                      <div id="kodeJenisRegulasi" class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                  <div class="col-sm-9">
                    <input name="keterangan" type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" value="{{ $jenisRegulasi->keterangan }}" required>
                    @error('keterangan')
                    <div id="keterangan" class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
              </div>

                <div class="d-flex justify-content-center">
                  <div>
                    <button type="submit" class="btn btn-success mt-3">Simpan</button>
                  </div>
                </div>
                  
              </form>
        </div>
    </div>
</div>

@endsection