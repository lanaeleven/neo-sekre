<?php

namespace App\Http\Controllers;

use App\Models\JenisRegulasi;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class JenisRegulasiController extends Controller
{
    public function create() {
        $jenisRegulasi = JenisRegulasi::all();
        return view('jenis-regulasi.index', ['title' => 'Jenis Regulasi', 'active' => 'data master', 'jenisRegulasi' => $jenisRegulasi]);
    }

    public function tambah() {
        return view('jenis-regulasi.tambah', ['title' => 'Tambah Jenis Regulasi', 'active' => 'data master']);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kodeJenisRegulasi' => 'required|unique:jenis_regulasi,kodeJenisRegulasi',
            'keterangan' => 'required|unique:jenis_regulasi,keterangan'
        ]);

        $jenisRegulasi = new JenisRegulasi();
        $jenisRegulasi->kodeJenisRegulasi = $request->input('kodeJenisRegulasi');
        $jenisRegulasi->keterangan = $request->input('keterangan');
        $jenisRegulasi->save();

        return redirect('/jenis-regulasi/index')->with('success', 'Berhasil Menambah Jenis Regulasi');
    }

    public function edit(JenisRegulasi $jenisRegulasi) {
        return view('jenis-regulasi.edit', ['title' => 'Edit Jenis Regulasi', 'active' => 'data master', 'jenisRegulasi' => $jenisRegulasi]);
    }

    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'kodeJenisRegulasi' => 'required',
            'keterangan' => 'required'
        ]);

        $jenisRegulasi = JenisRegulasi::find($request->input('id'));

        if ($jenisRegulasi->kodeJenisRegulasi != $request->input('kodeJenisRegulasi')) {
            $request->validate([
                'kodeJenisRegulasi' => 'unique:jenis_regulasi,kodeJenisRegulasi',
            ]);
        }

        if ($jenisRegulasi->keterangan != $request->input('keterangan')) {
            $request->validate([
                'keterangan' => 'unique:jenis_regulasi,keterangan',
            ]);
        }
        
        $jenisRegulasi->kodeJenisRegulasi = $request->input('kodeJenisRegulasi');
        $jenisRegulasi->keterangan = $request->input('keterangan');
        $jenisRegulasi->save();

        return redirect('/jenis-regulasi/index')->with('success', 'Berhasil Mengedit Jenis Regulasi');
    }
}
