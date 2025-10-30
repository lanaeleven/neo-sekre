<?php

namespace App\Http\Controllers;

use App\Models\JenisInformasi;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class JenisInformasiController extends Controller
{
    public function create()
    {
        $jenisInformasi = JenisInformasi::all();
        return view('jenis-informasi.index', ['title' => 'Jenis Informasi', 'active' => 'data master', 'jenisInformasi' => $jenisInformasi]);
    }

    public function tambah()
    {
        return view('jenis-informasi.tambah', ['title' => 'Tambah Jenis Informasi', 'active' => 'data master']);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'jenisInformasi' => 'required|unique:jenis_informasi,nama',
        ]);

        $jenisInformasi = new JenisInformasi();
        $jenisInformasi->nama = $request->input('jenisInformasi');
        $jenisInformasi->save();

        return redirect('/jenis-informasi/index')->with('success', 'Berhasil Menambah Jenis Informasi');
    }

    public function edit(JenisInformasi $jenisInformasi) {
        return view('jenis-informasi.edit', ['title' => 'Edit Jenis Informasi', 'active' => 'data master', 'jenisInformasi' => $jenisInformasi]);
    }

    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'jenisInformasi' => 'required',
        ]);

        $jenisInformasi = JenisInformasi::find($request->input('id'));

        if ($jenisInformasi->nama != $request->input('JenisInformasi')) {
            $request->validate([
                'jenisInformasi' => 'unique:jenis_informasi,nama',
            ]);
        }
        
        $jenisInformasi->nama = $request->input('jenisInformasi');
        $jenisInformasi->save();

        return redirect('/jenis-informasi/index')->with('success', 'Berhasil Mengedit Jenis Informasi');
    }
}
