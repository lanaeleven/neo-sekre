@extends('layouts.main')

@section('container')

    <div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <a href="/user/index" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-left"
                        style="color: #000;"></i></a>
            </div>
            <div>
                <h3 class="fw-bold fs-4 text-center">Edit Akun Tujuan Disposisi</h3>
            </div>
            <div>
            </div>
        </div>



        <div class="row justify-content-center">
            <div class="card col-12 col-md-8 mb-5">
                <div class="card-body">
                    <h4 class="card-title text-center mb-3">INFORMASI PROFIL</h4>
                    <form method="post" action="/user/save">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="row mb-3">
                            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input name="nama" type="text"
                                    class="form-control @error('nama') is-invalid @enderror" id="nama"
                                    value="{{ $user->nama }}" required>
                                @error('nama')
                                    <div id="nama" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="namaJabatan" class="col-sm-3 col-form-label">Jabatan</label>
                            <div class="col-sm-9">
                                <input name="namaJabatan" type="text"
                                    class="form-control @error('namaJabatan') is-invalid @enderror" id="namaJabatan"
                                    value="{{ $user->namaJabatan }}" required>
                                @error('namaJabatan')
                                    <div id="namaJabatan" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input name="email" type="text"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    value="{{ $user->email }}" required>
                                @error('email')
                                    <div id="email" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input name="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" id="username"
                                    value="{{ $user->username }}" required>
                                @error('username')
                                    <div id="username" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- @if (!$user->isKhusus)

                 <div class="row mb-3">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="isKepala" value="yes" id="yes" 
                      @if (in_array($user->id, $idKepala))
                      checked
                      @endif
                      >
                      <label class="form-check-label" for="yes">
                        Kabid / Kains / Kabag
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="isKepala" value="no" id="no"  
                      @if (!in_array($user->id, $idKepala))
                      checked
                      @endif
                      >
                      <label class="form-check-label" for="no">
                        BUKAN Kabid / Kains / Kabag
                      </label>
                    </div>
                  </div>
               </div>

               @endif --}}

                        <div class="row mb-3">
                            <label for="passwordKonfirmasi" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success mt-3">Update Profil</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        @if (!$user->isKhusus)

            <div class="row justify-content-center">
                <div class="card col-12 col-md-8 mb-5">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3">SOTK</h4>

                        {{-- @dd($user->strukturOrganisasi->idAtasan) --}}


                        @if (is_null($user->strukturOrganisasi))
                            <div class="text-center">
                                <p>SOTK user ini belum diatur.</p>
                                <a class="btn btn-warning" href="/struktur-organisasi/tambah/{{ $user->id }}">Atur
                                    SOTK</a>
                            </div>
                        @else
                            @if ($user->id == 1 || $user->id == 3)
                                <form>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Jabatan Atasan</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" disabled>
                                                <option selected value="">
                                                    {{ $user->strukturOrganisasi->atasan->namaJabatan }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Level Jabatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" disabled>
                                                <option selected>
                                                    @if ($user->strukturOrganisasi->levelJabatan == 1)
                                                        Sekretariat
                                                    @else
                                                        Direktur
                                                    @endif
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </form>
                            @else
                                <form method="post" action="/struktur-organisasi/save">
                                    @csrf
                                    <input type="hidden" name="idUser" value="{{ $user->id }}">
                                    <div class="row mb-3">
                                        <label for="idAtasan" class="col-sm-3 col-form-label">Jabatan Atasan</label>
                                        <div class="col-sm-9">
                                            <select name="idAtasan" class="form-select" id="idAtasan" required>
                                                <option value="">Pilih Jabatan Atasan</option>
                                                @foreach ($atasan as $a)
                                                    <option value="{{ $a->id }}"
                                                        @if ($user->strukturOrganisasi->idAtasan == $a->id) selected @endif>
                                                        {{ $a->namaJabatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="levelJabatan" class="col-sm-3 col-form-label">Level Jabatan</label>
                                        <div class="col-sm-9">
                                            <select name="levelJabatan" class="form-select" id="levelJabatan" required>
                                                <option value="">Pilih Level Jabatan</option>
                                                <option value='3' @if ($user->strukturOrganisasi->levelJabatan == 3) selected @endif>
                                                    Kabag/Kabid</option>
                                                <option value='4' @if ($user->strukturOrganisasi->levelJabatan == 4) selected @endif>
                                                    Kains/Kasubbag/Kasi/Penjab</option>
                                                <option value='5' @if ($user->strukturOrganisasi->levelJabatan == 5) selected @endif>
                                                    Komite/Tim</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="passwordKonfirmasi" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" id="btnUbahPassword"
                                                class="btn btn-secondary mt-3">Update SOTK</button>
                                        </div>
                                    </div>

                                </form>
                            @endif



                        @endif
                    </div>
                </div>
            </div>

        @endif

        <div class="row justify-content-center">
            <div class="card col-12 col-md-8 mb-5">
                <div class="card-body">
                    <h4 class="card-title text-center mb-3">UBAH PASSWORD</h4>
                    <form method="post" action="/user/updatePassword">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <div class="row mb-3">
                            <label for="password" class="col-sm-3 col-form-label ">Password Baru</label>
                            <div class="col-sm-9">
                                <input name="passwordBaru" type="password"
                                    class="form-control @error('passwordBaru') is-invalid @enderror" id="password"
                                    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}"
                                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                    required>
                                @error('passwordBaru')
                                    <div id="passwordBaru" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" id="passwordToggle"
                                        onclick="myFunction()">
                                    <label class="form-check-label" for="passwordToggle">Show Password</label>
                                </div>
                                <div id="message">(
                                    <span id="letter" class="text-danger">Mengandung huruf kecil,</span>
                                    <span id="capital" class="text-danger">Mengandung huruf kapital,</span>
                                    <span id="number" class="text-danger">Mengandung angka,</span>
                                    <span id="symbol" class="text-danger">Mengandung simbol,</span>
                                    <span id="length" class="text-danger">Minimal 8 karakter</span>
                                    )
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="passwordKonfirmasi" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" id="btnUbahPassword" class="btn btn-warning mt-3">Update
                                    Password</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="card col-12 col-md-8 mb-5">
                <div class="card-body">
                    <h4 class="card-title text-center mb-3">LINGKUP UNIT</h4>
                    <form method="post" action="/user/update-lingkup-unit">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <div class="row mb-3">
                            <label for="units" class="col-sm-3 col-form-label">Pilih Unit (bisa lebih dari
                                satu)</label>
                            <div class="col-sm-9">
                                <select name="units[]" id="units" multiple class="form-select select2" required>
                                    <option value="all">Seluruh Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            @if ($user->units->contains($unit->id)) selected @endif>{{ $unit->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="passwordKonfirmasi" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" id="btnUbahLingkupUnit" class="btn btn-primary mt-3">Update
                                    Lingkup Unit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        @if (!in_array($user->id, $idKepala))
            <div class="row justify-content-center">
                <div class="card col-8 mb-5">
                    <div class="card-body">

                        @if ($user->isKhusus)
                            Akun ini adalah akun khusus. <a href="/user/kelola-khusus/{{ $user->id }}">Kelola Akun
                                Khusus</a>

                            <form action="/user/batalkanKhusus" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <button type="submit" id="btnBatalkanKhusus" class="btn btn-secondary mt-3">Batalkan
                                    Khusus</button>
                            </form>
                        @else
                            Akun ini bukan akun khusus.
                            <form action="/user/jadikanKhusus" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <button type="submit" id="btnJadikanKhusus" class="btn btn-sm btn-secondary mt-3">Jadikan
                                    Khusus</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="card col-8 mb-5">
                <div class="card-body">
                    @if ($user->isAktif)
                    <div>
                        <span class="text-success"><b>Status User Aktif</b></span>
                    </div>
                        <form action="/user/nonaktifkan" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" id="nonaktifkanUser" class="btn btn-sm btn-danger mt-3">Nonaktifkan
                                User</button>
                        </form>
                    @else
                    <div>
                        <span class="text-danger"><b>Status User Non-aktif</b></span>
                    </div>
                        <form action="/user/aktifkan" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" id="aktifkanUser" class="btn btn-success mt-3">Aktifkan
                                User</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <script src="/js/password-validation.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/multiple-select.js"></script>

    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

@endsection
