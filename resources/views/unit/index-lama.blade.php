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
                <h3 class="fw-bold fs-4 mb-3">Daftar Unit</h3>
            </div>
            <div>
                <a href="/unit/tambah" class="btn btn-primary">Tambah Unit</a>
            </div>
        </div>

        <div class="div">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unit as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->nama }}</td>
                            <td>
                                <a href="/unit/edit/{{ $u->id }}" class="mt-1 btn btn-sm btn-primary"><i
                                        class="fa-solid fa-pencil" style="color: #ffffff;"></i></a>
                                <form action="/unit/hapus/{{ $u->id }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                      class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
