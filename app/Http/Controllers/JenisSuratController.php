<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class JenisSuratController extends Controller
{
    public function create() {
        $jenisSurat = JenisSurat::all();
        return view('jenis-surat.index', ['title' => 'Jenis Surat', 'active' => 'data master', 'jenisSurat' => $jenisSurat]);
    }

    public function tambah() {
        return view('jenis-surat.tambah', ['title' => 'Tambah Jenis Surat', 'active' => 'data master']);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming file. 
        $request->validate([
            'kodeJenisSurat' => 'required|unique:jenis_surat,kodeJenisSurat',
            'keterangan' => 'required|unique:jenis_surat,keterangan'
        ]);

        // Store file information in the database
        $jenisSurat = new JenisSurat();
        $jenisSurat->kodeJenisSurat = $request->input('kodeJenisSurat');
        $jenisSurat->keterangan = $request->input('keterangan');
        $jenisSurat->save();

        // Redirect back to the index page with a success message
        return redirect('/jenis-surat/index')->with('success', 'Berhasil Menambah Jenis Surat');
    }

    public function edit(JenisSurat $jenisSurat) {
        return view('jenis-surat.edit', ['title' => 'Edit Direksi', 'active' => 'data master', 'jenisSurat' => $jenisSurat]);
    }

    public function save(Request $request): RedirectResponse
    {
        // Validate the incoming file. 
        
        $request->validate([
            'kodeJenisSurat' => 'required',
            'keterangan' => 'required'
        ]);

        $jenisSurat = JenisSurat::find($request->input('id'));

        if ($jenisSurat->kodeJenisSurat != $request->input('kodeJenisSurat')) {
            $request->validate([
                'kodeJenisSurat' => 'unique:jenis_surat,kodeJenisSurat',
            ]);
        }

        if ($jenisSurat->keterangan != $request->input('keterangan')) {
            $request->validate([
                'keterangan' => 'unique:jenis_surat,keterangan',
            ]);
        }

        // Store file information in the database
        
        $jenisSurat->kodeJenisSurat = $request->input('kodeJenisSurat');
        $jenisSurat->keterangan = $request->input('keterangan');
        $jenisSurat->save();

        // Redirect back to the index page with a success message
        return redirect('/jenis-surat/index')->with('success', 'Berhasil Mengedit Jenis Surat');
    }
}
