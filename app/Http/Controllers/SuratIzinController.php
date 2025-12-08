<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\User;
use setasign\Fpdi\Fpdi;
use App\Models\SuratMasuk;
use App\Models\UserKepala;
use Illuminate\Http\Request;
use App\Models\PenerimaKhusus;
use App\Models\PengirimKhusus;
use Illuminate\Support\Carbon;
use App\Models\TujuanDisposisi;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\EmailNotifDisposisi;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessNotifDisposisi;
use App\Jobs\ProcessRekapSuratMasuk;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessNotifSuratMasukBaru;
use App\Models\DistribusiSuratIzin;
use App\Models\SuratIzin;
use Illuminate\Pagination\LengthAwarePaginator;
use setasign\Fpdi\PdfParser\PdfParserException;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class SuratIzinController extends Controller
{
    public function create(?string $keterangan = null)
    {

        $suratIzin = SuratIzin::orderBy('tahun', 'desc')->orderBy('index', 'desc');
        $judul = "Surat Izin";
        // $pengirim = User::whereNotIn("id", [1,2,3])->get();

        if ($keterangan == 'hari-ini') {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '=', now());
            $judul = "Surat Izin Hari Ini";
        }

        if ($keterangan == 'bulan-ini') {
            $suratIzin = $suratIzin->whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'));
            $judul = "Surat Izin Bulan Ini";
        }

        if (request('index')) {
            $suratIzin->where('index', '=', request('index'));
        }

        if (request('tanggalAwal')) {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        if (request('status')) {
            $suratIzin->where('status', 'like', '%' . request('status') . '%');
        }

        if (request('pengirim')) {
            $suratIzin->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }

        if (request('nomorSurat')) {
            $suratIzin->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }

        if (request('perihal')) {
            $suratIzin->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        if (request('tahun')) {
            $suratIzin->where('tahun', 'like', '%' . request('tahun') . '%');
        }

        // penyimpanan session
        session([
            'search_tanggalAwal' => request('tanggalAwal'),
            'search_tanggalAkhir' => request('tanggalAkhir'),
            'search_index' => request('index'),
            'search_pengirim' => request('pengirim'),
            'search_nomorSurat' => request('nomorSurat'),
            'search_perihal' => request('perihal'),
            'search_status' => request('status')
        ]);

        return view('surat-izin.index', ['title' => $judul, 'active' => 'surat izin', 'suratIzin' => $suratIzin->with(['userPengirim'])->paginate(25), 'keterangan' => $keterangan, 'judul' => $judul, 'isForm' => false]);
    }

    public function tambah()
    {
        $sifatSurat = collect([
            ['id' => 'Biasa', 'nama' => 'Biasa'],
            ['id' => 'Rahasia', 'nama' => 'Rahasia'],
            ['id' => 'Segera', 'nama' => 'Segera'],
        ])->map(function ($item) {
            return (object) $item;
        });
        $lampiran = collect([
            ['id' => 'Ada', 'nama' => 'Ada'],
            ['id' => 'Tidak Ada', 'nama' => 'Tidak Ada'],
        ])->map(function ($item) {
            return (object) $item;
        });
        $pengirim = User::whereNotIn('id', [1, 2, 3])->where('isAktif', true)->get();
        $opsiPengirim = $pengirim->map(function ($p) {
            return (object)[
                'id' => $p->id,
                'nama' => $p->namaJabatan
            ];
        });
        $opsiPengirim->push((object)[
            'id' => 'lainnya',
            'nama' => 'Lainnya'
        ]);

        return view('surat-izin.tambah', ['title' => 'Tambah Surat Izin', 'active' => 'surat izin', 'pengirim' => $opsiPengirim, 'sifatSurat' => $sifatSurat, 'lampiran' => $lampiran, 'isForm' => true]);
    }

    public function tambahNs()
    {
        $sifatSurat = collect([
            ['id' => 'Biasa', 'nama' => 'Biasa'],
            ['id' => 'Rahasia', 'nama' => 'Rahasia'],
            ['id' => 'Segera', 'nama' => 'Segera'],
        ])->map(function ($item) {
            return (object) $item;
        });
        $lampiran = collect([
            ['id' => 'Ada', 'nama' => 'Ada'],
            ['id' => 'Tidak Ada', 'nama' => 'Tidak Ada'],
        ])->map(function ($item) {
            return (object) $item;
        });
        $pengirim = User::whereNotIn('id', [1, 2, 3])->where('isAktif', true)->get();
        $opsiPengirim = $pengirim->map(function ($p) {
            return (object)[
                'id' => $p->id,
                'nama' => $p->namaJabatan
            ];
        });
        $opsiPengirim->push((object)[
            'id' => 'lainnya',
            'nama' => 'Lainnya'
        ]);

        return view('surat-izin.tambah-ns', ['title' => 'Tambah Surat Izin', 'active' => 'surat izin', 'pengirim' => $opsiPengirim, 'sifatSurat' => $sifatSurat, 'lampiran' => $lampiran, 'isForm' => true]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'idPosisiDisposisi' => 'required',
            'tanggalAgenda' => 'required',
            'sifatSurat' => 'required',
            'nomorSurat' => 'required',
            'tanggalSurat' => 'required',
            'lampiran' => 'required',
            'pengirim' => 'required',
            'idPengirim' => 'required',
            'perihal' => 'required',
            'fileSurat' => 'required|mimes:pdf,jpg,png|max:10240'
        ]);

        $tahun = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');
        // Get the maximum id for the given year
        $maxIndex = SuratIzin::where('tahun', $tahun)->max('index');
        // Determine the new id for the given year
        $newIndex = $maxIndex ? $maxIndex + 1 : 1;

        // Store the file in storage\app\public folder
        // Dapatkan tipe MIME file yang diunggah
        $mimeType = $request->file('fileSurat')->getMimeType();
        // Cek jika tipe file adalah image (JPEG, PNG)
        if (strpos($mimeType, 'image') !== false) {
            // Dapatkan konten gambar
            $imageContent = file_get_contents($request->file('fileSurat')->getRealPath());

            // Data yang akan dikirim ke view
            $data = [
                'imageContent' => $imageContent,
            ];

            // Load view dan generate PDF
            $pdf = PDF::loadView('pdf.image-to-pdf', $data);

            // Path untuk menyimpan file PDF
            $filePath = 'uploads/surat-izin/' . $tahun . '/' . $bulan . '/' . uniqid() . '.pdf';
            $storagePath = 'public/' . $filePath;

            // Simpan file PDF ke storage
            Storage::put($storagePath, $pdf->output());
        } else {
            $filePath = $request->file('fileSurat')->store('uploads/surat-izin/' . $tahun . '/' . $bulan, 'public');
        }
        $fileName = $request->file('fileSurat')->getClientOriginalName();

        $suratIzin = new SuratIzin();
        $suratIzin->index = $newIndex;
        $suratIzin->idPosisiDisposisi = $request->input('idPosisiDisposisi');
        $suratIzin->tanggalAgenda = $request->input('tanggalAgenda');
        $suratIzin->sifatSurat = $request->input('sifatSurat');
        $suratIzin->nomorSurat = $request->input('nomorSurat');
        $suratIzin->tanggalSurat = $request->input('tanggalSurat');
        $suratIzin->tahun = $tahun;
        $suratIzin->lampiran = $request->input('lampiran');
        $suratIzin->idPengirim = $request->input('idPengirim') != "lainnya" ? $request->input('idPengirim') : NULL;
        $suratIzin->pengirim = $request->input('pengirim');
        $suratIzin->perihal = $request->input('perihal');
        $suratIzin->status = $request->input('status');
        $suratIzin->statusArsip = 0;
        $suratIzin->fileName = $fileName;
        $suratIzin->filePath = $filePath;
        $suratIzin->save();


        // if (!($request->input('idPengirim') == 'lainnya')) {
        //     $user = User::find($request->input('idPengirim'));
        //     $job = new ProcessNotifSuratizinBaru($user->email, $user->namaJabatan, $request->input('nomorSurat'));
        //     dispatch($job);
        // }


        return redirect('/surat-izin/index?tahun=' . config('app.tahun'))
            ->with('success', "Berhasil Menambahkan Surat Izin");
    }

    public function storeNs(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggalAgenda' => 'required',
            'sifatSurat' => 'required',
            'nomorSurat' => 'required',
            'tanggalSurat' => 'required',
            'lampiran' => 'required',
            'pengirim' => 'required',
            'idPengirim' => 'required',
            'perihal' => 'required',
            'fileSurat' => 'required|mimes:pdf,jpg,png|max:10240'
        ]);

        $ketua = User::where('role', 'ketua')->first();
        $tahun = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');
        // Get the maximum id for the given year
        $maxIndex = SuratIzin::where('tahun', $tahun)->max('index');
        // Determine the new id for the given year
        $newIndex = $maxIndex ? $maxIndex + 1 : 1;

        // Store the file in storage\app\public folder
        // Dapatkan tipe MIME file yang diunggah
        $mimeType = $request->file('fileSurat')->getMimeType();
        // Cek jika tipe file adalah image (JPEG, PNG)
        if (strpos($mimeType, 'image') !== false) {
            // Dapatkan konten gambar
            $imageContent = file_get_contents($request->file('fileSurat')->getRealPath());

            // Data yang akan dikirim ke view
            $data = [
                'imageContent' => $imageContent,
            ];

            // Load view dan generate PDF
            $pdf = PDF::loadView('pdf.image-to-pdf', $data);

            // Path untuk menyimpan file PDF
            $filePath = 'uploads/surat-izin/' . $tahun . '/' . $bulan . '/' . uniqid() . '.pdf';
            $storagePath = 'public/' . $filePath;

            // Simpan file PDF ke storage
            Storage::put($storagePath, $pdf->output());
        } else {
            $filePath = $request->file('fileSurat')->store('uploads/surat-izin/' . $tahun . '/' . $bulan, 'public');
        }
        $fileName = $request->file('fileSurat')->getClientOriginalName();

        $suratIzin = new SuratIzin();
        $suratIzin->index = $newIndex;
        $suratIzin->idPosisiDisposisi = $ketua->id;
        $suratIzin->tanggalAgenda = $request->input('tanggalAgenda');
        $suratIzin->sifatSurat = $request->input('sifatSurat');
        $suratIzin->nomorSurat = $request->input('nomorSurat');
        $suratIzin->tanggalSurat = $request->input('tanggalSurat');
        $suratIzin->tahun = $tahun;
        $suratIzin->lampiran = $request->input('lampiran');
        $suratIzin->idPengirim = $request->input('idPengirim') != "lainnya" ? $request->input('idPengirim') : NULL;
        $suratIzin->pengirim = $request->input('pengirim');
        $suratIzin->perihal = $request->input('perihal');
        $suratIzin->status = "Diteruskan ke " . $ketua->namaJabatan;
        $suratIzin->statusArsip = 0;
        $suratIzin->fileName = $fileName;
        $suratIzin->filePath = $filePath;
        $suratIzin->save();


        // if (!($request->input('idPengirim') == 'lainnya')) {
        //     $user = User::find($request->input('idPengirim'));
        //     $job = new ProcessNotifSuratizinBaru($user->email, $user->namaJabatan, $request->input('nomorSurat'));
        //     dispatch($job);
        // }


        return redirect('/surat-izin/ns/dikirim')
            ->with('success', "Berhasil Menambahkan Surat Izin");
    }

    public function edit(SuratIzin $suratIzin)
    {
        $sifatSurat = collect([
            ['id' => 'Biasa', 'nama' => 'Biasa'],
            ['id' => 'Rahasia', 'nama' => 'Rahasia'],
            ['id' => 'Segera', 'nama' => 'Segera'],
        ])->map(function ($item) {
            return (object) $item;
        });

        $lampiran = collect([
            ['id' => 'Ada', 'nama' => 'Ada'],
            ['id' => 'Tidak Ada', 'nama' => 'Tidak Ada'],
        ])->map(function ($item) {
            return (object) $item;
        });

        $pengirim = User::whereNotIn('id', [1, 2, 3])->get();
        $opsiPengirim = $pengirim->map(function ($p) {
            return (object)[
                'id' => $p->id,
                'nama' => $p->namaJabatan
            ];
        });
        $opsiPengirim->push((object)[
            'id' => 'lainnya',
            'nama' => 'Lainnya'
        ]);

        return view('surat-izin.edit', ['title' => 'Edit Surat Izin', 'active' => 'surat izin', 'suratIzin' => $suratIzin,  'pengirim' => $opsiPengirim, 'isForm' => true, 'sifatSurat' => $sifatSurat, 'lampiran' => $lampiran]);
    }

    // public function editTerusanSurat(int $idSuratMasuk, DistribusiSuratIzin $terusanSurat)
    // {
    //     return view('surat-masuk.edit-terusan-surat', ['title' => 'Edit Terusan Surat', 'active' => 'surat masuk', 'terusanSurat' => $terusanSurat, 'idSuratMasuk' => $idSuratMasuk]);
    // }

    public function save(Request $request): RedirectResponse
    {
        // Validate the incoming file. Refuses anything bigger than 5120 kilobyes (=5MB)
        $request->validate([
            'tanggalAgenda' => 'required',
            'sifatSurat' => 'required',
            'nomorSurat' => 'required',
            'tanggalSurat' => 'required',
            'lampiran' => 'required',
            'pengirim' => 'required',
            'idPengirim' => 'required',
            'perihal' => 'required',
            'fileSurat' => 'mimes:pdf,jpg,png|max:7168'
        ]);


        $tahunInput = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');

        if ($request->file('fileSurat')) {
            // Store the file in storage\app\public folder
            // Dapatkan tipe MIME file yang diunggah
            $mimeType = $request->file('fileSurat')->getMimeType();
            // Cek jika tipe file adalah image (JPEG, PNG)
            if (strpos($mimeType, 'image') !== false) {
                // Dapatkan konten gambar
                $imageContent = file_get_contents($request->file('fileSurat')->getRealPath());
                // Data yang akan dikirim ke view
                $data = [
                    'imageContent' => $imageContent,
                ];

                // Load view dan generate PDF
                $pdf = PDF::loadView('pdf.image-to-pdf', $data);
                // Path untuk menyimpan file PDF
                $filePath = 'uploads/surat-izin/' . $tahunInput . '/' . $bulan . '/' . uniqid() . '.pdf';
                $storagePath = 'public/' . $filePath;
                // Simpan file PDF ke storage
                Storage::put($storagePath, $pdf->output());
            } else {
                $filePath = $request->file('fileSurat')->store('uploads/surat-izin/' . $tahunInput . '/' . $bulan, 'public');
            }
            // Store the file in storage\app\public folder
            $fileName = $request->file('fileSurat')->getClientOriginalName();
        }

        // Store file information in the database
        $suratIzin = SuratIzin::find($request->input('id'));
        $suratIzin->tanggalAgenda = $request->input('tanggalAgenda');
        $suratIzin->sifatSurat = $request->input('sifatSurat');
        $suratIzin->nomorSurat = $request->input('nomorSurat');
        $suratIzin->tanggalSurat = $request->input('tanggalSurat');
        $suratIzin->lampiran = $request->input('lampiran');
        $suratIzin->idPengirim = $request->input('idPengirim') != "lainnya" ? $request->input('idPengirim') : NULL;
        $suratIzin->pengirim = $request->input('pengirim');
        $suratIzin->perihal = $request->input('perihal');
        $suratIzin->status = $request->input('status');
        if ($request->file('fileSurat')) {
            $suratIzin->fileName = $fileName;
            $suratIzin->filePath = $filePath;
        }

        if ($tahunInput != $request->input('tahun')) {
            // Get the maximum id for the given year
            $maxIndex = SuratIzin::where('tahun', $tahunInput)->max('index');
            // Determine the new id for the given year
            $newIndex = $maxIndex ? $maxIndex + 1 : 1;

            $suratIzin->tahun = $tahunInput;
            $suratIzin->index = $newIndex;
        }
        $suratIzin->save();

        // Redirect back to the index page with a success message
        return redirect('/surat-izin/index?tahun=' . config('app.tahun'))
            ->with('success', "Berhasil Mengedit Surat Izin");
    }

    public function disposisi(SuratIzin $suratIzin)
    {

        $idUser = auth()->user()->id;
        $role = auth()->user()->role;

        $terusan = null;


        $terusan = User::where('role', '<>', 'dev')->where('isAktif', true)->get();



        // PENGECEKAN UNTUK USER NON-SEKRE PADA SURAT YANG SUDAH DITERUSKAN
        // PENGECEKAN APAKAH SURAT IZIN SUDAH PERNAH DITERUSKAN ATAU BELUM, JIKA BELUM MAKA TIDAK MELEWATI GATE DISPOSISI-SURAT
        if (DistribusiSuratIzin::where('idSuratIzin', '=', $suratIzin->id)->exists()) {
            $cekDS = DistribusiSuratIzin::where('idSuratIzin', '=', $suratIzin->id)->orderBy('id', 'desc')->get()[0];
            if ((! Gate::allows('disposisi-surat-izin', $cekDS) || $cekDS->status == "Diarsipkan") && $role != 'sekre') {
                abort(403);
            }
        }

        // PENGECEKAN UNTUK USER NON-SEKRE PADA SURAT YANG BELUM DITERUSKAN
        // PENGECEKAN APAKAH SURAT IZIN YANG BELUM DITERUSKAN DIAKSES OLEH ADMIN ATAU BUKAN, JIKA BUKAN ADMIN MAKA TIDAK DIPERBOLEHKAN
        if ($suratIzin->status == "Belum Diteruskan" && $role != 'sekre') {
            abort(403);
        }



        // JIKA SUDAH MELEWATI SEMUA GATE, KEMUDIAN AMBIL DATA DISTRIBUSI SURAT
        $distribusiSurat = DistribusiSuratIzin::where('idSuratIzin', '=', $suratIzin->id)->with(['pengirimDisposisi', 'tujuanDisposisi'])->get();

        $opsiTerusan = collect($terusan ?? [])->map(function ($t) {
            return (object)[
                'id'   => $t->id ?? null,
                'nama' => $t->namaJabatan ?? null,
            ];
        });


        return view('surat-izin.disposisi', ['title' => 'Disposisi Surat Izin', 'active' => 'surat izin', 'suratIzin' => $suratIzin, 'terusan' => $opsiTerusan, 'distribusiSurat' => $distribusiSurat, 'isForm' => true]);
    }

    public function teruskan(Request $request): RedirectResponse
    {
        // $perihal = session('search_query_perihal', '');

        // pembedaan redirect user sekre dan non-sekre
        if (auth()->user()->id == 1) {
            $redirect = '/surat-izin/index'
                . '?tanggalAwal=' . urlencode(session('search_tanggalAwal', ''))
                . '&tanggalAkhir=' . urlencode(session('search_tanggalAkhir', ''))
                . '&index=' . urlencode(session('search_index', ''))
                . '&pengirim=' . urlencode(session('search_pengirim', ''))
                . '&nomorSurat=' . urlencode(session('search_nomorSurat', ''))
                . '&perihal=' . urlencode(session('search_perihal', ''))
                . '&status=' . urlencode(session('search_status', ''));
        } else {
            $redirect = '/';
        }

        session()->forget('search_tanggalAwal');
        session()->forget('search_tanggalAkhir');
        session()->forget('search_index');
        session()->forget('search_pengirim');
        session()->forget('search_nomorSurat');
        session()->forget('search_perihal');
        session()->forget('search_status');



        // validasi input dari user
        $request->validate([
            'idTujuanDisposisi' => 'required',
            'idSuratIzin' => 'required',
            'instruksi' => 'required',
            'idPengirimDisposisi' => 'required',
            'fileLampiran' => 'mimes:pdf,jpg,png|max:5120'
        ]);

        // START PROCESS file lampiran
        if ($request->file('fileLampiran')) {
            $filesToDelete = [];
            $mimeType = $request->file('fileLampiran')->getMimeType();
            if (strpos($mimeType, 'image') !== false) { // jika input user berupa image, maka convert image to pdf
                $imageContent = file_get_contents($request->file('fileLampiran')->getRealPath());
                $data = [
                    'imageContent' => $imageContent,
                ];
                $pdf = PDF::loadView('pdf.image-to-pdf', $data);
                $uploadImagePdfPath = 'public/uploads/lampiran/' . uniqid() . '.pdf'; // path untuk menyimpan file lampiran yg img-to-pdf
                Storage::put($uploadImagePdfPath, $pdf->output());
                $fileLampiranPath = storage_path('app/' . $uploadImagePdfPath); // path sementara untuk file lampiran
                $filesToDelete[] = $fileLampiranPath;
            } else { // jika input user berupa pdf
                $fileLampiranPath = storage_path('app/public/' . $request->file('fileLampiran')->store('uploads/lampiran', 'public')); // path sementara untuk file lampiran
                $filesToDelete[] = $fileLampiranPath;
            }
            try { // memeriksa apakah versi pdf bermasalah atau tidak
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($fileLampiranPath);
                $isProblematic = false;
            } catch (PdfParserException $e) {
                $isProblematic = true;
            }
            if ($isProblematic) { // jika versi pdf bermasalah, jalankan ghostscript untuk mengganti versi pdf
                $ghostscriptPath = env('GHOSTSCRIPT_PATH');
                $uncompressedfileLampiranPath = storage_path('app/public/uploads/lampiran/' . uniqid() . '.pdf'); // path untuk hasil proses yang dilakukan ghostscript
                $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedfileLampiranPath $fileLampiranPath";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
                }
                $fileLampiranPath = $uncompressedfileLampiranPath; // memakai path hasil ghostscript untuk path file lampiran
                $filesToDelete[] = $fileLampiranPath;
            }

            // akses row surat izin untuk menyimpan file surat izin yang sdh digabung dengan lampiran  
            $suratIzin = SuratIzin::find($request->input('idSuratIzin'));
            $suratIzinPath = storage_path('app/public/' . $suratIzin->filePath); //path surat izin sebelum digabung

            try { // memeriksa apakah versi pdf bermasalah atau tidak
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($suratIzinPath);
                $isSuratIzinProblematic = false;
            } catch (PdfParserException $e) {
                $isSuratIzinProblematic = true;
            }
            if ($isSuratIzinProblematic) { // jika versi pdf bermasalah, jalankan ghostscript untuk mengganti versi pdf
                $oldSuratIzinPath = $suratIzinPath;
                $ghostscriptPath = env('GHOSTSCRIPT_PATH');
                $uncompressedSuratIzinPath = storage_path('app/public/uploads/lampiran/' . uniqid() . '.pdf'); // path untuk hasil proses yang dilakukan ghostscript
                $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedSuratIzinPath $suratIzinPath";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
                }
                $filesToDelete[] = $uncompressedSuratIzinPath;
                $filesToDelete[] = $oldSuratIzinPath;
                $suratIzinPath = $uncompressedSuratIzinPath; // memakai path hasil ghostscript untuk path surat izin
            }

            $tahun = Carbon::createFromFormat('Y-m-d', $suratIzin->tanggalSurat)->format('Y');
            $bulan = Carbon::createFromFormat('Y-m-d', $suratIzin->tanggalSurat)->format('m');
            $newSuratIzinPath = 'uploads/surat-izin/' . $tahun . '/' . $bulan . '/' . uniqid() . '.pdf'; // path surat berlampiran yg akan disimpan di database
            $pathPenggabungan = storage_path('app/public/' . $newSuratIzinPath); // path surat untuk keperluan penggabungan

            // proses penggabungan surat izin dengan lampiran
            $pdfMerger = PDFMerger::init();
            $pdfMerger->addPDF($suratIzinPath, 'all');
            $pdfMerger->addPDF($fileLampiranPath, 'all');
            $pdfMerger->merge();
            $pdfMerger->save($pathPenggabungan);

            // simpan path surat izin yg sdh berlampiran
            $suratIzin->filePath = $newSuratIzinPath;
            $suratIzin->save();

            // menghapus file yang tidak lagi terpakai
            $filesToDelete[] = $suratIzinPath;
            foreach ($filesToDelete as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
        // END PROCESS file lampiran 


        $tujuanDisposisi = User::find($request->input('idTujuanDisposisi'));
        $status = "Diteruskan ke " . $tujuanDisposisi->namaJabatan;


        $distribusiSurat = new DistribusiSuratIzin();
        $distribusiSurat->idTujuanDisposisi = $request->input('idTujuanDisposisi');
        $distribusiSurat->idPengirimDisposisi = $request->input('idPengirimDisposisi');
        $distribusiSurat->idSuratIzin = $request->input('idSuratIzin');
        $distribusiSurat->instruksi = $request->input('instruksi');
        $distribusiSurat->tanggalDiteruskan = now();
        $distribusiSurat->status = $status;
        $distribusiSurat->save();

        $suratIzin = SuratIzin::find($request->input('idSuratIzin'));
        $suratIzin->idPosisiDisposisi = $request->input('idTujuanDisposisi');
        $suratIzin->status = $status;
        $sifatSurat = $suratIzin->sifatSurat;
        $nomorSurat = $suratIzin->nomorSurat;
        $suratIzin->save();

        $penerima = $suratIzin = User::find($distribusiSurat->idTujuanDisposisi);

        // $job = new ProcessNotifDisposisi(
        //     $sifatSurat,
        //     $nomorSurat,
        //     auth()->user()->namaJabatan,
        //     $penerima->namaJabatan,
        //     $penerima->nama,
        //     \Carbon\Carbon::parse($distribusiSurat->tanggalDiteruskan)->format('d/m/Y'),
        //     $distribusiSurat->instruksi,
        //     $penerima->email
        // );
        // dispatch($job);





        return redirect($redirect)
            ->with('success', "Berhasil Meneruskan Pesan");
    }

    public function lacakDistribusi(SuratIzin $suratIzin)
    {
        $idUser = auth()->user()->id;
        $role = auth()->user()->role;
        $distribusiSurat = DistribusiSuratIzin::where('idSuratIzin', '=', $suratIzin->id)->with(['pengirimDisposisi', 'tujuanDisposisi'])->get();
        $daftarPengirim = [];
        foreach ($distribusiSurat as $ds) {
            array_push($daftarPengirim, $ds->idPengirimDisposisi);
        }

        if ($suratIzin->idPengirim != $idUser) {
            if (! in_array($idUser, $daftarPengirim) && $role != "sekre" && $role != "dev") {
                abort(403);
            }
        }
        // dd($distribusiSurat);
        return view('surat-izin.lacak-distribusi', ['title' => 'Disposisi Surat Izin', 'active' => 'surat izin', 'suratIzin' => $suratIzin, 'distribusiSurat' => $distribusiSurat, 'isForm' => true]);
    }

    public function unduhDisposisi(Request $request)
    {

        $suratIzin = SuratIzin::where('id', '=', $request->input('idSuratIzin'))->get()[0];

        $distribusiSurat = $suratIzin->distribusiSurat;
        $pdf = Pdf::loadView('surat-izin.lembar-disposisi', ['suratIzin' => $suratIzin, 'distribusiSurat' => $distribusiSurat]);
        $timestamp = now()->timestamp; // Mendapatkan timestamp saat ini
        $dompdfFilePath = storage_path('app/public/uploads/disposisi/disposisi_' . $timestamp . '.pdf');
        file_put_contents($dompdfFilePath, $pdf->output());

        $suratIzinPath = storage_path('app/public/' . $suratIzin->filePath);
        $uncompressedSuratIzinPath = storage_path('app/public/uploads/disposisi/uncompressed_suratIzin_' . $timestamp . '.pdf');

        // Coba buka PDF dengan FPDI untuk mendeteksi masalah
        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($suratIzinPath);
            $isProblematic = false;
        } catch (PdfParserException $e) {
            $isProblematic = true;
        }

        // $ghostscriptPath = env('GHOSTSCRIPT_PATH');
        $ghostscriptPath = "gswin64c";

        $command = "gswin64c -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedSuratIzinPath $suratIzinPath";
        exec($command, $output, $return_var);

        if ($isProblematic) {
            if ($return_var !== 0) {
                unlink($dompdfFilePath);
                return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
            }

            $finalSuratIzinPath = $uncompressedSuratIzinPath;
        } else {
            $finalSuratIzinPath = $suratIzinPath;
        }


        // Menggabungkan PDF menggunakan Webklex\PDFMerger\PDFMerger
        $pdfMerger = PDFMerger::init();
        $pdfMerger->addPDF($dompdfFilePath, 'all');
        $pdfMerger->addPDF($finalSuratIzinPath, 'all');

        $pdfMerger->merge();
        // $pdfMerger->stream();
        $pdfMerger->setFileName('disposisi_suratIzin_' . $suratIzin->tahun . '_' . $suratIzin->index . '.pdf');

        $pdfMerger->download();

        // Hapus file PDF yang dihasilkan oleh DomPDF setelah streaming
        unlink($dompdfFilePath);
        if ($isProblematic) {
            unlink($uncompressedSuratIzinPath);
        }
    }

    public function rekapSuratMasuk(Request $request)
    {
        // start (setup dengan parameter bulan)
        // $tanggal = $request->input('bulanRekap');
        // $tahun = Carbon::createFromFormat('Y-m', $tanggal)->format('Y');
        // $bulan = Carbon::createFromFormat('Y-m', $tanggal)->format('m');
        // $suratMasuk = SuratMasuk::whereMonth('tanggalSurat', '=', $bulan)->whereYear('tanggalSurat', '=', $tahun)->get();

        // $zip = new ZipArchive();
        // $zipFilePath = storage_path('app/' . 'rekap_suratmasuk_' . $tahun . '_' . $bulan . '.zip');

        // end (setup dengan parameter bulan)

        // start (setup dengan awal dan akhir)

        $awal = $request->input('awal');
        $akhir = $request->input('akhir');

        // run job
        $job = new ProcessRekapSuratMasuk($awal, $akhir);
        dispatch($job);
        // end job

        return redirect('/surat-izin/index')
            ->with('success', 'Anda akan menerima email ketika unduhan sudah siap');

        // $rekapSuratMasuk = SuratMasuk::whereDate('tanggalSurat', '>=', $awal)->whereDate('tanggalSurat', '<=', $akhir)->with(['distribusiSurat'])->get();
        // // $user = User::all()->keyBy('id');

        // $zip = new ZipArchive();
        // $zipFilePath = storage_path('app/' . 'rekap_suratmasuk_dari_' . $awal . '_sampai_' . $akhir . '.zip');

        // // end (setup dengan awal dan akhir)

        // if ($rekapSuratMasuk->isEmpty()) {
        //     return redirect()->back()->with('error', 'Tidak ada Surat Masuk pada rentang tanggal tersebut');
        // }

        // if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        //     foreach ($rekapSuratMasuk as $sm) {
        //         // GENERATE DISPOSISI
        //         $distribusiSurat = $sm->distribusiSurat;
        //         $suratMasuk = $sm;
        //         // $daftarPengirim = [];
        //         // foreach ($distribusiSurat as $ds) {
        //         //     array_push($daftarPengirim, $ds->idPengirimDisposisi);
        //         // }


        //         // $distribusiSurat = $distribusiSurat->map(function($item) use ($user) {
        //         //     $namaPengirim = isset($user[$item['idPengirimDisposisi']]) ? $user[$item['idPengirimDisposisi']]->namaJabatan : 'Unknown';
        //         //     $namaPenerima = isset($user[$item['idTujuanDisposisi']]) ? $user[$item['idTujuanDisposisi']]->namaJabatan : 'Unknown';

        //         //     // Mengembalikan item dengan tambahan field namaPengirim dan namaPenerima
        //         //     return array_merge($item->toArray(), [
        //         //         'namaPengirim' => $namaPengirim,
        //         //         'namaPenerima' => $namaPenerima
        //         //     ]);
        //         // });
        //         // dd($distribusiSurat);

        //         $pdf = Pdf::loadView('surat-masuk.lembar-disposisi', ['suratMasuk' => $suratMasuk, 'distribusiSurat' => $distribusiSurat]);
        //         $timestamp = now()->timestamp; // Mendapatkan timestamp saat ini
        //         $dompdfFilePath = storage_path('app/public/uploads/disposisi/suratmasuk_' . $sm->tahun . '_' . $sm->index . '_disposisi_' . $timestamp . '.' . '.pdf');
        //         file_put_contents($dompdfFilePath, $pdf->output());

        //         $suratMasukPath = storage_path('app/public/' . $sm->filePath);
        //         $uncompressedSuratMasukPath = storage_path('app/public/uploads/disposisi/uncompressed_suratmasuk_' . $timestamp . '.pdf');

        //         // Coba buka PDF dengan FPDI untuk mendeteksi masalah
        //         try {
        //             $pdf = new Fpdi();
        //             $pageCount = $pdf->setSourceFile($suratMasukPath);
        //             $isProblematic = false;
        //         } catch (PdfParserException $e) {
        //             $isProblematic = true;
        //         }

        //         $ghostscriptPath = env('GHOSTSCRIPT_PATH');

        //         if ($isProblematic) {
        //             // dd($suratMasukPath);
        //             $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedSuratMasukPath $suratMasukPath";
        //             exec($command, $output, $return_var);

        //             if ($return_var !== 0) {
        //                 unlink($dompdfFilePath);
        //                 return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
        //             }

        //             $finalSuratMasukPath = $uncompressedSuratMasukPath;
        //         } else {
        //             $finalSuratMasukPath = $suratMasukPath;
        //         }

        //         // Menggabungkan PDF menggunakan Webklex\PDFMerger\PDFMerger
        //         $pdfMerger = PDFMerger::init();
        //         $pdfMerger->addPDF($dompdfFilePath, 'all');
        //         $pdfMerger->addPDF($finalSuratMasukPath, 'all');

        //         $gabunganPath = storage_path('app/public/uploads/disposisi/suratmasuk_gabungan' . $sm->tahun . '_' . $sm->index . '_disposisi_' . $timestamp . '.' . '.pdf');
        //         $pdfMerger->merge();
        //         $pdfMerger->save($gabunganPath);

        //         $zip->addFile($gabunganPath, 'disposisi_suratmasuk_' . $sm->tahun . '_' . $sm->index . '.pdf');

        //         // Tambahkan file sementara ke daftar file yang akan dihapus
        //         $filesToDelete[] = $dompdfFilePath;
        //         $filesToDelete[] = $gabunganPath;
        //         if ($isProblematic) {
        //             $filesToDelete[] = $uncompressedSuratMasukPath;
        //         }
        //     }
        //     $zip->close();

        //     foreach ($filesToDelete as $file) {
        //         if (file_exists($file)) {
        //             unlink($file);
        //         }
        //     }        

        //     return response()->download($zipFilePath)->deleteFileAfterSend(true);
        // } else {
        //     dd('gagal membuka file zip');
        // }

    }


    public function nonSekreBelumDiteruskan()
    {
        $suratIzin = SuratIzin::where('idPosisiDisposisi', auth()->user()->id)->with(['userPengirim'])->orderBy('id', 'desc');

        if (request('index')) {
            $suratIzin = $suratIzin->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }
        if (request('tanggalAkhir')) {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }
        if (request('pengirim')) {
            $suratIzin = $suratIzin->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }
        if (request('nomorSurat')) {
            $suratIzin = $suratIzin->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }
        if (request('perihal')) {
            $suratIzin = $suratIzin->where('perihal', 'like', '%' . request('perihal') . '%');
        }
        if (request('status')) {
            $suratIzin = $suratIzin->where('status', 'like', '%' . request('status') . '%');
        }
        return view('surat-izin.surat-disposisi-belum-diteruskan', ['title' => 'Surat Izin Belum Diteruskan', 'active' => 'belum diteruskan', 'suratIzin' => $suratIzin->paginate(25), 'isForm' => false]);
    }

    public function nonSekreDikirim()
    {
        $suratIzin = SuratIzin::where('idPengirim', auth()->user()->id)->with(['userPengirim'])->orderBy('id', 'desc');

        if (request('index')) {
            $suratIzin = $suratIzin->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }
        if (request('tanggalAkhir')) {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }
        if (request('pengirim')) {
            $suratIzin = $suratIzin->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }
        if (request('nomorSurat')) {
            $suratIzin = $suratIzin->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }
        if (request('perihal')) {
            $suratIzin = $suratIzin->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        return view('surat-izin.surat-disposisi-dikirim', ['title' => 'Surat Izin Dikirim', 'active' => 'yang dikirim', 'suratIzin' => $suratIzin->paginate(25), 'isForm' => false]);
    }

    public function nonSekreSudahDiteruskan()
    {

        // Old penarikan data
        $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDSIzin;
        $suratIzin = collect([]);
        foreach ($distribusiSurat as $ds) {
            $suratIzin->push($ds->suratIzin);
        }
        $suratIzin = $suratIzin->unique('id');
        $suratIzin = $suratIzin->sortBy([
            ['tahun', 'desc'],
            ['index', 'desc'],
        ]);
        $suratIzin = $suratIzin->where('status', '<>', 'Diarsipkan');

        // BEGINNING OF PENCARIAN
        if (request('index')) {
            $suratIzin = $suratIzin->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $tanggalAwal = request('tanggalAwal');
            $suratIzin = $suratIzin->filter(function ($item) use ($tanggalAwal) {
                return strtotime($item['tanggalSurat']) >= strtotime($tanggalAwal);
            });
        }
        if (request('tanggalAkhir')) {
            $tanggalAkhir = request('tanggalAkhir');
            $suratIzin = $suratIzin->filter(function ($item) use ($tanggalAkhir) {
                return strtotime($item['tanggalSurat']) <= strtotime($tanggalAkhir);
            });
        }
        if (request('pengirim')) {
            $suratIzin = $suratIzin->filter(function ($item) {
                return stripos($item['pengirim'], request('pengirim')) !== false;
            });
        }
        if (request('nomorSurat')) {
            $suratIzin = $suratIzin->filter(function ($item) {
                return stripos($item['nomorSurat'], request('nomorSurat')) !== false;
            });
        }
        if (request('perihal')) {
            $suratIzin = $suratIzin->filter(function ($item) {
                return stripos($item['perihal'], request('perihal')) !== false;
            });
        }
        if (request('status')) {
            $suratIzin = $suratIzin->filter(function ($item) {
                return stripos($item['status'], request('status')) !== false;
            });
        }
        // END OF PENCARIAN

        // Make Pagination
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 25;
        $currentPageItems = $suratIzin->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, $suratIzin->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('surat-izin.surat-disposisi-sudah-diteruskan', [
            'title' => 'Surat Izin Sudah Diteruskan',
            'active' => 'sudah diteruskan',
            'suratIzin' => $paginatedItems,
            'isForm' => false
        ]);
    }

    public function nonSekreSudahDiarsipkan()
    {
        $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDSIzin;
        $suratIzin = collect([]);
        foreach ($distribusiSurat as $ds) {
            $suratIzin->push($ds->suratIzin);
        }
        $suratIzin = $suratIzin->unique('id');
        $suratIzin = $suratIzin->sortBy([
            ['tahun', 'desc'],
            ['index', 'desc'],
        ]);
        $suratIzin = $suratIzin->where('status', 'Diarsipkan');
        // BEGINNING OF PENCARIAN
        if (request('index')) {
            $suratIzin = $suratIzin->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $tanggalAwal = request('tanggalAwal');
            $suratIzin = $suratIzin->filter(function ($item) use ($tanggalAwal) {
                return strtotime($item['tanggalSurat']) >= strtotime($tanggalAwal);
            });
        }
        if (request('tanggalAkhir')) {
            $tanggalAkhir = request('tanggalAkhir');
            $suratIzin = $suratIzin->filter(function ($item) use ($tanggalAkhir) {
                return strtotime($item['tanggalSurat']) <= strtotime($tanggalAkhir);
            });
        }
        if (request('pengirim')) {
            $suratIzin = $suratIzin->filter(function ($item) {
                return stripos($item['pengirim'], request('pengirim')) !== false;
            });
        }
        if (request('nomorSurat')) {
            $suratIzin = $suratIzin->filter(function ($item) {
                return stripos($item['nomorSurat'], request('nomorSurat')) !== false;
            });
        }
        if (request('perihal')) {
            $suratIzin = $suratIzin->filter(function ($item) {
                return stripos($item['perihal'], request('perihal')) !== false;
            });
        }
        // END OF PENCARIAN

        // make paginasi
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 25;
        $currentPageItems = $suratIzin->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, $suratIzin->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('surat-izin.surat-disposisi-sudah-diarsipkan', [
            'title' => 'Surat Izin Sudah Diarsipkan',
            'active' => 'sudah diarsipkan',
            'suratIzin' => $paginatedItems,
            'isForm' => false
        ]);
    }


    public function arsipkan(Request $request)
    {
        $request->validate([
            'idTujuanDisposisi' => 'required',
            'idSuratIzin' => 'required',
            'instruksi' => 'required',
            'idPengirimDisposisi' => 'required',
            'fileLampiranArsip' => 'mimes:pdf,jpg,png|max:5120'
        ]);

        $redirect = "/";
        if (auth()->user()->id == 1) {
            $redirect = "/surat-izin/index"
                . '?tanggalAwal=' . urlencode(session('search_tanggalAwal', ''))
                . '&tanggalAkhir=' . urlencode(session('search_tanggalAkhir', ''))
                . '&index=' . urlencode(session('search_index', ''))
                . '&pengirim=' . urlencode(session('search_pengirim', ''))
                . '&nomorSurat=' . urlencode(session('search_nomorSurat', ''))
                . '&perihal=' . urlencode(session('search_perihal', ''))
                . '&status=' . urlencode(session('search_status', ''));
        }

        session()->forget('search_tanggalAwal');
        session()->forget('search_tanggalAkhir');
        session()->forget('search_index');
        session()->forget('search_pengirim');
        session()->forget('search_nomorSurat');
        session()->forget('search_perihal');
        session()->forget('search_status');

        // START PROCESS file lampiran
        if ($request->file('fileLampiranArsip')) {
            // dd("izin lampiran");
            $filesToDelete = [];
            $mimeType = $request->file('fileLampiranArsip')->getMimeType();
            if (strpos($mimeType, 'image') !== false) { // jika input user berupa image, maka convert image to pdf
                $imageContent = file_get_contents($request->file('fileLampiranArsip')->getRealPath());
                $data = [
                    'imageContent' => $imageContent,
                ];
                $pdf = PDF::loadView('pdf.image-to-pdf', $data);
                $uploadImagePdfPath = 'public/uploads/lampiran/' . uniqid() . '.pdf'; // path untuk menyimpan file lampiran yg img-to-pdf
                Storage::put($uploadImagePdfPath, $pdf->output());
                $fileLampiranPath = storage_path('app/' . $uploadImagePdfPath); // path sementara untuk file lampiran
                $filesToDelete[] = $fileLampiranPath;
            } else { // jika input user berupa pdf
                $fileLampiranPath = storage_path('app/public/' . $request->file('fileLampiranArsip')->store('uploads/lampiran', 'public')); // path sementara untuk file lampiran
                $filesToDelete[] = $fileLampiranPath;
            }
            try { // memeriksa apakah versi pdf bermasalah atau tidak
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($fileLampiranPath);
                $isProblematic = false;
            } catch (PdfParserException $e) {
                $isProblematic = true;
            }
            if ($isProblematic) { // jika versi pdf bermasalah, jalankan ghostscript untuk mengganti versi pdf
                $ghostscriptPath = env('GHOSTSCRIPT_PATH');
                $uncompressedfileLampiranPath = storage_path('app/public/uploads/lampiran/' . uniqid() . '.pdf'); // path untuk hasil proses yang dilakukan ghostscript
                $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedfileLampiranPath $fileLampiranPath";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
                }
                $fileLampiranPath = $uncompressedfileLampiranPath; // memakai path hasil ghostscript untuk path file lampiran
                $filesToDelete[] = $fileLampiranPath;
            }

            // akses row surat izin untuk menyimpan file surat izin yang sdh digabung dengan lampiran  
            $suratIzin = SuratIzin::find($request->input('idSuratIzin'));
            $suratIzinPath = storage_path('app/public/' . $suratIzin->filePath); //path surat izin sebelum digabung

            try { // memeriksa apakah versi pdf bermasalah atau tidak
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($suratIzinPath);
                $isSuratIzinProblematic = false;
            } catch (PdfParserException $e) {
                $isSuratIzinProblematic = true;
            }
            if ($isSuratIzinProblematic) { // jika versi pdf bermasalah, jalankan ghostscript untuk mengganti versi pdf
                $oldSuratIzinPath = $suratIzinPath;
                $ghostscriptPath = env('GHOSTSCRIPT_PATH');
                $uncompressedSuratIzinPath = storage_path('app/public/uploads/lampiran/' . uniqid() . '.pdf'); // path untuk hasil proses yang dilakukan ghostscript
                $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedSuratIzinPath $suratIzinPath";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
                }
                $filesToDelete[] = $uncompressedSuratIzinPath;
                $filesToDelete[] = $oldSuratIzinPath;
                $suratIzinPath = $uncompressedSuratIzinPath; // memakai path hasil ghostscript untuk path surat izin
            }

            $tahun = Carbon::createFromFormat('Y-m-d', $suratIzin->tanggalSurat)->format('Y');
            $bulan = Carbon::createFromFormat('Y-m-d', $suratIzin->tanggalSurat)->format('m');
            $newSuratIzinPath = 'uploads/surat-izin/' . $tahun . '/' . $bulan . '/' . uniqid() . '.pdf'; // path surat berlampiran yg akan disimpan di database
            $pathPenggabungan = storage_path('app/public/' . $newSuratIzinPath); // path surat untuk keperluan penggabungan

            // proses penggabungan surat izin dengan lampiran
            $pdfMerger = PDFMerger::init();
            $pdfMerger->addPDF($suratIzinPath, 'all');
            $pdfMerger->addPDF($fileLampiranPath, 'all');
            $pdfMerger->merge();
            $pdfMerger->save($pathPenggabungan);

            // simpan path surat izin yg sdh berlampiran
            $suratIzin->filePath = $newSuratIzinPath;
            $suratIzin->save();

            // menghapus file yang tidak lagi terpakai
            $filesToDelete[] = $suratIzinPath;
            foreach ($filesToDelete as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        $suratIzin = SuratIzin::find($request->input('idSuratIzin'));
        $suratIzin->statusArsip = 1;
        $suratIzin->idPosisiDisposisi = 1;
        $suratIzin->status = "Diarsipkan";
        $suratIzin->save();

        $distribusiSurat = new DistribusiSuratIzin();
        $distribusiSurat->idTujuanDisposisi = $request->input('idTujuanDisposisi');
        $distribusiSurat->idPengirimDisposisi = $request->input('idPengirimDisposisi');
        $distribusiSurat->idSuratIzin = $request->input('idSuratIzin');
        $distribusiSurat->instruksi = $request->input('instruksi');
        $distribusiSurat->tanggalDiteruskan = now();
        $distribusiSurat->status = "Diarsipkan";
        $distribusiSurat->save();
        return redirect($redirect)->with('success', 'Berhasil Mengarsipkan Surat');
    }

    public function bukaArsip(Request $request)
    {
        $distribusiSurat = DistribusiSuratIzin::where("idSuratIzin", $request->input('idSuratIzin'))->get();
        $suratIzin = SuratIzin::find($request->input('idSuratIzin'));
        $suratIzin->statusArsip = 0;
        $suratIzin->save();
        return redirect('/surat-izin/disposisi/' . $request->input('idSuratIzin'));
    }

    public function laporanDistribusiSuratIzin(?string $keterangan = null)
    {
        $suratIzin = SuratIzin::orderBy('id', 'desc');
        $judul = "Laporan Surat Izin";
        $terusan = User::where('id', '<>', 1)->where('id', '<>', 2)->get();

        if ($keterangan == "posisi-terakhir") {
            $suratIzin->where('statusArsip', '=', 0);
            $judul = "Laporan Distribusi Surat Berdasarkan Tujuan Disposisi Terakhir";
        }

        if ($keterangan == "sudah-selesai") {
            $judul = "Laporan Distribusi Surat yang Sudah Selesai";
        }

        if ($keterangan == "pernah-distribusi") {
            $judul = "Laporan Distribusi Surat yang Pernah Didistribusikan";
        }

        if (request('disposisiTerakhir')) {
            if (request('disposisiTerakhir') == "Belum Diteruskan") {
                $suratIzin->where('status', '=', 'Belum Diteruskan');
            } else {
                $suratIzin->where('idPosisiDisposisi', '=', request('disposisiTerakhir'));
            }
        }

        if (request('statusArsip')) {
            if (request('statusArsip') == "Belum") {
                $suratIzin = $suratIzin->where('statusArsip', '=', 0);
            } elseif (request('statusArsip') == "Arsip") {
                $suratIzin = $suratIzin->where('statusArsip', '=', 1);
            }
        }

        if (request('tujuanDisposisi')) {
            $distribusiSurat = User::where('id', '=', request('tujuanDisposisi'))->get()[0]->menerimaDSIzin;
            $idSM = collect([]);
            foreach ($distribusiSurat as $ds) {
                $idSM->push($ds->suratIzin->id);
            }
            $idSM = $idSM->unique();
            $suratIzin = $suratIzin->whereIn('id', $idSM);
        }

        if (request('tanggalAwal')) {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $suratIzin = $suratIzin->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        if (request('index')) {
            $suratIzin->where('id', '=', request('index'));
        }

        if (request('tahun')) {
            $suratIzin->whereYear('tanggalSurat', request('tahun'));
        }

        if (request('status')) {
            $suratIzin->where('status', request('status'));
        }

        if (request('pengirim')) {
            $suratIzin->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }

        if (request('nomorSurat')) {
            $suratIzin->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }

        if (request('perihal')) {
            $suratIzin->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        return view('surat-izin.laporan-distribusi-surat', ['title' => $judul, 'active' => 'laporan', 'suratIzin' => $suratIzin->paginate(15), 'keterangan' => $keterangan, 'judul' => $judul, 'terusan' => $terusan]);
    }

    public function laporanPerTujuan()
    {

        // Mendapatkan jumlah surat izin yang diteruskan ke masing-masing user
        $rekap = DB::table('surat_izin')
            ->join('distribusi_surat', 'surat_izin.id', '=', 'distribusi_surat.idSuratIzin')
            ->join('users', 'distribusi_surat.idTujuanDisposisi', '=', 'users.id')
            ->select('users.namaJabatan', DB::raw('COUNT(DISTINCT surat_izin.id) as jumlah_surat_izin'))
            ->where('users.id', '<>', 1)
            ->groupBy('users.namaJabatan')
            ->orderBy('users.id', 'asc');

        if (request('tanggalAwal')) {
            $rekap = $rekap->whereDate('surat_izin.tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $rekap = $rekap->whereDate('surat_izin.tanggalSurat', '<=', request('tanggalAkhir'));
        }

        return view('surat-izin.laporan-per-tujuan', ['title' => 'Surat Izin Per Tujuan Disposisi', 'active' => 'laporan', 'rekap' => $rekap->get()]);
    }

    public function indexNs()
    {
        return view('surat-izin.index-ns', [
            'title' => 'Surat Izin',
            'active' => 'surat izin',
            'isForm' => false
        ]);
    }
}
