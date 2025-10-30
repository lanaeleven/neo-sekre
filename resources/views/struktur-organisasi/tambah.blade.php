@extends('layouts.main')

@section('container')
    
<div>

  <div class="d-flex justify-content-between align-items-center my-4">
    <div>
      <a href="/user/edit/{{ $user->id }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
    </div>
    <div>
      <h3 class="fw-bold fs-4 text-center">Atur SOTK</h3>
    </div>
    <div>
    </div>
  </div>

    <div class="d-flex justify-content-center">
        <div class="col-6">
          <form method="post" action="/struktur-organisasi/store">
            @csrf

            <div class="row mb-3">
              <label for="namaJabatan" class="col-sm-3 col-form-label">Jabatan</label>
              <div class="col-sm-9">
                <input type="text" value="{{ $user->namaJabatan }}" class="form-control" disabled>
              </div>
          </div>

            <input type="hidden" name="idUser" value="{{ $user->id }}">

            <div class="row mb-3">
              <label for="idAtasan" class="col-sm-3 col-form-label">Jabatan Atasan</label>
              <div class="col-sm-9">
                <select name="idAtasan" class="form-select" id="idAtasan" required>
                    <option value="">Pilih Jabatan Atasan</option>
                    @foreach ($atasan as $a)
                  
                    <option value="{{ $a->id }}">{{ $a->namaJabatan }}</option>

                    @endforeach
                  </select>
              </div>
          </div>

            <div class="row mb-3">
              <label for="levelJabatan" class="col-sm-3 col-form-label">Level Jabatan</label>
              <div class="col-sm-9">
                <select name="levelJabatan" class="form-select" id="levelJabatan" required>
                    <option value="">Pilih Level Jabatan</option>
                    <option value='3'>Kabag/Kabid</option>
                    <option value='4'>Kains/Kasubbag/Kasi/Penjab</option>
                    <option value='5'>Komite/Tim</option>
                  </select>
              </div>
          </div>


            <div class="row mb-3">
              <label for="passwordKonfirmasi" class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <button type="submit" id="btnUbahPassword" class="btn btn-warning mt-3">Simpan</button>
              </div>
          </div>
                
        </form>
        </div>
    </div>
</div>


@endsection