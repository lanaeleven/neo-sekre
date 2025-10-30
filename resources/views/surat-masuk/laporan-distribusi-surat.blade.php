@extends('layouts.main')

@section('container')
<div>
  @if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif  
    <div class="d-flex justify-content-between my-2">
      <div>
        <h3 class="fw-bold fs-4">{{ $judul }}</h3>
      </div>
    </div>

    <div>
      <form class="row g-3 mt-3" action="">

        <div class="row mb-3">
          @if ($keterangan == "posisi-terakhir")
          <div class="col-auto">
            <label for="disposisiTerakhir" class="col-form-label fw-bold">Tujuan Disposisi Terakhir</label>
          </div>
          <div class="col-auto">
            <select name="disposisiTerakhir" class="form-select" id="disposisiTerakhir">
              <option value="">Pilih Tujuan Disposisi Terakhir</option>
              <option value="Belum Diteruskan" @if (request('disposisiTerakhir') == "Belum Diteruskan")
                  selected
              @endif>Belum Diteruskan</option>
              @foreach ($terusan as $t)
            
              <option value="{{ $t->id }}" @if (request('disposisiTerakhir') == $t->id)
                  selected
              @endif>{{ $t->namaJabatan }}</option>
    
              @endforeach
            </select>
          </div>              
          @endif

          @if ($keterangan == "sudah-selesai")
          <div class="col-auto">
            <label for="statusArsip" class="col-form-label fw-bold">Status Arsip</label>
          </div>
          <div class="col-auto">
            <select name="statusArsip" class="form-select" id="statusArsip">
              <option value="">Pilih Status Arsip</option>
              <option value="Belum" @if (request('statusArsip') == 'Belum')
                  selected
              @endif>Belum</option>
              <option value="Arsip" @if (request('statusArsip') == 'Arsip')
                  selected
              @endif>Arsip</option>
            </select>
          </div>              
          @endif

          @if ($keterangan == "pernah-distribusi")
          <div class="col-auto">
            <label for="tujuanDisposisi" class="col-form-label fw-bold">Tujuan Disposisi</label>
          </div>
          <div class="col-auto">
            <select name="tujuanDisposisi" class="form-select" id="tujuanDisposisi">
              <option value="">Pilih Tujuan Disposisi</option>
              @foreach ($terusan as $t)
            
              <option value="{{ $t->id }}" @if (request('tujuanDisposisi') == $t->id)
                  selected
              @endif>{{ $t->namaJabatan }}</option>
    
              @endforeach
            </select>
          </div>              
          @endif
        </div>

        <div class="row">
          <div class="col-auto">
            <label for="tanggalAwal" class="col-form-label fw-bold">Tanggal Awal :</label>
          </div>
        <div class="col-auto">
            <input name="tanggalAwal" type="date" id="tanggalAwal" class="form-control" value="{{ request('tanggalAwal') }}">
        </div> 

        <div class="col-auto ms-3">
            <label for="tanggalAkhir" class="col-form-label fw-bold">Tanggal Akhir :</label>
          </div>
        <div class="col-auto">
            <input name="tanggalAkhir" type="date" id="tanggalAkhir" class="form-control" value="{{ request('tanggalAkhir') }}">
        </div> 

      </div>
      
        <div class="col-auto">
          <input name="index" type="number" class="form-control" placeholder="Index" value="{{ request('index') }}">
        </div>
        <div class="col-auto">
          <select name="direksi" class="form-select">
            <option value="">Semua Direksi</option>
            @foreach ($direksi as $d)
            <option value="{{ $d->id }}" {{ request('direksi') == $d->id ? 'selected' : '' }}>{{ $d->namaDireksi }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-auto">
          <input name="pengirim" type="text" class="form-control" placeholder="Pengirim" value="{{ request('pengirim') }}">
        </div>
        <div class="col-auto">
          <input name="nomorSurat" type="text" class="form-control" placeholder="Nomor Surat" value="{{ request('nomorSurat') }}">
        </div>
        <div class="col-auto">
          <input name="perihal" type="text" class="form-control" placeholder="Perihal" value="{{ request('perihal') }}">
        </div>
        
        <div class="col-auto">
          <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i></button>
        </div>
      </form>
    </div>

    <div class="div">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Indeks</th>
                <th scope="col">Direktorat</th>
                <th scope="col">Dari</th>
                <th scope="col">Tgl Surat</th>
                <th scope="col">No Surat</th>
                <th scope="col">Perihal</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($suratMasuk as $sm)
                  
              <tr>
                <th scope="row">{{ $sm->id }}</th>
                <td>{{ $sm->direksi->namaDireksi }}</td>
                <td>{{ $sm->pengirim }}</td>
                <td>{{ $sm->tanggalSurat }}</td>
                <td>{{ $sm->nomorSurat }}</td>
                <td>{{ $sm->perihal }}</td>
                <td> {{ $sm->status }} </td>
                <td>
                  <a href="/surat-masuk/edit/{{ $sm->id }}" class="mt-1 btn btn-sm btn-primary"><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></a>
                  <a href="/surat-masuk/lacak-distribusi/{{ $sm->id }}" class="mt-1 btn btn-sm btn-secondary"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></a>
                  <a href="/surat-masuk/disposisi/{{ $sm->id }}" class="mt-1 btn btn-sm btn-warning"><i class="fa-solid fa-share" style="color: #000000;"></i></a>
                </td>
              </tr>

              @endforeach
              
            </tbody>
          </table>
    </div>
    <div class="d-flex justify-content-center">
      <div>
        {{ $suratMasuk->links() }}
      </div>
    </div>

</div>
@endsection