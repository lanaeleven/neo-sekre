<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UnitController extends Controller
{
    public function index()
    {
        $unit = Unit::all();
        return view('unit.index', ['title' => 'Unit', 'active' => 'data master', 'unit' => $unit]);
    }

    public function tambah()
    {
        return view('unit.tambah', ['title' => 'Tambah Unit', 'active' => 'data master']);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming file. 
        $request->validate([
            'namaUnit' => 'required|unique:unit,nama'
        ]);

        // Store file information in the database
        $unit = new Unit();
        $unit->nama = $request->input('namaUnit');
        $unit->save();

        // Redirect back to the index page with a success message
        return redirect('/unit/index')->with('success', 'Berhasil Menambah Unit');
    }

    public function edit(Unit $unit)
    {
        return view('unit.edit', ['title' => 'Edit Unit', 'active' => 'data master', 'unit' => $unit]);
    }

    public function save(Request $request): RedirectResponse
    {

        // Validate the incoming file. 

        $request->validate([
            'namaUnit' => 'required'
        ]);

        $unit = Unit::find($request->input('id'));

        if ($unit->nama != $request->input('namaUnit')) {
            $request->validate([
                'namaUnit' => 'unique:unit,nama',
            ]);
        }

        // Store file information in the database

        $unit->nama = $request->input('namaUnit');
        $unit->save();

        // Redirect back to the index page with a success message
        return redirect('/unit/index')->with('success', 'Berhasil Mengedit Unit');
    }

    public function delete($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->back()->with('success', 'Unit berhasil dihapus.');
    }
}
