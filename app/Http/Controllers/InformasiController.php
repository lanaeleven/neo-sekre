<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessNotifInformasiBaru;
use App\Models\Informasi;
use App\Models\JenisInformasi;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class InformasiController extends Controller
{
    public function create()
    {

        $informasi = Informasi::orderBy('tahun', 'desc')->orderBy('index', 'desc');
        $jenisInformasi = JenisInformasi::all();
        $judul = "Informasi";

        if (request('index')) {
            $informasi->where('index', '=', request('index'));
        }

        if (request('tanggalAwal')) {
            $informasi = $informasi->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $informasi = $informasi->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        if (request('jenisInformasi')) {
            $informasi->where('idJenisInformasi', request('jenisInformasi'));
        }

        if (request('judul')) {
            $informasi->where('judul', 'like', '%' . request('judul') . '%');
        }

        if (request('tahun')) {
            $informasi->where('tahun', request('tahun'));
        }

        session([
            'search_tahun' => request('tahun')
        ]);

        return view('informasi.index', ['title' => $judul, 'active' => 'informasi', 'informasi' => $informasi->with(['jenisInformasi'])->paginate(15), 'jenisInformasi' => $jenisInformasi, 'judul' => $judul]);
    }

    public function listInformasiNs()
    {
        $userId = auth()->user()->id;

        $informasi = Informasi::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        });
        $jenisInformasi = JenisInformasi::all();

        $judul = "Informasi";

        if (request('index')) {
            $informasi->where('index', '=', request('index'));
        }

        if (request('tanggalAwal')) {
            $informasi = $informasi->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $informasi = $informasi->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        if (request('jenisInformasi')) {
            $informasi->where('idJenisInformasi', request('jenisInformasi'));
        }

        if (request('judul')) {
            $informasi->where('judul', 'like', '%' . request('judul') . '%');
        }

        return view('informasi.index-ns', ['title' =>  $judul, 'active' => 'informasi', 'informasi' => $informasi->with('jenisInformasi')->orderBy('tahun', 'desc')->orderBy('index', 'desc')->paginate(15), 'judul' => $judul, 'jenisInformasi' => $jenisInformasi]);
    }

    public function tambah()
    {
        $jenisInformasi = JenisInformasi::all();
        $users = User::where('id', '<>', 2)->where('isAktif', true)->get();

        return view('informasi.tambah', [
            'title' => 'Tambah Informasi',
            'active' => 'informasi',
            'jenisInformasi' => $jenisInformasi,
            'users' => $users
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->id == 1) {
            $redirect = '/informasi/index'
                . '?tahun=' . urlencode(session('search_tahun', ''));
        } else {
            $redirect = '/';
        }
        session()->forget('search_tahun');

        $request->validate([
            'jenisInformasi' => 'required',
            'tanggalSurat' => 'required',
            'judul' => 'required',
            'users' => 'required|array',
            'fileSurat' => 'required|mimes:pdf,jpg,png|max:12288'
        ]);



        $tahun = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');
        $maxIndex = Informasi::where('tahun', $tahun)->max('index');
        $newIndex = $maxIndex ? $maxIndex + 1 : 1;

        $file = $request->file('fileSurat');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('uploads/informasi/' . $tahun . '/' . $bulan, 'public');


        $informasi = new Informasi();
        $informasi->index = $newIndex;
        $informasi->tahun = $tahun;
        $informasi->idJenisInformasi = $request->input('jenisInformasi');
        $informasi->tanggalSurat = $request->input('tanggalSurat');
        $informasi->judul = $request->input('judul');
        $informasi->fileName = $fileName;
        $informasi->filePath = $filePath;
        $informasi->save();

        $informasi->users()->attach($request->input('users'));

        // $recipientUser = User::whereIn('id', $request->input('users'))->get();

        // $namaJenisInformasi = JenisInformasi::find($request->input('jenisInformasi'))->nama;

        // foreach ($recipientUser as $ru) {
        //     $job = new ProcessNotifInformasiBaru($ru->email, $ru->namaJabatan, $namaJenisInformasi, $request->input('judul'));
        //     dispatch($job);
        // }

        return redirect($redirect)
            ->with('success', 'Berhasil Menambahkan Informasi');
    }

    public function edit(Informasi $informasi)
    {
        $jenisInformasi = JenisInformasi::all();
        $users = User::where('id', '<>', 2)->get();

        return view('informasi.edit', [
            'title' => 'Edit Informasi',
            'active' => 'informasi',
            'informasi' => $informasi,
            'jenisInformasi' => $jenisInformasi,
            'users' => $users
        ]);
    }

    public function save(Request $request): RedirectResponse
    {
        if (auth()->user()->id == 1) {
            $redirect = '/informasi/index'
                . '?tahun=' . urlencode(session('search_tahun', ''));
        } else {
            $redirect = '/';
        }
        session()->forget('search_tahun');

        $request->validate([
            'jenisInformasi' => 'required',
            'judul' => 'required',
            'tanggalSurat' => 'required',
            'users' => 'required|array',
            'fileSurat' => 'mimes:pdf,jpg,png|max:12288'
        ]);

        $tahunInput = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');

        if ($request->file('fileSurat')) {
            $file = $request->file('fileSurat');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('uploads/informasi/' . $tahunInput . '/' . $bulan, 'public');
        }


        // Store file information in the database
        $informasi = Informasi::find($request->input('id'));

        $informasi->idJenisInformasi = $request->input('jenisInformasi');
        $informasi->judul = $request->input('judul');
        $informasi->tanggalSurat = $request->input('tanggalSurat');
        if ($request->file('fileSurat')) {
            $informasi->fileName = $fileName;
            $informasi->filePath = $filePath;
        }
        if ($tahunInput != $request->input('tahun')) {
            $maxIndex = Informasi::where('tahun', $tahunInput)->max('index');
            $newIndex = $maxIndex ? $maxIndex + 1 : 1;

            $informasi->tahun = $tahunInput;
            $informasi->index = $newIndex;
        }
        $informasi->save();

        $informasi->users()->sync($request->input('users'));

        return redirect($redirect)
            ->with('success', 'Berhasil Mengedit Informasi');
    }
}
