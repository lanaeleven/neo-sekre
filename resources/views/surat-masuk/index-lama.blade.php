{{-- @dd($suratMasuk[0]->direksi->namaDireksi) --}}
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
    <h3 class="fw-bold fs-4 mb-3">{{ $judul }}</h3>
    <div class="d-flex flex-row-reverse my-2">
      <div class="mb-2">
        <a href="/surat-masuk/tambah" class="btn btn-primary">Tambah</a>
      </div>
    </div>

    <div>
      <form class="row g-3" action="/surat-masuk/index">
        <div class="col-auto">
          <input name="index" type="number" class="form-control" placeholder="Index" value="{{ request('index') }}">
        </div>
        @if (is_null($keterangan))
        <div class="col-auto">
          <input name="tahun" type="number" class="form-control" placeholder="Tahun" value="{{ request('tahun') }}">
        </div>            
        @endif
        <div class="col-auto">
          <select name="direksi" class="form-select">
            <option value="">Semua Direksi</option>
            @foreach ($direksi as $d)
            <option value="{{ $d->id }}" {{ request('direksi') == $d->id ? 'selected' : '' }}>{{ $d->namaDireksi }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-auto">
          <select name="status" class="form-select">
            <option value="">Status Distribusi Surat</option>
            <option value="Belum Diteruskan" {{ request('status') == "Belum Diteruskan" ? 'selected' : '' }}>Belum Diteruskan</option>
            <option value="Diteruskan ke Direktur" {{ request('status') == "Diteruskan ke Direktur" ? 'selected' : '' }}>Diteruskan ke Direktur</option>
            <option value="Diteruskan ke Kepala Bagian" {{ request('status') == "Diteruskan ke Kepala Bagian" ? 'selected' : '' }}>Diteruskan ke Kepala Bagian</option>
            <option value="Diteruskan ke Penanggung Jawab" {{ request('status') == "Diteruskan ke Penanggung Jawab" ? 'selected' : '' }}>Diteruskan ke Penanggung Jawab</option>
            <option value="Diarsipkan" {{ request('status') == "Diarsipkan" ? 'selected' : '' }}>Diarsipkan</option>
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
          <button type="submit" class="btn btn-secondary mb-3">Cari</button>
        </div>
      </form>
    </div>

    <div class="div">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Indeks</th>
                <th scope="col">Direktorat</th>
                {{-- <th scope="col">Tgl Agenda</th> --}}
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
                {{-- <td>{{ $sm->tanggalAgenda }}</td> --}}
                <td>{{ $sm->pengirim }}</td>
                <td>{{ $sm->tanggalSurat }}</td>
                <td>{{ $sm->nomorSurat }}</td>
                <td>{{ $sm->perihal }}</td>
                <td> {{ $sm->status }} </td>
                <td>
                  <a href="/surat-masuk/edit/{{ $sm->id }}" class="mt-1 btn btn-sm btn-primary"><i class="lni lni-pencil"></i></a>
                  <a href="/surat-masuk/lacak-distribusi/{{ $sm->id }}" class="mt-1 btn btn-sm btn-secondary"><i class="lni lni-eye"></i></a>
                    {{-- <a href="{{ asset('storage/' . $sm->filePath) }}" class="mt-1 btn btn-sm btn-success" download='{{ $sm->fileName }}'><i class="lni lni-download"></i></a> --}}
                    
                    @if ($sm->status === 'Belum Diteruskan')
                    <a href="/surat-masuk/disposisi/{{ $sm->id }}" class="mt-1 btn btn-sm btn-warning"><i class="lni lni-write"></i></a>
                    @endif
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