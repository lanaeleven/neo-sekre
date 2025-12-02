
@extends('layouts.main')

@section('container')
<div class="div">
  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif  
  <div class="d-flex justify-content-between my-2">
    <div>
      <h3 class="fw-bold fs-4 mb-3">Daftar Jenis Surat</h3>
    </div>
    <div>
      <a href="/jenis-surat/tambah" class="btn btn-primary">Tambah Jenis Surat</a>
    </div>
  </div>

    <div class="div">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Kode Jenis Surat</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($jenisSurat as $js)
                  <tr>
                    <td>{{ $js->id }}</td>
                    <td>{{ $js->kodeJenisSurat }}</td>
                    <td>{{ $js->keterangan }}</td>
                    <td><a href="/jenis-surat/edit/{{ $js->id }}" class="mt-1 btn btn-sm btn-primary"><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></a></td>
                  </tr>
              @endforeach
            </tbody>
          </table>
    </div>

</div>
@endsection