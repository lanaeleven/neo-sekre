<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserKepala;
use Illuminate\Http\Request;
use App\Models\PenerimaKhusus;
use App\Models\PengirimKhusus;
use App\Models\StrukturOrganisasi;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function create()
    {
        // mengambil id kepala dalam bentuk array
        $idKepala = UserKepala::select('idUser')->get();
        $arrIdKepala = [];
        foreach ($idKepala as $ik) {
            array_push($arrIdKepala, $ik->idUser);
        }

        $user = User::where('id', '<>', 2)->with(['strukturOrganisasi'])->get();

        // dd($user);
        return view('user.index', ['title' => 'User', 'active' => 'data master', 'user' => $user, 'idKepala' => $arrIdKepala]);
    }

    public function tambah()
    {
        return view('user.tambah', ['title' => 'Tambah User', 'active' => 'data master']);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming file. 
        $request->validate([
            'namaJabatan' => 'required|unique:users,namaJabatan',
            'nama' => 'required',
            'email' => 'required|email:rfc,dns',
            'username' => 'required|unique:users,username',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        // Store file information in the database
        $user = new User();
        $user->namaJabatan = $request->input('namaJabatan');
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Redirect back to the index page with a success message
        return redirect('/user/index')->with('success', 'Berhasil Menambahkan Tujuan Disposisi');
    }

    public function edit(User $user)
    {
        // mengambil id kepala dalam bentuk array
        $idKepala = UserKepala::select('idUser')->get();
        $arrIdKepala = [];
        foreach ($idKepala as $ik) {
            array_push($arrIdKepala, $ik->idUser);
        }

        $atasan = User::where('id', '<>', 1)->where('id', '<>', 2)->with(['strukturOrganisasi'])->get();
        $units = Unit::all();

        $user = User::with('units')->findOrFail($user->id);

        return view('user.edit', ['title' => 'Edit User', 'active' => 'data master', 'user' => $user, 'idKepala' => $arrIdKepala, 'atasan' => $atasan, 'units' => $units]);
    }

    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'namaJabatan' => 'required',
            'nama' => 'required',
            'email' => 'required|email:rfc,dns',
            'username' => 'required',
            // 'isKepala' => 'required'
        ]);



        $user = User::find($request->input('id'));

        if ($user->namaJabatan != $request->input('namaJabatan')) {
            $request->validate([
                'namaJabatan' => 'unique:users,namaJabatan',
            ]);
        }

        if ($user->username != $request->input('username')) {
            $request->validate([
                'username' => 'unique:users,username',
            ]);
        }

        // Store file information in the database
        $user->namaJabatan = $request->input('namaJabatan');
        $user->nama = $request->input('nama');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->save();

        // // ADD OR DELETE USER_KEPALA
        // // mengambil id kepala dalam bentuk array
        // $idKepala = UserKepala::select('idUser')->get();
        // $arrIdKepala = [];
        // foreach ($idKepala as $ik) {
        //     array_push($arrIdKepala, $ik->idUser);
        // }

        // if (in_array($request->input('id'), $arrIdKepala)) { // jika user sudah terdaftar menjadi kepala
        //     if($request->input('isKepala') == 'no') { // dan isian isKepala adalah no, maka hapus di user_kepala
        //         $userKepala = UserKepala::where('idUser', $request->input('id'))->get()[0];
        //         $userKepala->delete();
        //     }
        // } else { // jika user belum terdaftar menjadi kepala
        //     if($request->input('isKepala') == 'yes') { // dan isian isKepala adalah yes, maka tambahkan user ke user_kepala
        //         $userKepala = new UserKepala();
        //         $userKepala->idUser = $request->input('id');
        //         $userKepala->save();
        //     }
        // }

        // Redirect back to the index page with a success message
        return redirect('/user/index')->with('success', 'Berhasil Mengedit Tujuan Disposisi');
    }

    public function akunNs()
    {
        return view('user.akun-ns', ['title' => 'Akun User', 'active' => 'akun']);
    }

    public function updateInfoProfil(Request $request): RedirectResponse
    {
        // Validate the incoming file. 

        $request->validate([
            'username' => 'required',
            'nama' => 'required',
            'email' => 'required|email:rfc,dns'
        ]);

        $user = User::find($request->input('id'));

        if ($user->username != $request->input('username')) {
            $request->validate([
                'username' => 'unique:users,username',
            ]);
        }

        // Store file information in the database
        $user->username = $request->input('username');
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->save();

        // Redirect back to the index page with a success message
        return redirect('/user/akun-ns')->with('success', 'Berhasil Mengedit Informasi Profil');
    }

    public function updatePasswordNs(Request $request): RedirectResponse
    {
        // Validate the incoming file. 

        $request->validate([
            'passwordSaatIni' => 'required|current_password',
            'passwordBaru' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()]
        ]);

        $user = User::find($request->input('id'));

        // Store file information in the database
        $user->password = Hash::make($request->input('passwordBaru'));
        $user->save();

        // Redirect back to the index page with a success message
        return redirect('/user/akun-ns')->with('success', 'Berhasil Mengubah Password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        // Validate the incoming file. 

        $request->validate([
            'passwordBaru' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()]
        ]);

        $user = User::find($request->input('id'));

        // Store file information in the database
        $user->password = Hash::make($request->input('passwordBaru'));
        $user->save();

        // Redirect back to the index page with a success message
        return redirect('/user/index')->with('success', 'Berhasil Mengubah Password');
    }

    public function jadikanKhusus(Request $request)
    {

        $request->validate([
            'id' => 'required',
        ]);

        $user = User::find($request->input('id'));
        $user->isKhusus = true;
        $user->save();

        return redirect()->back()->with('success', "Berhasil Menjadikan Akun Khusus");
    }

    public function batalkanKhusus(Request $request)
    {

        $request->validate([
            'id' => 'required',
        ]);

        $user = User::find($request->input('id'));
        $user->isKhusus = false;
        $user->save();

        return redirect()->back()->with('success', "Berhasil Membatalkan Akun Khusus");
    }

    public function nonaktifkan(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $user = User::find($request->input('id'));
        $user->isAktif = false;
        $user->save();

        return redirect()->back()->with('success', "Berhasil Menonaktifkan User");
    }

    public function aktifkan(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $user = User::find($request->input('id'));
        $user->isAktif = true;
        $user->save();

        return redirect()->back()->with('success', "Berhasil Mengaktifkan User");
    }

    public function kelolaKhusus(User $user)
    {
        $daftarPengirim = PenerimaKhusus::where('idUser', $user->id)->get();
        $daftarBukanPengirim = User::whereNotIn('id', $daftarPengirim->select('bisaMenerimaDari'))->where('isKhusus', false)->get();

        $daftarPenerima = PengirimKhusus::where('idUser', $user->id)->get();
        $daftarBukanPenerima = User::whereNotIn('id', $daftarPenerima->select('bisaMengirimKe'))->where('isKhusus', false)->get();

        return view('user.kelola-khusus', [
            'title' => 'Kelola Akun Khusus',
            'active' => 'data master',
            'user' => $user,
            'daftarPengirim' => $daftarPengirim,
            'daftarBukanPengirim' => $daftarBukanPengirim,
            'daftarPenerima' => $daftarPenerima,
            'daftarBukanPenerima' => $daftarBukanPenerima
        ]);
    }

    public function tambahPengirim(Request $request)
    {
        $request->validate([
            'idUser' => 'required',
            'idPengirim' => 'required'
        ]);

        $penerimaKhusus = new PenerimaKhusus();
        $penerimaKhusus->idUser = $request->input('idUser');
        $penerimaKhusus->bisaMenerimaDari = $request->input('idPengirim');
        $penerimaKhusus->save();

        return redirect('/user/kelola-khusus/' . $request->input('idUser'))->with('success', 'Berhasil Menambah Pengirim');
    }

    public function hapusPengirim($id)
    {
        $penerimaKhusus = PenerimaKhusus::findOrFail($id);
        $idUser = $penerimaKhusus->idUser;
        $penerimaKhusus->delete();

        return redirect('/user/kelola-khusus/' . $idUser)->with('success', 'Berhasil Menghapus Pengirim');
    }

    public function tambahPenerima(Request $request)
    {
        $request->validate([
            'idUser' => 'required',
            'idPenerima' => 'required'
        ]);

        $pengirimKhusus = new PengirimKhusus();
        $pengirimKhusus->idUser = $request->input('idUser');
        $pengirimKhusus->bisaMengirimKe = $request->input('idPenerima');
        $pengirimKhusus->save();

        return redirect('/user/kelola-khusus/' . $request->input('idUser'))->with('success', 'Berhasil Menambah Penerima');
    }

    public function hapusPenerima($id)
    {
        $pengirimKhusus = PengirimKhusus::findOrFail($id);
        $idUser = $pengirimKhusus->idUser;
        $pengirimKhusus->delete();

        return redirect('/user/kelola-khusus/' . $idUser)->with('success', 'Berhasil Menghapus Penerima');
    }

    public function updateLingkupUnit(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'units' => 'required|array',
        ]);

        $user = User::findOrFail($request->input('id'));
        $user->units()->sync($request->input('units'));

        return redirect()->back()->with('success', "Berhasil Mengupdate Lingkup Unit");
    }
}
