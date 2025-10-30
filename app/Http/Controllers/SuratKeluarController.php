<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Direksi;
use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Jobs\ProcessRekapSuratKeluar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Helpers\QueryHelper;

class SuratKeluarController extends Controller
{
    public function create(?string $ket = null)
    {
        $suratKeluar = SuratKeluar::orderBy('tahun', 'desc')->orderBy('index', 'desc');
        $jenisSurat = JenisSurat::all();
        $direksi = Direksi::all();
        $judul = "Surat Keluar";

        if ($ket == 'hari-ini') {
            $suratKeluar = $suratKeluar->whereDate('tanggalSurat', '=', now());
            $judul = "Surat Keluar Hari Ini";
        }

        if ($ket == 'bulan-ini') {
            $suratKeluar = $suratKeluar->whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'));
            $judul = "Surat Keluar Bulan Ini";
        }

        // $filters = [
        //     'index'        => 'index',
        //     'tanggalSurat' => ['date>=', 'tanggalAwal'],
        //     'tanggalSurat' => ['date<=', 'tanggalAkhir'],
        //     'idJenisSurat' => 'jenisSurat',
        //     'idDireksi'    => 'direksi',
        //     'tujuan'       => ['like', 'tujuan'],
        //     'perihal'      => ['like', 'perihal'],
        //     'keterangan'   => ['like', 'keterangan'],
        //     'tahun'        => 'tahun',
        // ];

        if (request('index')) {
            $suratKeluar->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $suratKeluar = $suratKeluar->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }
        if (request('tanggalAkhir')) {
            $suratKeluar = $suratKeluar->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }        
        if (request('jenisSurat')) {
            $suratKeluar->where('idJenisSurat', request('jenisSurat'));
        }
        if (request('direksi')) {
            $suratKeluar->where('idDireksi', request('direksi'));
        }
        if (request('tujuan')) {
            $suratKeluar->where('tujuan', 'like', '%' . request('tujuan') . '%');
        }
        if (request('perihal')) {
            $suratKeluar->where('perihal', 'like', '%' . request('perihal') . '%');
        }
        if (request('keterangan')) {
            $suratKeluar->where('keterangan', 'like', '%' . request('keterangan') . '%');
        }
        if (request('tahun')) {
            $suratKeluar->where('tahun', request('tahun'));
        }

        // $suratKeluar = QueryHelper::applyFilters($suratKeluar, $filters);

        session([
            'search_tahun' => request('tahun')
        ]);

        return view('surat-keluar.index', ['title' => $judul, 'active' => 'surat keluar', 'suratKeluar' => $suratKeluar->with(['jenisSurat', 'direksi'])->paginate(15), 'jenisSurat' => $jenisSurat, 'direksi' => $direksi, 'ket' => $ket, 'judul' => $judul]);
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        $jenisSurat = JenisSurat::all();
        $direksi = Direksi::all();

        return view('surat-keluar.edit', ['title' => 'Edit Surat Keluar', 'active' => 'surat keluar', 'suratKeluar' => $suratKeluar, 'jenisSurat' => $jenisSurat, 'direksi' => $direksi]);
    }

    public function tambah()
    {
        $jenisSurat = JenisSurat::all();
        $direksi = Direksi::all();

        return view('surat-keluar.tambah', ['title' => 'Tambah Surat Keluar', 'active' => 'surat keluar', 'jenisSurat' => $jenisSurat, 'direksi' => $direksi]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->id == 1) {
            $redirect = '/surat-keluar/index'
                . '?tahun=' . urlencode(session('search_tahun', ''));
        } else {
            $redirect = '/';
        }
        session()->forget('search_tahun');
        // Validate the incoming file. Refuses anything bigger than 5120 kilobyes (=5MB)
        $request->validate([
            'jenisSurat' => 'required',
            'tanggalSurat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'direksi' => 'required',
            'fileSurat' => 'required|mimes:pdf,jpg,png|max:12288'
        ]);

        $tahun = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');
        // Get the maximum id for the given year
        $maxIndex = SuratKeluar::where('tahun', $tahun)->max('index');
        // Determine the new id for the given year
        $newIndex = $maxIndex ? $maxIndex + 1 : 1;

        // Store the file in storage\app\public folder
        $file = $request->file('fileSurat');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('uploads/surat-keluar/' . $tahun . '/' . $bulan, 'public');


        // Store file information in the database
        $suratKeluar = new SuratKeluar();
        $suratKeluar->index = $newIndex;
        $suratKeluar->tahun = $tahun;
        $suratKeluar->idJenisSurat = $request->input('jenisSurat');
        $suratKeluar->idDireksi = $request->input('direksi');
        $suratKeluar->tanggalSurat = $request->input('tanggalSurat');
        $suratKeluar->tujuan = $request->input('tujuan');
        $suratKeluar->perihal = $request->input('perihal');
        $suratKeluar->keterangan = $request->input('keterangan');
        $suratKeluar->fileName = $fileName;
        $suratKeluar->filePath = $filePath;
        $suratKeluar->save();

        // Redirect back to the index page with a success message
        return redirect($redirect)
            ->with('success', 'Berhasil Menambahkan Surat Keluar');
    }

    public function save(Request $request): RedirectResponse
    {
        if (auth()->user()->id == 1) {
            $redirect = '/surat-keluar/index'
                . '?tahun=' . urlencode(session('search_tahun', ''));
        } else {
            $redirect = '/';
        }
        session()->forget('search_tahun');
        // Validate the incoming file. Refuses anything bigger than 5 Mb
        $request->validate([
            'jenisSurat' => 'required',
            'tanggalSurat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'direksi' => 'required',
            'fileSurat' => 'mimes:pdf,jpg,png|max:12288'
        ]);

        $tahunInput = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');

        if ($request->file('fileSurat')) {
            // Store the file in storage\app\public folder
            $file = $request->file('fileSurat');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('uploads/surat-keluar/' . $tahunInput . '/' . $bulan, 'public');
        }


        // Store file information in the database
        $suratKeluar = SuratKeluar::find($request->input('id'));

        $suratKeluar->idJenisSurat = $request->input('jenisSurat');
        $suratKeluar->idDireksi = $request->input('direksi');
        $suratKeluar->tanggalSurat = $request->input('tanggalSurat');
        $suratKeluar->tujuan = $request->input('tujuan');
        $suratKeluar->perihal = $request->input('perihal');
        $suratKeluar->keterangan = $request->input('keterangan');
        if ($request->file('fileSurat')) {
            $suratKeluar->fileName = $fileName;
            $suratKeluar->filePath = $filePath;
        }

        if ($tahunInput != $request->input('tahun')) {
            // Get the maximum id for the given year
            $maxIndex = SuratKeluar::where('tahun', $tahunInput)->max('index');
            // Determine the new id for the given year
            $newIndex = $maxIndex ? $maxIndex + 1 : 1;

            $suratKeluar->tahun = $tahunInput;
            $suratKeluar->index = $newIndex;
        }
        $suratKeluar->save();

        // Redirect back to the index page with a success message
        return redirect($redirect)
            ->with('success', 'Berhasil Mengedit Surat Keluar');
    }

    public function laporanPerJenisSurat()
    {
        $suratKeluar = SuratKeluar::orderBy('idJenisSurat', 'asc');
        $suratKeluar->select('idJenisSurat', SuratKeluar::raw('COUNT(idJenisSurat) as total_surat'))->groupBy('idJenisSurat');

        if (request('tanggalAwal')) {
            $suratKeluar = $suratKeluar->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $suratKeluar = $suratKeluar->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        return view('surat-keluar.laporan-per-jenis-surat', ['title' => 'Surat Keluar Per Jenis Surat', 'active' => 'laporan', 'suratKeluar' => $suratKeluar->get()]);
    }

    public function laporanPerDireksi()
    {
        $suratKeluar = SuratKeluar::orderBy('idDireksi', 'asc');
        $suratKeluar->select('idDireksi', SuratKeluar::raw('COUNT(idDireksi) as total_surat'))->groupBy('idDireksi');

        if (request('tanggalAwal')) {
            $suratKeluar = $suratKeluar->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $suratKeluar = $suratKeluar->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        return view('surat-keluar.laporan-per-direksi', ['title' => 'Surat Keluar Per Direksi', 'active' => 'laporan', 'suratKeluar' => $suratKeluar->get()]);
    }

    public function exportLaporan(Request $request)
    {

        $jsonStrings = $request->input('koleksi');

        $koleksi = collect($jsonStrings)->map(function ($item) {
            return json_decode($item, true);
        });

        // Mengambil semua jenis surat dari database
        $jenisSurat = JenisSurat::all()->keyBy('id');

        $jumlahKeseluruhan = $koleksi->sum('total_surat');

        $koleksi = $koleksi->map(function ($item) use ($jenisSurat) {
            // Mendapatkan nama jenis surat
            $namaJenisSurat = $jenisSurat[$item['idJenisSurat']]->kodeJenisSurat . '-' . $jenisSurat[$item['idJenisSurat']]->keterangan ?? 'Unknown';

            // Membuat array dengan urutan field yang diinginkan
            $result = [
                'Jenis Surat' => $namaJenisSurat,
                'Total Surat' => $item['total_surat'],
            ];

            return $result;
        });

        // Menambahkan row baru dengan jumlah keseluruhan
        $koleksi->push([
            'Jenis Surat' => 'Jumlah Keseluruhan',
            'Total Surat' => $jumlahKeseluruhan,
        ]);


        return (new FastExcel($koleksi))->download('Rekap Surat Keluar Per Jenis Surat.xlsx');
    }

    public function rekapSuratKeluar(Request $request)
    {
        // $tanggal = $request->input('bulanRekap');
        // $tahun = Carbon::createFromFormat('Y-m', $tanggal)->format('Y');
        // $bulan = Carbon::createFromFormat('Y-m', $tanggal)->format('m');
        // $suratKeluar = SuratKeluar::whereMonth('tanggalSurat', '=', $bulan)->whereYear('tanggalSurat', '=', $tahun)->get();

        // $zip = new ZipArchive();
        // $zipFilePath = storage_path('app/' . 'rekap_suratkeluar_' . $tahun . '_' . $bulan . '.zip') ;

        // if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        //     foreach ($suratKeluar as $sk) {
        //         $fileToAdd = storage_path('app/public/' . $sk->filePath);
        //         $zip->addFile($fileToAdd, 'suratkeluar_' . $sk->tahun . '_' . $sk->index . '.' . pathinfo($fileToAdd, PATHINFO_EXTENSION));
        //     }
        //     $zip->close();
        //     return response()->download($zipFilePath)->deleteFileAfterSend(true);
        // } else {
        //     dd('gagal membuka file zip');
        // }

        $awal = $request->input('awal');
        $akhir = $request->input('akhir');

        // $tanggal = $request->input('bulanRekap');
        // $tahun = Carbon::createFromFormat('Y-m', $tanggal)->format('Y');
        // $bulan = Carbon::createFromFormat('Y-m', $tanggal)->format('m');

        // $job = new jenisSuratJob();
        $job = new ProcessRekapSuratKeluar($awal, $akhir);
        dispatch($job);

        return redirect('/surat-keluar/index')
            ->with('success', 'Anda akan menerima email ketika unduhan sudah siap');
    }

    public function downloadZip(String $fileName)
    {
        // dd('tes');
        set_time_limit(0);

        $zipFilePath = storage_path('app/' . $fileName . '.zip');

        if (file_exists($zipFilePath)) {
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            abort(404, 'File tidak ditemukan');
        }
    }

    public function testDownload()
    {
        // dd('tes');
        $zipFilePath = storage_path('app/a.zip');

        if (file_exists($zipFilePath)) {
            return response()->download($zipFilePath);
        } else {
            abort(404, 'File tidak ditemukan');
        }
    }
}
