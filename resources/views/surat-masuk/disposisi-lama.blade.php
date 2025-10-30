{{-- @dd($jenisSurat[0]->kodeJenisSurat.'-'.$jenisSurat[0]->keterangan) --}}
{{-- @dd($distribusiSurat) --}}
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
    <h3 class="fw-bold fs-4 mb-3 text-center">Disposisi Surat Masuk</h3>
    <div class="d-flex justify-content-center">
        <div class="col-9">
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
                                        <td>{{ $suratMasuk->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Surat</td>
                                        <td>{{ $suratMasuk->tanggalSurat }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dari</td>
                                        <td>{{ $suratMasuk->pengirim }}</td>                                        
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
                                     <a href="{{ asset('storage/' . $suratMasuk->filePath) }}" class="mt-1 btn btn-success btn-sm" target="_blank">view</a>
                                    <a href="{{ asset('storage/' . $suratMasuk->filePath) }}" class="mt-1 btn btn-primary btn-sm" download='{{ $suratMasuk->fileName }}'>download</a>                          
                                 </div>
                            </div>
                        </td>
                    </tr>
                </tbody>

            </table>
            
        </div>
        
    </div>

    @if ($distribusiSurat->isNotEmpty())
    <div class="row d-flex justify-content-center">
        <h5 class="text-center fw-bold">Terusan Sebelumnya</h5>
    @foreach ($distribusiSurat as $ds)
            
    <div class="col-9 my-3">
        <form>
        <div class="row mb-3">
            <label for="tujuan" class="col-sm-3 col-form-label">Oleh</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" value="{{ $ds->pengirimDisposisi->namaJabatan }}" aria-label="Disabled input example" disabled readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label for="tujuan" class="col-sm-3 col-form-label">Kepada</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" value="{{ $ds->tujuanDisposisi->namaJabatan }}" aria-label="Disabled input example" disabled readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label for="tujuan" class="col-sm-3 col-form-label">Tanggal Diteruskan</label>
            <div class="col-sm-9">
                <input class="form-control" type="date" value="{{ $ds->tanggalDiteruskan }}" aria-label="Disabled input example" disabled readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label for="instruksi" class="col-sm-3 col-form-label">Instruksi</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="instruksi" id="instruksi" rows="3" disabled readonly>{{ $ds->instruksi }}</textarea>
            </div>
        </div>
        
        </form>
        <hr>
    </div>
    @endforeach
    </div>
    @endif

    <div class="row d-flex justify-content-center">
        <h5 class="text-center fw-bold mb-3">Teruskan Surat</h5>
        <div class="col-9">
            <form action="/surat-masuk/teruskan" method="post">
            @csrf
            

            {{-- FORM DISPOSISI ADMIN KE DIREKTUR --}}

            @if ($suratMasuk->status === 'Belum Diteruskan')
            <input type="hidden" name="idTujuanDisposisi" value="2">
            <input type="hidden" name="statusSuratLanjutan" value="Diteruskan ke Direktur">
            <div class="row mb-3">
                <label for="tujuan" class="col-sm-3 col-form-label">Teruskan Kepada</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" value="Direktur" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            
            
            @endif

            {{-- END FORM DISPOSISI ADMIN KE DIREKTUR --}}


            {{-- FORM DISPOSISI DIREKTUR KE KEPALA BAGIAN --}}

            @if ($suratMasuk->status === 'Diteruskan ke Direktur')

            <input type="hidden" name="statusSuratLanjutan" value="Diteruskan ke Kepala Bagian">
            {{-- <div class="row mb-3">
                <label for="tujuan" class="col-sm-3 col-form-label">Arahan dari Administrator</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="instruksi" id="instruksi" rows="3" disabled readonly>{{ $distribusiSurat[0]->instruksi }}</textarea>
                </div>
            </div> --}}

            <div class="row mb-3">
                <label for="idTujuanDisposisi" class="col-sm-3 col-form-label">Teruskan Kepada</label>
                <div class="col-sm-9">
                  <select name="idTujuanDisposisi" class="form-select" id="idTujuanDisposisi" required>
                      <option value="">Pilih Kepala Bagian</option>
                      @foreach ($terusan as $t)
                    
                      <option value="{{ $t->id }}">{{ $t->namaJabatan }}</option>
  
                      @endforeach
                    </select>
                </div>
              </div>
                
            @endif

            {{-- END FORM DISPOSISI DIREKTUR KE KEPALA BAGIAN --}}

            {{-- FORM DISPOSISI KEPALA BAGIAN KE PENANGGUNG JAWAB --}}

            @if ($suratMasuk->status === 'Diteruskan ke Kepala Bagian')

            <input type="hidden" name="statusSuratLanjutan" value="Diteruskan ke Penanggung Jawab">
            {{-- <div class="row mb-3">
                <label for="tujuan" class="col-sm-3 col-form-label">Instruksi dari direktur</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="instruksi" id="instruksi" rows="3" disabled readonly>{{ $distribusiSurat[0]->instruksi }}</textarea>
                </div>
            </div> --}}

            <div class="row mb-3">
                <label for="idTujuanDisposisi" class="col-sm-3 col-form-label">Teruskan Kepada</label>
                <div class="col-sm-9">
                  <select name="idTujuanDisposisi" class="form-select" id="idTujuanDisposisi" required>
                      <option value="">Pilih Penanggung Jawab</option>
                      @foreach ($terusan as $t)
                    
                      <option value="{{ $t->id }}">{{ $t->namaJabatan }}</option>
  
                      @endforeach
                    </select>
                </div>
              </div>
                
            @endif

            {{-- END FORM DISPOSISI KEPALA BAGIAN KE PENANGGUNG JAWAB --}}
              
            {{-- FORM DISPOSISI PENANGGUNG JAWAB KE PENGARSIPAN --}}

            @if ($suratMasuk->status === 'Diteruskan ke Penanggung Jawab')
            {{-- @dd($distribusiSurat) --}}

            <input type="hidden" name="statusSuratLanjutan" value="Diarsipkan">
            {{-- <div class="row mb-3">
                <label for="tujuan" class="col-sm-3 col-form-label">Instruksi dari Kepala Bagian</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="instruksi" id="instruksi" rows="3" disabled readonly>{{ $distribusiSurat[0]->instruksi }}</textarea>
                </div>
            </div> --}}

            <input type="hidden" name="idTujuanDisposisi" value="1">
            <div class="row mb-3">
                <label for="tujuan" class="col-sm-3 col-form-label">Teruskan Kepada</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" value="Sekretariat" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
                
            @endif

            {{-- END FORM DISPOSISI PENANGGUNG JAWAB KE PENGARSIPAN --}}

            <input type="hidden" name="idPengirimDisposisi" value="{{ auth()->user()->id }}">
            <input type="hidden" name="idSuratMasuk" value="{{ $suratMasuk->id }}">
            <div class="row mb-3">
                <label for="instruksi" class="col-sm-3 col-form-label">Instruksi</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="instruksi" id="instruksi" rows="3" required></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <div>
                  <a href="/surat-masuk/index" class="btn btn-warning me-4">Kembali</a>
                </div>
                <div>
                    <button type="submit" class="btn btn-success">Teruskan</button>
                </div>
            </div>

            

            </form>
        </div>
    </div>
</div>

@endsection