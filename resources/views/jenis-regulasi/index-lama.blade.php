
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
      <h3 class="fw-bold fs-4 mb-3">Daftar Jenis Regulasi</h3>
    </div>
    <div>
      <a href="/jenis-regulasi/tambah" class="btn btn-primary">Tambah Jenis Regulasi</a>
    </div>
  </div>

    <div class="div">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Kode Jenis Regulasi</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($jenisRegulasi as $jr)
                  <tr>
                    <td>{{ $jr->id }}</td>
                    <td>{{ $jr->kodeJenisRegulasi }}</td>
                    <td>{{ $jr->keterangan }}</td>
                    <td><a href="/jenis-regulasi/edit/{{ $jr->id }}" class="mt-1 btn btn-sm btn-primary"><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></a></td>
                  </tr>
              @endforeach
            </tbody>
          </table>
    </div>

</div>
@endsection