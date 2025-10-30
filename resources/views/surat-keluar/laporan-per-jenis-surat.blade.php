
@extends('layouts.main')

@section('container')
<div class="div">
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif  
    <h3 class="fw-bold fs-4 mb-3">Surat Keluar Per Jenis Surat</h3>

    <div>
        <form action="/laporan/surat-keluar/per-jenis-surat" class="row g-3">

            <div class="col-auto">
                <label for="tanggalAwal" class="col-form-label">Tanggal Awal :</label>
              </div>
            <div class="col-auto">
                <input name="tanggalAwal" type="date" id="tanggalAwal" class="form-control" value="{{ request('tanggalAwal') }}">
            </div> 

            <div class="col-auto ms-3">
                <label for="tanggalAkhir" class="col-form-label">Tanggal Akhir :</label>
              </div>
            <div class="col-auto">
                <input name="tanggalAkhir" type="date" id="tanggalAkhir" class="form-control" value="{{ request('tanggalAkhir') }}">
            </div> 

            <div class="col-auto">
              <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i></button>
              </div>
        </form>

        <form action="/exportLaporan" method="POST" id="formExport" class="mt-3 mb-2">
          @csrf
          @foreach($suratKeluar as $item)
              <input type="hidden" name="koleksi[]" value="{{ $item }}">
          @endforeach
          <button type="submit" class="btn btn-success btn-sm">Export Data</button>
      </form>
    </div>

    <div class="div">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Jenis Surat</th>
                <th scope="col">Jumlah</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $total = 0;
                @endphp
              @foreach ($suratKeluar as $sk)
                  <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $sk->jenisSurat->kodeJenisSurat . '-' . $sk->jenisSurat->keterangan }}</td>
                    <td>{{ $sk->total_surat }}</td>
                  </tr>
                  @php
                    $no++;
                    $total += $sk->total_surat;
                  @endphp
              @endforeach
              <tr>
                <th colspan="2">Total</th>
                <th>{{ $total }}</th>
              </tr>
            </tbody>
          </table>
    </div>

</div>

<script>
  document.getElementById("formExport").addEventListener("submit", function(event) {
      // Mencegah perilaku default dari formulir
      event.preventDefault();
      // Membuka tab baru untuk menampilkan hasil proses formulir
      window.open('', '_blank');
      // Mengirimkan formulir secara programatik
      this.submit();
  });
</script>
@endsection