@extends('layouts.main')

@section('container')

<div>

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif  

  @php

  $noPengirim = 1;
  $noPenerima = 1;

  @endphp

  <div class="d-flex justify-content-between align-items-center my-4">
    <div>
      <a href="/user/edit/{{ $user->id }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
    </div>
    <div>
      <h3 class="fw-bold fs-4 text-center">Kelola Akun Khusus</h3>
    </div>
    <div>
    </div>
  </div>

  <div class="mb-3">
    <h5>{{ $user->namaJabatan }}</h5>
  </div>

  <div class="row justify-content-around">

      <div class="col-5 justify-content-center">
        <div class="card mb-5">
          <div class="card-body">

            <h5 class="text-center">Daftar Pengirim Disposisi</h5>
            <div class="d-flex justify-content-end">
                <div>
                    <button class="btn btn-success btn-sm mx-auto" data-bs-toggle="modal" data-bs-target="#tambahPengirimModal">Tambah Pengirim</button>
                </div>
            </div>

            <table class="table table-striped d-none d-md-table d-lg-table d-xl-table d-xxl-table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Jabatan Pengirim</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($daftarPengirim as $pengirim)
                        
                    <tr>
                        <td>{{ $noPengirim++ }}</td>
                        <td>{{ $pengirim->pengirim->namaJabatan }}</td>
                        <td>
                            <a href="/hapusPengirim/{{ $pengirim->id }}" class="mt-1 btn btn-sm btn-danger"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
              </table>            
    
          </div>
        </div>
      </div>

      <div class="col-5 justify-content-center">
        <div class="card mb-5">
          <div class="card-body">

            <h5 class="text-center">Daftar Penerima Disposisi</h5>
            <div class="d-flex justify-content-end">
                <div>
                    <button class="btn btn-success btn-sm mx-auto" data-bs-toggle="modal" data-bs-target="#tambahPenerimaModal">Tambah Penerima</button>
                </div>
            </div>

            <div>
                <table class="table table-striped d-none d-md-table d-lg-table d-xl-table d-xxl-table">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Jabatan Penerima</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarPenerima as $penerima)
                        
                        <tr>
                            <td>{{ $noPenerima++ }}</td>
                            <td>{{ $penerima->penerima->namaJabatan }}</td>
                            <td>
                                <a href="/hapusPenerima/{{ $penerima->id }}" class="mt-1 btn btn-sm btn-danger"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a>
                            </td>
                        </tr>
    
                        @endforeach
                    </tbody>
                  </table>
            </div>

    
          </div>
        </div>
      </div>

  </div>

  {{-- modal tambah pengirim --}}
  <div class="modal fade" id="tambahPengirimModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="tambahPengirimModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="tambahPengirimModalLabel">Tambah Pengirim</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form method="POST" id="formtambahPengirim" action="/akun-khusus/tambah-pengirim">
            @csrf

            <input type="hidden" name="idUser" value="{{ $user->id }}">

              <div class="col-auto">
                <label for="awal" class="col-form-label"><small>Jabatan Pengirim</small></label>
              </div>
              <div class="col-auto mb-3">
                <select name="idPengirim" class="form-select" id="idPengirim" required>
                    <option value="">Pilih Pengirim</option>

                    @foreach ($daftarBukanPengirim as $bukanPengirim)
                  
                    <option value="{{ $bukanPengirim->id }}">{{ $bukanPengirim->namaJabatan }}</option>

                    @endforeach

                </select>
              </div> 
              <button type="submit" class="btn btn-success container-fluid">Tambah</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  {{-- end of modal tambah pengirim --}}


    {{-- modal tambah penerima --}}
    <div class="modal fade" id="tambahPenerimaModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="tambahPenerimaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="tambahPenerimaModalLabel">Tambah Penerima</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
    
              <form method="POST" id="formtambahPenerima" action="/akun-khusus/tambah-penerima">
                @csrf

                <input type="hidden" name="idUser" value="{{ $user->id }}">

                  <div class="col-auto">
                    <label for="awal" class="col-form-label"><small>Jabatan Penerima</small></label>
                  </div>
                  <div class="col-auto mb-3">
                    <select name="idPenerima" class="form-select" id="idPenerima" required>
                        <option value="">Pilih Penerima</option>

                        @foreach ($daftarBukanPenerima as $bukanPenerima)
                  
                        <option value="{{ $bukanPenerima->id }}">{{ $bukanPenerima->namaJabatan }}</option>

                        @endforeach
    
                    </select>
                  </div> 
                  <button type="submit" class="btn btn-success container-fluid">Tambah</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      {{-- end of modal tambah penerima --}}




</div>

@endsection