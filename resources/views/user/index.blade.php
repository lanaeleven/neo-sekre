
@extends('layouts.main')

@section('container')
{{-- @dd($idKepala) --}}
<div class="div">
  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif  
  <div class="d-flex justify-content-between my-2">
    <div>
      <h3 class="fw-bold fs-4 mb-3">Daftar User</h3>
    </div>
    <div>
      <a href="/user/tambah" class="btn btn-primary">Tambah User</a>
    </div>
  </div>

    <div class="div">
        <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Level</th>
                <th scope="col">Atasan</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($user as $u)
                  <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->nama }}</td>
                    <td>{{ $u->namaJabatan }} @if ($u->isKhusus)
                        (Akun Khusus)
                    @endif </td>
                    <td @if (is_null($u->strukturOrganisasi)) class="bg-danger text-white bg-gradient" @endif>
                      @if (is_null($u->strukturOrganisasi))
                        Belum Diisi
                      @else
                      @switch($u->strukturOrganisasi->levelJabatan)
                        @case(1)
                            Sekretariat
                            @break
                        @case(2)
                            Direktur
                            @break
                        @case(3)
                            Kabag/Kabid
                            @break
                        @case(4)
                            Kains/Kasubbag/Kasi/Penjab
                            @break
                        @case(5)
                            Komite/Tim
                            @break
                        @default
                            
                    @endswitch
                      @endif
                    </td>
                    <td @if (is_null($u->strukturOrganisasi)) class="bg-danger text-white bg-gradient" @endif>
                      @if (is_null($u->strukturOrganisasi))
                        Belum Diisi
                      @else
                      {{ $u->strukturOrganisasi->atasan->namaJabatan }}
                      @endif
                    </td>
                    {{-- <td class="text-center">
                      @if (in_array($u->id, $idKepala))
                      <i class="fa-solid fa-check" style="color: #0a9400;"></i>
                      @else
                      <i class="fa-solid fa-x" style="color: #d62929;"></i>
                      @endif
                    </td> --}}
                    <td><a href="/user/edit/{{ $u->id }}" class="mt-1 btn btn-sm btn-primary text-center"><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></a></td>
                  </tr>
              @endforeach
            </tbody>
          </table>
    </div>

</div>
@endsection
