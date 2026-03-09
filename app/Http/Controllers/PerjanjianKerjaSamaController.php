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

        if (request('tahun')) {
            $pks->where('tahun', request('tahun'));
        }

        session([
            'search_tahun' => request('tahun')
        ]);

        return view('pks.index', ['title' => $judul, 'active' => 'pks', 'pks' => $pks->paginate(25), 'judul' => $judul, 'isForm' => false]);
    }

    public function tambah()
    {
        $users = User::where('id', '<>', 2)->where('isAktif', true)->get();

        $opsiUsers = $users->map(function ($u) {
            return (object)[
                'id' => $u->id,
                'nama' => $u->namaJabatan
            ];
        });

        return view('pks.tambah', [
            'title' => 'Tambah Perjanjian Kerja Sama',
            'active' => 'pks',
            'users' => $opsiUsers,
            'isForm' => true
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
        $pks->tanggalSurat = $request->input('tanggalSurat');
        $pks->tujuan = $request->input('tujuan');
        $pks->perihal = $request->input('perihal');
        $pks->keterangan = $request->input('keterangan');
        $pks->fileName = $fileName;
        $pks->filePath = $filePath;
        $pks->save();

        $pks->users()->attach($request->input('users'));

        $recipientUser = User::whereIn('id', $request->input('users'))->get();

        foreach ($recipientUser as $ru) {
            $job = new ProcessNotifPerjanjianKerjaSamaBaru($ru->email, $ru->nama, $request->input('perihal'));
            dispatch($job);
        }

        return redirect($redirect)
            ->with('success', 'Berhasil Menambahkan Perjanjian Kerja Sama');
    }

    public function edit(PerjanjianKerjaSama $pks)
    {
        $users = User::where('id', '<>', 2)->get();
        $opsiUsers = $users->map(function ($u) {
            return (object)[
                'id' => $u->id,
                'nama' => $u->namaJabatan
            ];
        });

        return view('pks.edit', [
            'title' => 'Edit Perjanjian Kerja Sama',
            'active' => 'pks',
            'pks' => $pks,
            'users' => $opsiUsers,
            'isForm' => true
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

        return view('pks.index-ns', ['title' =>  $judul, 'active' => 'pks', 'pks' => $pks->orderBy('tahun', 'desc')->orderBy('index', 'desc')->paginate(25), 'judul' => $judul, 'isForm' => false]);
    }

    public function delete ($id)
    {
        $pks = PerjanjianKerjaSama::find($id);
        $pks->delete();
        return redirect('/pks/index')
            ->with('success', "Berhasil Menghapus Perjanjian Kerja Sama");
    }
}
