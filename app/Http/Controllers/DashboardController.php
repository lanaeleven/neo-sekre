<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\Spo;
use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Models\TujuanDisposisi;
use App\Models\Undangan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function create()
    {
        $belumDiteruskan = 0;
        $sudahDiteruskan = 0;
        $arsip = 0;
        $suratMasukHariIni = 0;
        $suratMasukBulanIni = 0;
        $suratKeluarHariIni = 0;
        $suratKeluarBulanIni = 0;
        $dikirim = 0;
        $undangan = 0;
        $pengumuman = 0;
        $edaran = 0;
        $spoBulanIni = 0;
        $bulanSekarang = Carbon::now()->translatedFormat('F');

        $waktuSekarang = Carbon::today()->setTime(00, 00);
        // dd($waktuSekarang->year);

        if (auth()->user()->id == 1 || auth()->user()->id == 2) {
            $suratMasukHariIni = SuratMasuk::whereDate('tanggalSurat', '=', now())->count();
            $suratMasukBulanIni = SuratMasuk::whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'))->count();
            $suratKeluarHariIni = SuratKeluar::whereDate('tanggalSurat', '=', now())->count();
            $suratKeluarBulanIni = SuratKeluar::whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'))->count();
            $spoBulanIni = Spo::whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'))->count();
            $undangan = Undangan::where('waktuKegiatan', '>', $waktuSekarang)->count();
            $pengumuman = Informasi::whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'))->where('idJenisInformasi', 1)->count();
            $edaran = Informasi::whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'))->where('idJenisInformasi', 2)->count();
        }

        if (auth()->user()->id != 1 && auth()->user()->id != 2) {
            $belumDiteruskan = SuratMasuk::where('idPosisiDisposisi', '=', auth()->user()->id)->count();
            // $sudahDiteruskan = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDS->unique('idSuratMasuk')->count();
            $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDS->unique('idSuratMasuk');
            $suratDiteruskan = collect([]);
            foreach ($distribusiSurat as $sd) {
                $suratDiteruskan->push($sd->suratMasuk);
            }
            $sudahDiteruskan = $suratDiteruskan->where('status', '<>', 'Diarsipkan')->count();
            $arsip = $suratDiteruskan->where('status', 'Diarsipkan')->count();
            $dikirim = SuratMasuk::where('idPengirim', '=', auth()->user()->id)->count();
            $userId = auth()->user()->id;
            $undangan = Undangan::whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })->where('waktuKegiatan', '>', $waktuSekarang)->count();
            $pengumuman = Informasi::whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
                ->where('idJenisInformasi', 1)
                ->count();
            $edaran = Informasi::whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
                ->where('idJenisInformasi', 2)
                ->count();
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'belumDiteruskan' => $belumDiteruskan,
            'sudahDiteruskan' => $sudahDiteruskan,
            'arsip' => $arsip,
            'suratMasukHariIni' => $suratMasukHariIni,
            'suratMasukBulanIni' => $suratMasukBulanIni,
            'suratKeluarHariIni' => $suratKeluarHariIni,
            'suratKeluarBulanIni' => $suratKeluarBulanIni,
            'dikirim' => $dikirim,
            'undangan' => $undangan,
            'pengumuman' => $pengumuman,
            'edaran' => $edaran,
            'bulanSekarang' => $bulanSekarang,
            'spoBulanIni' => $spoBulanIni
        ]);
    }

    public function dashboardLaporan() {}
}
