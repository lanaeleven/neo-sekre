<?php

namespace App\Http\Controllers;

use App\Models\Direksi;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DireksiController extends Controller
{
    public function create() {
        $direksi = Direksi::all();
        return view('direksi.index', ['title' => 'Direksi', 'active' => 'data master', 'direksi' => $direksi]);
    }

    public function tambah() {
        return view('direksi.tambah', ['title' => 'Tambah Direksi', 'active' => 'data master']);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming file.
        $request->validate([
            'namaDireksi' => 'required|unique:direksi,namaDireksi',
        ]);

        // Store file information in the database
        $direksi = new Direksi();
        $direksi->namaDireksi = $request->input('namaDireksi');
        $direksi->save();

        // Redirect back to the index page with a success message
        return redirect('/direksi/index')->with('success', 'Berhasil Menambahkan Direksi');
    }

    public function edit(Direksi $direksi) {
        return view('direksi.edit', ['title' => 'Edit Direksi', 'active' => 'data master', 'direksi' => $direksi]);
    }

    public function save(Request $request): RedirectResponse
    {
        // Validate the incoming file. 
        
        $request->validate([
            'namaDireksi' => 'required',
        ]);

        $direksi = Direksi::find($request->input('id'));

        if ($direksi->namaDireksi != $request->input('namaDireksi')) {
            $request->validate([
                'namaDireksi' => 'unique:direksi,namaDireksi',
            ]);
        }

        // Store file information in the database
        
        $direksi->namaDireksi = $request->input('namaDireksi');
        $direksi->save();

        // Redirect back to the index page with a success message
        return redirect('/direksi/index')->with('success', 'Berhasil Mengedit Direksi');
    }
}
