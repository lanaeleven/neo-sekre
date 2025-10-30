@extends('layouts.main')

@section('container')
    
<div>
    
@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif  

  <div class="d-flex justify-content-center align-items-center my-4">
    <div>
      <h3 class="fw-bold fs-4 text-center">PROFIL</h3>
    </div>
  </div>
  <div class="row justify-content-center">
      <div class="card col-12 col-md-8">
        <div class="card-body">
          <h6 class="card-title">INFORMASI PROFIL</h6>
          <form method="post" action="/user/updateInfoProfil">
            @csrf
              <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                <div class="row mb-3">
                    <label for="namaJabatan" class="col-sm-3 col-form-label">Jabatan</label>
                    <div class="col-sm-9">
                      <input name="namaJabatan" type="text" class="form-control @error('namaJabatan') is-invalid @enderror" id="namaJabatan" value="{{ auth()->user()->namaJabatan }}" disabled readonly>
                      @error('namaJabatan')
                      <div id="namaJabatan" class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                  <div class="col-sm-9">
                    <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ auth()->user()->nama }}" required>
                    @error('nama')
                      <div id="nama" class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                  </div>
               </div>

                <div class="row mb-3">
                  <label for="username" class="col-sm-3 col-form-label">Username</label>
                  <div class="col-sm-9">
                    <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ auth()->user()->username }}" required>
                    @error('username')
                      <div id="username" class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                  </div>
               </div>

               <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ auth()->user()->email }}" required>
                  @error('email')
                    <div id="email" class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
             </div>

               <div class="row mb-3">
                <label for="passwordKonfirmasi" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                  <button type="submit" class="btn btn-success mt-3">Simpan</button>
                </div>
              </div>
                
            </form>
        </div>
        </div>

        <div class="card my-5 col-12 col-md-8">
          <div class="card-body">
            <h6 class="card-title">UBAH PASSWORD</h6>
            <form method="post" action="/user/updatePasswordNs">
              @csrf
                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
  
                  <div class="row mb-3">
                      <label for="passwordSaatIni" class="col-sm-3 col-form-label">Password Saat Ini</label>
                      <div class="col-sm-9">
                        <input name="passwordSaatIni" type="password" class="form-control @error('passwordSaatIni') is-invalid @enderror" id="passwordSaatIni" required>
                        @error('passwordSaatIni')
                        <div id="passwordSaatIni" class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                  </div>

                  <div class="row mb-3">
                    <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                    <div class="col-sm-9">
                      <input name="passwordBaru" type="password" class="form-control @error('passwordBaru') is-invalid @enderror" id="password" onkeyup='check();' pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                      @error('passwordBaru')
                      <div id="passwordBaru" class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
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

                <div class="row">
                  <label for="passwordKonfirmasi" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                  <div class="col-sm-9">
                    <input name="passwordKonfirmasi" type="password" class=" mb-2 form-control @error('passwordKonfirmasi') is-invalid @enderror" id="passwordKonfirmasi" onkeyup='check();' required>
                    <div id="labelKonfirmasi">
                      
                    </div>

                    <div class="form-check mt-3">
                      <input type="checkbox" class="form-check-input" id="passwordToggle" onclick="myFunction()">
                      <label class="form-check-label" for="passwordToggle" >Show Password</label>
                    </div>
                  </div>
              </div>

              <div class="row mb-3">
                <label for="passwordKonfirmasi" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                  <button type="submit" id="btnUbahPassword" class="btn btn-warning mt-3">Ubah Password</button>
                </div>
            </div>
                  
          </form>
          </div>
          </div>
        </div>
</div>

<script src="/js/password-validation.js"></script>

<script>
  const btnUbahPassword = document.getElementById("btnUbahPassword");
  btnUbahPassword.disabled = true;
  
  function myFunction() {
    var x = document.getElementById("passwordSaatIni");
    if (x.type == "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }

    var y = document.getElementById("password");
    if (y.type == "password") {
      y.type = "text";
    } else {
      y.type = "password";
    }

    var z = document.getElementById("passwordKonfirmasi");
    if (z.type == "password") {
      z.type = "text";
    } else {
      z.type = "password";
    }
  }

var check = function() {
  const pwBaru = document.getElementById('password');
  const pwKonfir = document.getElementById('passwordKonfirmasi');
  const labelKonfir = document.getElementById('labelKonfirmasi');
  if (pwBaru.value == pwKonfir.value && pwBaru.value != '' && pwKonfir.value != '') {
    labelKonfir.className = "text-success fw-medium";
    labelKonfir.innerHTML  = 'Password Konfirmasi Benar';
    btnUbahPassword.disabled = false;
  }
  if (pwBaru.value != pwKonfir.value && pwBaru.value != '' && pwKonfir.value != '') {
    labelKonfir.className = "text-danger fw-medium";
    labelKonfir.innerHTML  = 'Password Konfirmasi Salah';
    btnUbahPassword.disabled = true;
  }
  if (pwBaru.value == '' || pwKonfir.value == '') {
    labelKonfir.className = "";
    labelKonfir.innerHTML  = '';
    btnUbahPassword.disabled = true;
  }
}

</script>

@endsection