@extends('layouts.main')

@section('container')
    <div>
        <div class="d-flex justify-content-between align-items-center my-2">
            <div>
                <button onclick="history.back()" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-left"
                        style="color: #000;"></i></button>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Distribusi Surat</h3>
            </div>
            <div>
                {{-- @can('dashboard-sekre')
      <form action="/unduh-disposisi" method="post">
        @csrf
        <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
        <button type="submit" class="btn btn-success btn-sm">Unduh Lembar Disposisi</button>
      </form>
      @endcan

      @if (auth()->user()->id == 10 || auth()->user()->id == 15 || auth()->user()->id == 11)
        <form action="/unduh-disposisi" method="post">
          @csrf
          <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
          <button type="submit" class="btn btn-success btn-sm">Unduh Lembar Disposisi</button>
        </form>
      @endif --}}

                <form action="/unduh-disposisi" method="post">
                    @csrf
                    <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
                    <button type="submit" class="btn btn-success btn-sm">Unduh Lembar Disposisi</button>
                </form>

            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-9 d-none d-md-block">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th colspan="2" class="text-center">
                                Status: {{ $suratMasuk->status }}
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Indeks</td>
                                            <td>{{ $suratMasuk->index }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Surat</td>
                                            <td>{{ $suratMasuk->tanggalSurat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Dari</td>
                                            <td>
                                                {{ $suratMasuk->pengirim }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Direksi</td>
                                            <td>{{ $suratMasuk->direksi->namaDireksi }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Nomor Surat</td>
                                            <td>{{ $suratMasuk->nomorSurat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Agenda</td>
                                            <td>{{ $suratMasuk->tanggalAgenda }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sifat Surat</td>
                                            <td>{{ $suratMasuk->sifatSurat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Perihal</td>
                                            <td>{{ $suratMasuk->perihal }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div>
                                        File surat: {{ $suratMasuk->fileName }}
                                    </div>
                                    <div class="ms-2">
                                        <a href="{{ asset('storage/' . $suratMasuk->filePath) }}"
                                            class="mt-1 btn btn-success btn-sm" target="_blank">view</a>
                                        <a href="{{ asset('storage/' . $suratMasuk->filePath) }}"
                                            class="mt-1 btn btn-primary btn-sm"
                                            download='{{ $suratMasuk->fileName }}'>download</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>

            {{-- Detail Surat untuk mobile device --}}
            <div class="col-12 d-md-none d-lg-none d-xl-none d-xxl-none mb-5">
                <div class="card shadow">
                    <table class="table table-bordered">
                        <tr>
                            <th>Status</th>
                            <td>{{ $suratMasuk->status }}</td>
                        </tr>
                        <tr>
                        <tr>
                            <th>Indeks</th>
                            <td>{{ $suratMasuk->index }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Surat</th>
                            <td>{{ $suratMasuk->nomorSurat }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Surat</th>
                            <td>{{ $suratMasuk->tanggalSurat }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Agenda</th>
                            <td>{{ $suratMasuk->tanggalAgenda }}</td>
                        </tr>
                        <tr>
                            <th>Sifat Surat</th>
                            <td>{{ $suratMasuk->sifatSurat }}</td>
                        </tr>
                        <tr>
                            <th>Direksi</th>
                            <td>{{ $suratMasuk->direksi->namaDireksi }}</td>
                        </tr>
                        <tr>
                            <th>Perihal</th>
                            <td>{{ $suratMasuk->perihal }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center"><a
                                    href="{{ asset('storage/' . $suratMasuk->filePath) }}"
                                    class="mt-1 btn btn-primary btn-sm" download='{{ $suratMasuk->fileName }}'>Download
                                    Surat</a></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div>

            </div>

        </div>

        <div class="row d-flex justify-content-center">
            @if ($distribusiSurat->isNotEmpty())
                <h4 class="text-center mt-1">Terusan Surat</h4>
            @endif
            @foreach ($distribusiSurat as $ds)
                <div class="col-9 my-3  d-none d-md-block">
                    <form>
                        <div class="row mb-3">
                            <label for="tujuan" class="col-sm-3 col-form-label">Oleh</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"
                                    value="{{ $ds->pengirimDisposisi->namaJabatan }}" aria-label="Disabled input example"
                                    disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tujuan" class="col-sm-3 col-form-label">Kepada</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="{{ $ds->tujuanDisposisi->namaJabatan }}"
                                    aria-label="Disabled input example" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tujuan" class="col-sm-3 col-form-label">Tanggal Diteruskan</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="datetime" value="{{ $ds->tanggalDiteruskan }}"
                                    aria-label="Disabled input example" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="instruksi" class="col-sm-3 col-form-label">Instruksi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="instruksi" id="instruksi" rows="3" disabled readonly>{{ $ds->instruksi }}</textarea>
                            </div>
                        </div>

                    </form>
                    @can('super-admin')
                        <div class="d-flex justify-content-end">
                            <a href="/surat-masuk/terusan-surat/{{ $suratMasuk->id }}/{{ $ds->id }}/edit">Edit</a>
                        </div>
                    @endcan
                    <hr>
                </div>

                {{-- Terusan surat untuk mobile device --}}
                <div class="d-md-none d-lg-none d-xl-none d-xxl-none my-2">
                    <div class="card">
                        <div class="card-header fw-bold">
                            Oleh: {{ $ds->pengirimDisposisi->namaJabatan }}
                        </div>
                        <div class="card-header fw-bold">
                            Kepada: {{ $ds->tujuanDisposisi->namaJabatan }}
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Tanggal Diteruskan: {{ $ds->tanggalDiteruskan }}</li>
                        </ul>
                        <div class="card-footer">
                            Instruksi: {{ $ds->instruksi }}
                        </div>
                    </div>
                    <hr>
                </div>
            @endforeach
        </div>
    </div>
@endsection
