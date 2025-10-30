<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\RedirectResponse;

class StrukturOrganisasiController extends Controller
{
    public function tambah(User $user) {

        $atasan = User::where('id', '<>', 1)->where('id', '<>', 2)->with(['strukturOrganisasi'])->get();

        return view('struktur-organisasi.tambah', 
        [
            'title' => 'Daftar Struktur Organisasi',
            'active' => 'data master',
            'atasan' => $atasan,
            'user' => $user
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming file. 
        $request->validate([
            'idUser' => 'required',
            'idAtasan' => 'required',
            'levelJabatan' => 'required'
        ]);

        // Store file information in the database
        $so = new StrukturOrganisasi();
        $so->idUser = $request->input('idUser');
        $so->idAtasan = $request->input('idAtasan');
        $so->levelJabatan = $request->input('levelJabatan');
        $so->save();

        // Redirect back to the index page with a success message
        return redirect('/user/edit/' . $request->input('idUser'))->with('success', 'Berhasil Mengatur SOTK');
    }

    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'idUser' => 'required',
            'idAtasan' => 'required',
            'levelJabatan' => 'required'
        ]);

        $so = StrukturOrganisasi::where('idUser', $request->input('idUser'))->first();
        
        $so->idAtasan = $request->input('idAtasan');
        $so->levelJabatan = $request->input('levelJabatan');
        $so->save();

        // Redirect back to the index page with a success message
        return redirect('/user/edit/' . $request->input('idUser'))->with('success', 'Berhasil Mengupdate SOTK');
    }
}
