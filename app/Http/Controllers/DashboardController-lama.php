<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Models\TujuanDisposisi;

class DashboardController extends Controller
{
    public function create() {
        // dd(now()->format('m'));
        $belumDiteruskan = 0;
        $sudahDiteruskan = 0;
        $suratMasukHariIni = 0;
        $suratMasukBulanIni = 0;
        $suratKeluarHariIni = 0;
        $suratKeluarBulanIni = 0;

        if (auth()->user()->id === 1) {
            $suratMasukHariIni = SuratMasuk::whereDate('tanggalSurat', '=', now())->count();
            $suratMasukBulanIni = SuratMasuk::whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'))->count();
            $suratKeluarHariIni = SuratKeluar::whereDate('tanggalSurat', '=', now())->count();
            $suratKeluarBulanIni = SuratKeluar::whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'))->count();
        }

        if (auth()->user()->level === 'direktur') {
            $belumDiteruskan = SuratMasuk::where('status', '=', 'Diteruskan ke Direktur')->count();
            $sudahDiteruskan = SuratMasuk::where('status', '<>', 'Diteruskan ke Direktur')->where('status', '<>', 'Belum Diteruskan')->count();
        }

        if (auth()->user()->level === 'kepala') {
            $distribusiSuratBelumDiteruskan = User::where('id', '=', auth()->user()->id)->get()[0]->menerimaDS;
            foreach ($distribusiSuratBelumDiteruskan as $dsbd) {
                if ($dsbd->suratMasuk->status === 'Diteruskan ke Kepala Bagian') {
                    $belumDiteruskan++;
                }
            }
            $sudahDiteruskan = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDS->count();
        }

        if (auth()->user()->level === 'penjab') {
            $distribusiSuratBelumDiteruskan = User::where('id', '=', auth()->user()->id)->get()[0]->menerimaDS;
            foreach ($distribusiSuratBelumDiteruskan as $dsbd) {
                if ($dsbd->suratMasuk->status === 'Diteruskan ke Penanggung Jawab') {
                    $belumDiteruskan++;
                }
            }
            $sudahDiteruskan = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDS->count();
        }

        return view('dashboard', [
            'title' => 'App Surat | Dashboard', 
            'active' => 'dashboard', 
            'belumDiteruskan' => $belumDiteruskan, 
            'sudahDiteruskan' => $sudahDiteruskan,
            'suratMasukHariIni' => $suratMasukHariIni,
            'suratMasukBulanIni' => $suratMasukBulanIni,
            'suratKeluarHariIni' => $suratKeluarHariIni,
            'suratKeluarBulanIni' => $suratKeluarBulanIni
        ]);
    } 
}
