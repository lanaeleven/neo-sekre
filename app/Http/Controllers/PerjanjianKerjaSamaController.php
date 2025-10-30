<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessNotifPerjanjianKerjaSamaBaru;
use App\Models\Direksi;
use App\Models\PerjanjianKerjaSama;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class PerjanjianKerjaSamaController extends Controller
{
    public function create()
    {

        $pks = PerjanjianKerjaSama::orderBy('tahun', 'desc')->orderBy('index', 'desc');
        $direksi = Direksi::all();
        $judul = "Perjanjian Kerja Sama";

        if (request('index')) {
            $pks->where('index', '=', request('index'));
        }

        if (request('tanggalAwal')) {
            $pks = $pks->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $pks = $pks->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        if (request('direksi')) {
            $pks->where('idDireksi', request('direksi'));
        }

        if (request('tujuan')) {
            $pks->where('tujuan', 'like', '%' . request('tujuan') . '%');
        }

        if (request('perihal')) {
            $pks->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        if (request('keterangan')) {
            $pks->where('keterangan', 'like', '%' . request('keterangan') . '%');
        }

        if (request('tahun')) {
            $pks->where('tahun', request('tahun'));
        }

        session([
            'search_tahun' => request('tahun')
        ]);

        return view('pks.index', ['title' => $judul, 'active' => 'pks', 'pks' => $pks->with(['direksi'])->paginate(15), 'direksi' => $direksi, 'judul' => $judul]);
    }

    public function tambah()
    {
        $direksi = Direksi::all();
        $users = User::where('id', '<>', 2)->where('isAktif', true)->get();

        return view('pks.tambah', [
            'title' => 'Tambah Perjanjian Kerja Sama',
            'active' => 'pks',
            'direksi' => $direksi,
            'users' => $users
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->id == 1) {
            $redirect = '/pks/index'
                . '?tahun=' . urlencode(session('search_tahun', ''));
        } else {
            $redirect = '/';
        }
        session()->forget('search_tahun');

        $request->validate([
            'tanggalSurat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'direksi' => 'required',
            'users' => 'required|array',
            'fileSurat' => 'required|mimes:pdf,jpg,png'
        ]);



        $tahun = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');
        $maxIndex = PerjanjianKerjaSama::where('tahun', $tahun)->max('index');
        $newIndex = $maxIndex ? $maxIndex + 1 : 1;

        $file = $request->file('fileSurat');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('uploads/pks/' . $tahun . '/' . $bulan, 'public');


        $pks = new PerjanjianKerjaSama();
        $pks->index = $newIndex;
        $pks->tahun = $tahun;
        $pks->idDireksi = $request->input('direksi');
        $pks->tanggalSurat = $request->input('tanggalSurat');
        $pks->tujuan = $request->input('tujuan');
        $pks->perihal = $request->input('perihal');
        $pks->keterangan = $request->input('keterangan');
        $pks->fileName = $fileName;
        $pks->filePath = $filePath;
        $pks->save();

        // $pks->units()->attach($request->input('units'));

        // $userUnit = User::whereHas('units', function ($query) use ($request) {
        //     $query->whereIn('unit_id', $request->input('units'));
        // })->get();

        // foreach ($userUnit as $un) {
        //     $job = new ProcessNotifPerjanjianKerjaSamaBaru($un->email, $un->namaJabatan, $request->input('perihal'));
        //     dispatch($job);
        // }

        $pks->users()->attach($request->input('users'));

        // $recipientUser = User::whereIn('id', $request->input('users'))->get();

        // foreach ($recipientUser as $ru) {
        //     $job = new ProcessNotifPerjanjianKerjaSamaBaru($ru->email, $ru->namaJabatan, $request->input('perihal'));
        //     dispatch($job);
        // }

        return redirect($redirect)
            ->with('success', 'Berhasil Menambahkan Perjanjian Kerja Sama');
    }

    public function edit(PerjanjianKerjaSama $pks)
    {
        $direksi = Direksi::all();
        $users = User::where('id', '<>', 2)->get();

        return view('pks.edit', ['title' => 'Edit Perjanjian Kerja Sama', 'active' => 'pks', 'pks' => $pks, 'direksi' => $direksi, 
        'users' => $users
    ]);
    }

    public function save(Request $request): RedirectResponse
    {
        if (auth()->user()->id == 1) {
            $redirect = '/pks/index'
                . '?tahun=' . urlencode(session('search_tahun', ''));
        } else {
            $redirect = '/';
        }
        session()->forget('search_tahun');

        $request->validate([
            'tanggalSurat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'direksi' => 'required',
            'users' => 'required|array',
            'fileSurat' => 'mimes:pdf,jpg,png'
        ]);

        $tahunInput = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');

        if ($request->file('fileSurat')) {
            $file = $request->file('fileSurat');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('uploads/pks/' . $tahunInput . '/' . $bulan, 'public');
        }


        // Store file information in the database
        $pks = PerjanjianKerjaSama::find($request->input('id'));

        $pks->idDireksi = $request->input('direksi');
        $pks->tanggalSurat = $request->input('tanggalSurat');
        $pks->tujuan = $request->input('tujuan');
        $pks->perihal = $request->input('perihal');
        $pks->keterangan = $request->input('keterangan');
        if ($request->file('fileSurat')) {
            $pks->fileName = $fileName;
            $pks->filePath = $filePath;
        }

        if ($tahunInput != $request->input('tahun')) {
            $maxIndex = PerjanjianKerjaSama::where('tahun', $tahunInput)->max('index');
            $newIndex = $maxIndex ? $maxIndex + 1 : 1;

            $pks->tahun = $tahunInput;
            $pks->index = $newIndex;
        }
        $pks->save();

        $pks->users()->sync($request->input('users'));

        return redirect($redirect)
            ->with('success', 'Berhasil Mengedit Perjanjian Kerja Sama');
    }

    public function listPerjanjianKerjaSamaNs()
    {
        $userId = auth()->user()->id;

        $pks = PerjanjianKerjaSama::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        });


        $direksi = Direksi::all();
        $judul = "Perjanjian Kerja Sama";

        if (request('index')) {
            $pks->where('index', '=', request('index'));
        }

        if (request('tanggalAwal')) {
            $pks = $pks->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $pks = $pks->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        if (request('tujuan')) {
            $pks->where('tujuan', 'like', '%' . request('tujuan') . '%');
        }

        if (request('perihal')) {
            $pks->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        if (request('keterangan')) {
            $pks->where('keterangan', 'like', '%' . request('keterangan') . '%');
        }

        return view('pks.index-ns', ['title' =>  $judul, 'active' => 'pks', 'pks' => $pks->with('direksi')->orderBy('tahun', 'desc')->orderBy('index', 'desc')->paginate(15), 'direksi' => $direksi, 'judul' => $judul]);
    }
}
