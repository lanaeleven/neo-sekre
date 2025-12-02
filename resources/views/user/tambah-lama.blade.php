
@extends('layouts.main')

@section('container')
    
<div>

  <div class="d-flex justify-content-between align-items-center my-4">
    <div>
      <a href="/user/index" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-left" style="color: #000;"></i></a>
    </div>
    <div>
      <h3 class="fw-bold fs-4 text-center">Tambah User</h3>
    </div>
    <div>
    </div>
  </div>

    <div class="d-flex justify-content-center">
        <div class="col-6">
            <form method="post" action="/user/tambah">
              @csrf

                <div class="row mb-3">
                    <label for="namaJabatan" class="col-sm-3 col-form-label">Jabatan</label>
                    <div class="col-sm-9">
                      <input name="namaJabatan" type="text" class="form-control @error('namaJabatan') is-invalid @enderror" id="namaJabatan" value="{{ old('namaJabatan') }}" required>
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
                    <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}"  required>
                    @error('nama')
                    <div id="nama" class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
              </div>

              <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
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
                    <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" required>
                    @error('username')
                      <div id="username" class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                  </div>
               </div>

               <div class="row mb-3">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                  <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                  @error('password')
                    <div id="password" class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                    <div class="mb-3 mt-2 form-check">
                      <input type="checkbox" class="form-check-input" id="passwordToggle" onclick="myFunction()">
                      <label class="form-check-label" for="passwordToggle" >Show Password</label>
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

                <div class="d-flex justify-content-center">
                  <div>
                    <button type="submit" class="btn btn-success mt-3">Tambah</button>
                  </div>
                </div>
                  
              </form>
        </div>
    </div>
</div>

<script src="/js/password-validation.js"></script>

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