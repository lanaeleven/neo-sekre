<?php

namespace App\Http\Controllers;

use App\Models\JenisSuratMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JenisSuratMasukController extends Controller
{
    public function create()
    {
        $jenisSurat = JenisSuratMasuk::all();
        return view('jenis-surat-masuk.index', ['title' => 'Daftar Jenis Surat Masuk', 'active' => 'data master', 'jenisSurat' => $jenisSurat, 'isForm' => false]);
    }

    public function tambah()
    {
        return view('jenis-surat-masuk.tambah', ['title' => 'Tambah Jenis Surat', 'active' => 'data master', 'isForm' => true]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming file. 
        $request->validate([
            'nama' => 'required|unique:jenis_surat_masuk,nama',
        ]);

        // Store file information in the database
        $jenisSurat = new JenisSuratMasuk();
        $jenisSurat->nama = $request->input('nama');
        $jenisSurat->save();

        // Redirect back to the index page with a success message
        return redirect('/jenis-surat-masuk/index')->with('success', 'Berhasil Menambah Jenis Surat Masuk');
    }

    public function edit(JenisSuratMasuk $jenisSurat)
    {
        return view('jenis-surat-masuk.edit', ['title' => 'Edit Jenis Surat Masuk', 'active' => 'data master', 'jenisSurat' => $jenisSurat, 'isForm' => true]);
    }

    public function save(Request $request): RedirectResponse
    {
        // Validate the incoming file. 

        $request->validate([
            'nama' => 'required',
        ]);

        $jenisSurat = JenisSuratMasuk::find($request->input('id'));

        if ($jenisSurat->kodeJenisSurat != $request->input('nama')) {
            $request->validate([
                'nama' => 'unique:jenis_surat_masuk,nama',
            ]);
        }


        // Store file information in the database

        $jenisSurat->nama = $request->input('nama');
        $jenisSurat->save();

        // Redirect back to the index page with a success message
        return redirect('/jenis-surat-masuk/index')->with('success', 'Berhasil Mengedit Jenis Surat Masuk');
    }
}
