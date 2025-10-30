<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Direksi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use App\Models\DistribusiSurat;
use App\Models\TujuanDisposisi;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

class SuratMasukController extends Controller
{
    public function create(?string $keterangan = null) {
        // dd($keterangan);
        $suratMasuk = SuratMasuk::orderBy('id', 'desc');
        $direksi = Direksi::all();
        $judul = "Surat Masuk";

        if ($keterangan === 'hari-ini') {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '=', now());
            $judul = "Surat Masuk Hari Ini";
        }

        if ($keterangan === 'bulan-ini') {
            $suratMasuk = $suratMasuk->whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'));
            $judul = "Surat Masuk Bulan Ini";
        }

        if (request('index')) {
            $suratMasuk->where('id', '=', request('index'));
        }

        if (request('tahun')) {
            $suratMasuk->whereYear('tanggalSurat', request('tahun'));
        }

        if (request('direksi')) {
            $suratMasuk->where('idDireksi', request('direksi'));
        }

        if (request('status')) {
            $suratMasuk->where('status', request('status'));
        }

        if (request('pengirim')) {
            $suratMasuk->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }

        if (request('nomorSurat')) {
            $suratMasuk->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }

        if (request('perihal')) {
            $suratMasuk->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        return view('surat-masuk.index', ['title' => 'App Surat | ' . $judul, 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk->paginate(15), 'direksi' => $direksi, 'keterangan' => $keterangan, 'judul' => $judul]);
    }

    public function tambah() {
        $direksi = Direksi::all();
        

        return view('surat-masuk.tambah', ['title' => 'App Surat | Tambah Surat Masuk', 'active' => 'surat masuk', 'direksi' => $direksi]);
    }

    public function store(Request $request): RedirectResponse
    {
        // dd($request->file());
        // Validate the incoming file. Refuses anything bigger than 5120 kilobyes (=5MB)
        $request->validate([
            'idPosisiDisposisi' => 'required',
            'tanggalAgenda' => 'required',
            'sifatSurat' => 'required',
            'nomorSurat' => 'required',
            'tanggalSurat' => 'required',
            'lampiran' => 'required',
            'pengirim' => 'required',
            'direksi' => 'required',
            'perihal' => 'required',
            'fileSurat' => 'required|mimes:pdf|max:5120'
        ]);

        // Store the file in storage\app\public folder
        $file = $request->file('fileSurat');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('uploads/surat-masuk', 'public');

        // Store file information in the database
        $suratMasuk = new SuratMasuk();
        $suratMasuk->idPosisiDisposisi =$request->input('idPosisiDisposisi');
        $suratMasuk->tanggalAgenda =$request->input('tanggalAgenda');
        $suratMasuk->sifatSurat =$request->input('sifatSurat');
        $suratMasuk->nomorSurat =$request->input('nomorSurat');
        $suratMasuk->tanggalSurat =$request->input('tanggalSurat');
        $suratMasuk->lampiran =$request->input('lampiran');
        $suratMasuk->pengirim =$request->input('pengirim');
        $suratMasuk->idDireksi =$request->input('direksi');
        $suratMasuk->perihal =$request->input('perihal');
        $suratMasuk->status =$request->input('status');
        $suratMasuk->fileName = $fileName;
        $suratMasuk->filePath = $filePath;
        $suratMasuk->save();

        // Redirect back to the index page with a success message
        return redirect('/surat-masuk/index')
            ->with('success', "File uploaded successfully.");
    }

    public function edit(SuratMasuk $suratMasuk) {
        // dd($suratMasuk);
        $direksi = Direksi::all();

        return view('surat-masuk.edit', ['title' => 'App Surat | Edit Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk, 'direksi' => $direksi]);
    }

    public function save(Request $request): RedirectResponse
    {
        // Validate the incoming file. Refuses anything bigger than 5120 kilobyes (=5MB)
        $request->validate([
            'tanggalAgenda' => 'required',
            'sifatSurat' => 'required',
            'nomorSurat' => 'required',
            'tanggalSurat' => 'required',
            'lampiran' => 'required',
            'pengirim' => 'required',
            'direksi' => 'required',
            'perihal' => 'required',
            'fileSurat' => 'mimes:pdf|max:5120'
        ]);

        if ($request->file('fileSurat')) {
            // Store the file in storage\app\public folder
            $file = $request->file('fileSurat');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('uploads/surat-masuk', 'public');
        }

        // Store file information in the database
        $suratMasuk = SuratMasuk::find($request->input('id'));
        $suratMasuk->tanggalAgenda =$request->input('tanggalAgenda');
        $suratMasuk->sifatSurat =$request->input('sifatSurat');
        $suratMasuk->nomorSurat =$request->input('nomorSurat');
        $suratMasuk->tanggalSurat =$request->input('tanggalSurat');
        $suratMasuk->lampiran =$request->input('lampiran');
        $suratMasuk->pengirim =$request->input('pengirim');
        $suratMasuk->idDireksi =$request->input('direksi');
        $suratMasuk->perihal =$request->input('perihal');
        $suratMasuk->status =$request->input('status');
        if ($request->file('fileSurat')) {
            $suratMasuk->fileName = $fileName;
            $suratMasuk->filePath = $filePath;
        }
        $suratMasuk->save();

        // Redirect back to the index page with a success message
        return redirect('/surat-masuk/index')
            ->with('success', "File uploaded successfully.");
    }

    public function fungsiLama_disposisi(SuratMasuk $suratMasuk) { 
        // dd(auth()->user()->level);

        $terusan = null;
        $distribusiSurat = null;
        $tujuanDisposisi = null; 

        if (auth()->user()->level === 'direktur') {
            $tujuanDisposisi = TujuanDisposisi::where('idUser', '=', auth()->user()->id)->get();
            $terusan = TujuanDisposisi::where('levelTujuanDisposisi', '=', 'kepala')->get();
            $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->where('idTujuanDisposisi', '=', $tujuanDisposisi[0]->id)->get();
        }

        if (auth()->user()->level === 'kepala') {
            $tujuanDisposisi = TujuanDisposisi::where('idUser', '=', auth()->user()->id)->get();
            $terusan = TujuanDisposisi::where('levelTujuanDisposisi', '=', 'penjab')->where('divisiTujuanDisposisi', '=', $tujuanDisposisi[0]->divisiTujuanDisposisi)->get();
            $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->where('idTujuanDisposisi', '=', $tujuanDisposisi[0]->id)->get();
        }

        if (auth()->user()->level === 'penjab') {
            $tujuanDisposisi = TujuanDisposisi::where('idUser', '=', auth()->user()->id)->get();
            $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->where('idTujuanDisposisi', '=', $tujuanDisposisi[0]->id)->get();
        }

        return view('surat-masuk.disposisi', ['title' => 'App Surat | Disposisi Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk, 'terusan' => $terusan, 'distribusiSurat' => $distribusiSurat]);
    }

    public function disposisi(SuratMasuk $suratMasuk) {

        $terusan = User::all();
        
        
        // PENGECEKAN APAKAH SURAT MASUK SUDAH PERNAH DITERUSKAN ATAU BELUM, JIKA BELUM MAKA TIDAK MELEWATI GATE DISPOSISI-SURAT
        if (DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->exists()) {
            $cekDS = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->orderBy('id', 'desc')->get()[0];
            if (! Gate::allows('disposisi-surat', $cekDS) || $cekDS->status === "Diarsipkan") {
                abort(403);
            }
        }

        // PENGECEKAN APAKAH SURAT MASUK YANG BELUM DITERUSKAN DIAKSES OLEH ADMIN ATAU BUKAN, JIKA BUKAN ADMIN MAKA TIDAK DIPERBOLEHKAN
        if ($suratMasuk->status === "Belum Diteruskan" && auth()->user()->id !== 1) {
            abort(403);
        }

        // JIKA SUDAH MELEWATI SEMUA GATE, KEMUDIAN AMBIL DATA DISTRIBUSI SURAT
        $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->get();
        
        // if (auth()->user()->level === 'direktur') {
        //     $terusan = User::where('level', '=', 'kepala')->get();
        // }

        // if (auth()->user()->level === 'kepala') {
        //     $terusan = User::where('level', '=', 'penjab')->where('divisi', '=', auth()->user()->divisi)->get();
        // }

        return view('surat-masuk.disposisi', ['title' => 'App Surat | Disposisi Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk, 'terusan' => $terusan, 'distribusiSurat' => $distribusiSurat]);
    }

    public function fungsiLama_teruskan(Request $request): RedirectResponse
    {
        
        // dd($suratMasuk->status);
        // dd($request->input());
        
        $redirect = '/surat-masuk/index';
        if (auth()->user()->level === 'direktur') {
            $redirect = '/surat-masuk/d/belum-diteruskan';
        }

        if (auth()->user()->level === 'kepala') {
            $redirect = '/surat-masuk/kb/belum-diteruskan';
        }

        if (auth()->user()->level === 'penjab') {
            $redirect = '/surat-masuk/pj/belum-diteruskan';
        }
        
        $request->validate([
            'idTujuanDisposisi' => 'required',
            'idSuratMasuk' => 'required',
            'instruksi' => 'required',
            'statusSuratLanjutan' => 'required',
            'idPengirimDisposisi' => 'required'
        ]);

        // Store file information in the database
        $distribusiSurat = new DistribusiSurat();
        $distribusiSurat->idTujuanDisposisi = $request->input('idTujuanDisposisi');
        $distribusiSurat->idPengirimDisposisi = $request->input('idPengirimDisposisi');
        $distribusiSurat->idSuratMasuk = $request->input('idSuratMasuk');
        $distribusiSurat->instruksi = $request->input('instruksi');
        $distribusiSurat->tanggalDiteruskan = now();
        $distribusiSurat->status = $request->input('statusSuratLanjutan');
        $distribusiSurat->save();

        $suratMasuk = SuratMasuk::find($request->input('idSuratMasuk'));
        $suratMasuk->status = $request->input('statusSuratLanjutan');
        $suratMasuk->save();

        // Redirect back to the index page with a success message
        return redirect($redirect)
            ->with('success', "File uploaded successfully.");
    }

    public function teruskan(Request $request): RedirectResponse
    {
        // dd($request->input());
        
        $redirect = '/surat-masuk/index';
        
        $request->validate([
            'idTujuanDisposisi' => 'required',
            'idSuratMasuk' => 'required',
            'instruksi' => 'required',
            'idPengirimDisposisi' => 'required'
        ]);

        $tujuanDisposisi = User::find($request->input('idTujuanDisposisi'));
        $status = "Diteruskan ke " . $tujuanDisposisi->namaJabatan;
        // dd($status);

        // Store file information in the database
        $distribusiSurat = new DistribusiSurat();
        $distribusiSurat->idTujuanDisposisi = $request->input('idTujuanDisposisi');
        $distribusiSurat->idPengirimDisposisi = $request->input('idPengirimDisposisi');
        $distribusiSurat->idSuratMasuk = $request->input('idSuratMasuk');
        $distribusiSurat->instruksi = $request->input('instruksi');
        $distribusiSurat->tanggalDiteruskan = now();
        $distribusiSurat->status = $status;
        $distribusiSurat->save();

        $suratMasuk = SuratMasuk::find($request->input('idSuratMasuk'));
        $suratMasuk->idPosisiDisposisi = $request->input('idTujuanDisposisi');
        $suratMasuk->status = $status;
        $suratMasuk->save();

        // Redirect back to the index page with a success message
        return redirect($redirect)
            ->with('success', "File uploaded successfully.");
    }

    public function direkturBelumDiteruskan() {
        $suratMasuk = SuratMasuk::where('status', '=', 'Diteruskan ke Direktur')->orderBy('id', 'desc');
        return view('surat-masuk.surat-disposisi-belum-diteruskan', ['title' => 'App Surat | Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk->paginate(15)]);
    }

    public function direkturSudahDiteruskan() {
        $suratMasuk = SuratMasuk::where('status', '<>', 'Diteruskan ke Direktur')->where('status', '<>', 'Belum Diteruskan')->orderBy('id', 'desc');        
        return view('surat-masuk.surat-disposisi-sudah-diteruskan', ['title' => 'App Surat | Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk->paginate(15)]);
    }

    public function lihatSuratDisposisi(SuratMasuk $suratMasuk) {
        $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->where('status', '=', $suratMasuk->status)->get();
        return view('surat-masuk.lihat-disposisi', ['title' => 'App Surat | Disposisi Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk, 'distribusiSurat' => $distribusiSurat]);
    }

    public function kepalaBagianBelumDiteruskan() {
        $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->menerimaDS;
        
        $suratMasuk = collect([]);
        foreach ($distribusiSurat as $ds) {
            if ($ds->suratMasuk->status === 'Diteruskan ke Kepala Bagian') {
                $suratMasuk->push($ds->suratMasuk);
            }  
        }
        return view('surat-masuk.surat-disposisi-belum-diteruskan', ['title' => 'App Surat | Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk]);
    }

    public function kepalaBagianSudahDiteruskan() {
        $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDS;
        $suratMasuk = collect([]);
        foreach ($distribusiSurat as $ds) {
            if ($ds->suratMasuk->status === 'Diteruskan ke Penanggung Jawab' || $ds->suratMasuk->status === 'Diarsipkan') {
                $suratMasuk->push($ds->suratMasuk);
            }
        }
        return view('surat-masuk.surat-disposisi-sudah-diteruskan', ['title' => 'App Surat | Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk]);
    }

    public function penanggungJawabBelumDiteruskan() {
        $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->menerimaDS;
        $suratMasuk = collect([]);
        foreach ($distribusiSurat as $ds) {
            if ($ds->suratMasuk->status === 'Diteruskan ke Penanggung Jawab') {
                $suratMasuk->push($ds->suratMasuk);
            } 
        }
        return view('surat-masuk.surat-disposisi-belum-diteruskan', ['title' => 'App Surat | Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk]);
    }

    public function penanggungJawabSudahDiteruskan() {
        $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDS;
        $suratMasuk = collect([]);
        foreach ($distribusiSurat as $ds) {
            if ($ds->suratMasuk->status === 'Diarsipkan') {
                $suratMasuk->push($ds->suratMasuk);
            }
        }
        return view('surat-masuk.surat-disposisi-sudah-diteruskan', ['title' => 'App Surat | Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk]);
    }

    public function lacakDistribusi(SuratMasuk $suratMasuk) {
        $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->get();
        return view('surat-masuk.lacak-distribusi', ['title' => 'App Surat | Disposisi Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk, 'distribusiSurat' => $distribusiSurat]);
    }

    public function laporanPerDireksi() {
        $suratMasuk = SuratMasuk::orderBy('idDireksi', 'asc');
        $suratMasuk->select('idDireksi', SuratMasuk::raw('COUNT(idDireksi) as total_surat'))->groupBy('idDireksi');

        if (request('tanggalAwal')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }        

        return view('surat-masuk.laporan-per-direksi', ['title' => 'App Surat | Surat Masuk Per Direksi', 'active' => 'laporan', 'suratMasuk' => $suratMasuk->get()]);
    }
}