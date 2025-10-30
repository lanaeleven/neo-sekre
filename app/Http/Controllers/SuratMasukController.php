<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\User;
use App\Models\Direksi;
use setasign\Fpdi\Fpdi;
use App\Models\SuratMasuk;
use App\Models\UserKepala;
use Illuminate\Http\Request;
use App\Models\PenerimaKhusus;
use App\Models\PengirimKhusus;
use Illuminate\Support\Carbon;
use App\Models\DistribusiSurat;
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
use Illuminate\Pagination\LengthAwarePaginator;
use setasign\Fpdi\PdfParser\PdfParserException;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class SuratMasukController extends Controller
{
    public function create(?string $keterangan = null) {
        $suratMasuk = SuratMasuk::orderBy('tahun', 'desc')->orderBy('index', 'desc');
        $direksi = Direksi::all();
        $judul = "Surat Masuk";
        // $pengirim = User::whereNotIn("id", [1,2,3])->get();

        if ($keterangan == 'hari-ini') {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '=', now());
            $judul = "Surat Masuk Hari Ini";
        }

        if ($keterangan == 'bulan-ini') {
            $suratMasuk = $suratMasuk->whereMonth('tanggalSurat', '=', now()->format('m'))->whereYear('tanggalSurat', '=', now()->format('Y'));
            $judul = "Surat Masuk Bulan Ini";
        }

        if (request('index')) {
            $suratMasuk->where('index', '=', request('index'));
        }
        
        if (request('tanggalAwal')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }        

        if (request('direksi')) {
            $suratMasuk->where('idDireksi', request('direksi'));
        }

        if (request('status')) {
            $suratMasuk->where('status', 'like', '%' . request('status') . '%');
        }

        if (request('pengirim')) {
            $suratMasuk->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }

        if (request('nomorSurat')) {
            $suratMasuk->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }

        if (request('perihal')) {
            $suratMasuk->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        if (request('tahun')) {
            $suratMasuk->where('tahun', 'like', '%' . request('tahun') . '%');
        }

        // penyimpanan session
        session([
            'search_tanggalAwal' => request('tanggalAwal'),
            'search_tanggalAkhir' => request('tanggalAkhir'),
            'search_index' => request('index'),
            'search_direksi' => request('direksi'),
            'search_pengirim' => request('pengirim'),
            'search_nomorSurat' => request('nomorSurat'),
            'search_perihal' => request('perihal'),
            'search_status' => request('status')
        ]);

        return view('surat-masuk.index', ['title' => $judul, 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk->with(['direksi', 'userPengirim'])->paginate(15), 'direksi' => $direksi, 'keterangan' => $keterangan, 'judul' => $judul]);
    }

    public function tambah() {
        $direksi = Direksi::all();
        $pengirim = User::whereNotIn('id', [1, 2, 3])->where('isAktif', true)->get();
        
        return view('surat-masuk.tambah', ['title' => 'Tambah Surat Masuk', 'active' => 'surat masuk', 'direksi' => $direksi, 'pengirim' => $pengirim]);
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
            'direksi' => 'required',
            'perihal' => 'required',
            'fileSurat' => 'required|mimes:pdf,jpg,png|max:10240'
        ]);
        
        $tahun = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');
        // Get the maximum id for the given year
        $maxIndex = SuratMasuk::where('tahun', $tahun)->max('index');
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
            $filePath = 'uploads/surat-masuk/' . $tahun . '/' . $bulan . '/' . uniqid() . '.pdf';
            $storagePath = 'public/' . $filePath;

            // Simpan file PDF ke storage
            Storage::put($storagePath, $pdf->output());
        } else {
            $filePath = $request->file('fileSurat')->store('uploads/surat-masuk/' . $tahun . '/' . $bulan, 'public');
        }
        $fileName = $request->file('fileSurat')->getClientOriginalName();

        

        
        $suratMasuk = new SuratMasuk();
        $suratMasuk->index = $newIndex;
        $suratMasuk->idPosisiDisposisi = $request->input('idPosisiDisposisi');
        $suratMasuk->tanggalAgenda = $request->input('tanggalAgenda');
        $suratMasuk->sifatSurat = $request->input('sifatSurat');
        $suratMasuk->nomorSurat = $request->input('nomorSurat');
        $suratMasuk->tanggalSurat = $request->input('tanggalSurat');
        $suratMasuk->tahun = $tahun;
        $suratMasuk->lampiran = $request->input('lampiran');
        $suratMasuk->idPengirim = $request->input('idPengirim') != "lainnya" ? $request->input('idPengirim') : NULL; 
        $suratMasuk->pengirim = $request->input('pengirim');
        $suratMasuk->idDireksi = $request->input('direksi');
        $suratMasuk->perihal = $request->input('perihal');
        $suratMasuk->status = $request->input('status');
        $suratMasuk->statusArsip = 0;
        $suratMasuk->fileName = $fileName;
        $suratMasuk->filePath = $filePath;
        $suratMasuk->save();

        
        if (!($request->input('idPengirim') == 'lainnya')) {
            $user = User::find($request->input('idPengirim'));
            $job = new ProcessNotifSuratMasukBaru($user->email, $user->namaJabatan, $request->input('nomorSurat'));
            dispatch($job);
        }


        return redirect('/surat-masuk/index?tahun=' . config('app.tahun'))
            ->with('success', "Berhasil Menambahkan Surat Masuk");
    }

    public function edit(SuratMasuk $suratMasuk) {
        $direksi = Direksi::all();
        $pengirim = User::whereNotIn('id', [1, 2, 3])->get();

        return view('surat-masuk.edit', ['title' => 'Edit Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk, 'direksi' => $direksi, 'pengirim' => $pengirim]);
    }

    public function editTerusanSurat(int $idSuratMasuk, DistribusiSurat $terusanSurat) {
        return view('surat-masuk.edit-terusan-surat', ['title' => 'Edit Terusan Surat', 'active' => 'surat masuk', 'terusanSurat' => $terusanSurat, 'idSuratMasuk' => $idSuratMasuk]);
    }

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
            'direksi' => 'required',
            'perihal' => 'required',
            'fileSurat' => 'mimes:pdf,jpg,png|max:7168'
        ]);

        // dd($request->input());

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
                $filePath = 'uploads/surat-masuk/' . $tahunInput . '/' . $bulan . '/' . uniqid() . '.pdf';
                $storagePath = 'public/' . $filePath;
                // Simpan file PDF ke storage
                Storage::put($storagePath, $pdf->output());
            } else {
                $filePath = $request->file('fileSurat')->store('uploads/surat-masuk/' . $tahunInput . '/' . $bulan, 'public');
            }
                // Store the file in storage\app\public folder
                $fileName = $request->file('fileSurat')->getClientOriginalName();
        }

        // Store file information in the database
        $suratMasuk = SuratMasuk::find($request->input('id'));
        $suratMasuk->tanggalAgenda =$request->input('tanggalAgenda');
        $suratMasuk->sifatSurat =$request->input('sifatSurat');
        $suratMasuk->nomorSurat =$request->input('nomorSurat');
        $suratMasuk->tanggalSurat =$request->input('tanggalSurat');
        $suratMasuk->lampiran =$request->input('lampiran');
        $suratMasuk->idDireksi =$request->input('direksi');
        $suratMasuk->idPengirim = $request->input('idPengirim') != "lainnya" ? $request->input('idPengirim') : NULL; 
        $suratMasuk->pengirim = $request->input('pengirim');
        $suratMasuk->perihal =$request->input('perihal');
        $suratMasuk->status =$request->input('status');
        if ($request->file('fileSurat')) {
            $suratMasuk->fileName = $fileName;
            $suratMasuk->filePath = $filePath;
        }
        
        if ($tahunInput != $request->input('tahun')) {
            // Get the maximum id for the given year
            $maxIndex = SuratMasuk::where('tahun', $tahunInput)->max('index');
            // Determine the new id for the given year
            $newIndex = $maxIndex ? $maxIndex + 1 : 1;

            $suratMasuk->tahun = $tahunInput;
            $suratMasuk->index = $newIndex;         
        }
        $suratMasuk->save();

        // Redirect back to the index page with a success message
        return redirect('/surat-masuk/index?tahun=' . config('app.tahun'))
            ->with('success', "Berhasil Mengedit Surat Masuk");
    }

    public function updateTerusanSurat(Request $request): RedirectResponse
    {
        $request->validate([
            'idTerusanSurat' => 'required',
            'idSuratMasuk' => 'required',
            'waktuDiteruskan' => 'required',
        ]);

        $waktuDiteruskanFormatted = Carbon::parse($request->input('waktuDiteruskan'))->format('Y-m-d H:i:s');

        $terusanSurat = DistribusiSurat::find($request->input('idTerusanSurat'));
        $terusanSurat->tanggalDiteruskan = $waktuDiteruskanFormatted;
        $terusanSurat->save();

        return redirect('/surat-masuk/lacak-distribusi/' . $request->input('idSuratMasuk'))
            ->with('success', "Berhasil Mengedit Terusan Surat");
    }


    public function disposisi(SuratMasuk $suratMasuk) {
        // $terusan = User::where('id', '<>', auth()->user()->id)->where('id', '<>', 2)->get();

        // mengambil id kepala dalam bentuk array
        // dd(request('perihal'));
        $idUser = auth()->user()->id;
        $idKepala = UserKepala::select('idUser')->get();
        $arrIdKepala = [];
        foreach ($idKepala as $ik) {
            array_push($arrIdKepala, $ik->idUser);
        }
        $terusan = null;

        if (auth()->user()->isKhusus) {
            $penerimaTerusanKhusus = PengirimKhusus::where('idUser', $idUser)->get();
            $terusan = User::whereIn('id', $penerimaTerusanKhusus->select('bisaMengirimKe'))->get();
        } 
        
        else {
            $pengirimTerusanKhusus = PenerimaKhusus::where('bisaMenerimaDari', $idUser)->get();
            $terusanKhusus = User::whereIn('id', $pengirimTerusanKhusus->select('idUser'))->get();
            
            // if($idUser == 1 || in_array($idUser, $arrIdKepala)) { // daftar opsi terusan untuk sekre dan kepala 
            //     $terusan = User::where('id', '<>', $idUser)->where('id', '<>', 2)->where('isKhusus', false)->get();
            //     if ($terusanKhusus->isNotEmpty()) {
            //         $terusan = $terusan->merge($terusanKhusus);
            //     }
            // } elseif ($idUser == 3){ // daftar opsi terusan untuk direktur
            //     $terusan = User::whereIn('id', $arrIdKepala)->orWhere('id', 1)->where('isKhusus', false)->get();
            //     if ($terusanKhusus->isNotEmpty()) {
            //         $terusan = $terusan->merge($terusanKhusus);
            //     }
            // } else { // daftar opsi terusan untuk kasubbag/penjab/dsb
            //     $terusan = User::where('id', '<>', 2)->where('id', '<>', 3)->where('id', '<>', $idUser)->where('isKhusus', false)->get();
            //     if ($terusanKhusus->isNotEmpty()) {
            //         $terusan = $terusan->merge($terusanKhusus);
            //     }
            // }

            // MetaData
            // Level Jabatan
            // 1 = Sekretariat
            // 2 = Direktur
            // 3 = Kabag/Kabid
            // 4 = Kasubag
            // 5 = Komite/Tim
            //
            // Id User Spesial
            // 1 = Sekretariat
            // 2 = Developer
            // 3 = Direktur

            $levelJabatan = null;
            try {
                $results = StrukturOrganisasi::select('levelJabatan')->where('idUser', $idUser)->get();
                if ($results->isEmpty()) {
                    $levelJabatan = null;
                } else {
                    $levelJabatan = $results[0]->levelJabatan;
                }
            } catch (\Throwable $th) {
                throw $th;
            }

            if ($levelJabatan) {
                if ($levelJabatan == 1) {
                    $terusan = User::where('id', '<>', $idUser)->where('id', '<>', 2)->where('isKhusus', false)->where('isAktif', true)->get();
                    if ($terusanKhusus->isNotEmpty()) {
                        $terusan = $terusan->merge($terusanKhusus);
                    }
                } elseif ($levelJabatan == 2) {
                    $terusan = DB::select(
                            'SELECT *
                            FROM users
                            WHERE ( 
                                id IN (SELECT idUser
                                FROM struktur_organisasi
                                WHERE levelJabatan = 3 OR levelJabatan = 5)
                                -- OR id = 1
                            ) AND isKhusus = false AND id != :idUser AND isAktif = true ;',
                            ['idUser' => $idUser]
                            );
                    if ($terusanKhusus->isNotEmpty()) {
                        $terusan = [...$terusan, ...$terusanKhusus];
                    }
                } elseif ($levelJabatan == 3) {
                    $terusan = DB::select(
                        'SELECT *
                        FROM users
                        WHERE (
                            id IN (SELECT idUser
                            FROM struktur_organisasi
                            WHERE levelJabatan = 3 OR levelJabatan = 5
                            OR idAtasan = :idAtasan)
                            -- OR id IN (1,3)
                            OR id = (3)
                            )
                        AND isKhusus = false AND id != :idUser AND isAktif = true ;',
                        ['idAtasan' => $idUser,
                        'idUser' => $idUser]
                        );

                    if ($idUser == 9 || $idUser == 10 || $idUser == 44) {
                        $terusanKeSekre = User::where('id', 1)->get();
                        $terusan = [...$terusan, ...$terusanKeSekre];
                    }

                    if ($terusanKhusus->isNotEmpty()) {
                        $terusan = [...$terusan, ...$terusanKhusus];
                    }
                } elseif ($levelJabatan == 4) {
                    $terusan = DB::select(
                        'SELECT *  FROM users 
                        WHERE (
                            id IN (SELECT idUser
                                FROM struktur_organisasi
                                WHERE levelJabatan = 4 OR levelJabatan = 5) 
                            OR id = (SELECT idAtasan 
                                FROM struktur_organisasi
                                WHERE idUser = ?
                                LIMIT 1)
                            -- OR id = 1
                            )
                        AND isKhusus = false AND id != ? AND isAktif = true ;',
                        [$idUser, $idUser]
                        );

                    // $terusan = DB::select(
                    //     'SELECT *  FROM users 
                    //     WHERE id IN (SELECT idUser
                    //             FROM struktur_organisasi
                    //             WHERE levelJabatan = 4 OR levelJabatan = 3)
                    //     AND isKhusus = false AND id != ? ;',
                    //     [$idUser]
                    //     );

                    if ($idUser == 9 || $idUser == 10 || $idUser == 44) {
                        $terusanKeSekre = User::where('id', 1)->get();
                        $terusan = [...$terusan, ...$terusanKeSekre];
                    }

                    if ($terusanKhusus->isNotEmpty()) {
                        $terusan = [...$terusan, ...$terusanKhusus];
                    }
                } elseif ($levelJabatan == 5) {
                    $terusan = DB::select(
                            'SELECT *
                            FROM users
                            WHERE ( 
                                id IN (SELECT idUser
                                FROM struktur_organisasi
                                WHERE levelJabatan IN (2,3,4,5))
                            ) AND isKhusus = false AND id != :idUser AND isAktif = true ;',
                            ['idUser' => $idUser]
                            );
                    if ($terusanKhusus->isNotEmpty()) {
                        $terusan = [...$terusan, ...$terusanKhusus];
                    }
                } else {
                    return ('Maaf, posisi Jabatan Akun Anda belum disetting oleh Sekretariat, Silakan hubungi Sekretariat');
                }
            } 
        }

        
        
            // PENGECEKAN UNTUK USER NON-SEKRE PADA SURAT YANG SUDAH DITERUSKAN
            // PENGECEKAN APAKAH SURAT MASUK SUDAH PERNAH DITERUSKAN ATAU BELUM, JIKA BELUM MAKA TIDAK MELEWATI GATE DISPOSISI-SURAT
            if (DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->exists()) {
                $cekDS = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->orderBy('id', 'desc')->get()[0];
                if ((! Gate::allows('disposisi-surat', $cekDS) || $cekDS->status == "Diarsipkan") && $idUser != 1) {
                    abort(403);
                }
            }

            // PENGECEKAN UNTUK USER NON-SEKRE PADA SURAT YANG BELUM DITERUSKAN
            // PENGECEKAN APAKAH SURAT MASUK YANG BELUM DITERUSKAN DIAKSES OLEH ADMIN ATAU BUKAN, JIKA BUKAN ADMIN MAKA TIDAK DIPERBOLEHKAN
            if ($suratMasuk->status == "Belum Diteruskan" && $idUser != 1) {
                abort(403);
            }
        
        

        // JIKA SUDAH MELEWATI SEMUA GATE, KEMUDIAN AMBIL DATA DISTRIBUSI SURAT
        $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->with(['pengirimDisposisi', 'tujuanDisposisi'])->get();

        return view('surat-masuk.disposisi', ['title' => 'Disposisi Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk, 'terusan' => $terusan, 'distribusiSurat' => $distribusiSurat]);
    }

    public function teruskan(Request $request): RedirectResponse
    {
        // $perihal = session('search_query_perihal', '');
        
        // pembedaan redirect user sekre dan non-sekre
        if (auth()->user()->id == 1) {
            $redirect = '/surat-masuk/index'
                    . '?tanggalAwal=' . urlencode(session('search_tanggalAwal', ''))
                    . '&tanggalAkhir=' . urlencode(session('search_tanggalAkhir', ''))
                    . '&index=' . urlencode(session('search_index', ''))
                    . '&direksi=' . urlencode(session('search_direksi', ''))
                    . '&pengirim=' . urlencode(session('search_pengirim', ''))
                    . '&nomorSurat=' . urlencode(session('search_nomorSurat', ''))
                    . '&perihal=' . urlencode(session('search_perihal', ''))
                    . '&status=' . urlencode(session('search_status', ''))
            ;
        } else {
            $redirect = '/';
        } 

        session()->forget('search_tanggalAwal');
        session()->forget('search_tanggalAkhir');
        session()->forget('search_index');
        session()->forget('search_direksi');
        session()->forget('search_pengirim');
        session()->forget('search_nomorSurat');
        session()->forget('search_perihal');
        session()->forget('search_status');
        
        // validasi input dari user
        $request->validate([
            'idTujuanDisposisi' => 'required',
            'idSuratMasuk' => 'required',
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

            // akses row surat masuk untuk menyimpan file surat masuk yang sdh digabung dengan lampiran  
            $suratMasuk = SuratMasuk::find($request->input('idSuratMasuk'));
            $suratMasukPath = storage_path('app/public/' . $suratMasuk->filePath); //path surat masuk sebelum digabung

            try { // memeriksa apakah versi pdf bermasalah atau tidak
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($suratMasukPath);
                $isSuratMasukProblematic = false;
            } catch (PdfParserException $e) {
                $isSuratMasukProblematic = true;
            }
            if ($isSuratMasukProblematic) { // jika versi pdf bermasalah, jalankan ghostscript untuk mengganti versi pdf
                $oldSuratMasukPath = $suratMasukPath;
                $ghostscriptPath = env('GHOSTSCRIPT_PATH');
                $uncompressedSuratMasukPath = storage_path('app/public/uploads/lampiran/' . uniqid() . '.pdf'); // path untuk hasil proses yang dilakukan ghostscript
                $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedSuratMasukPath $suratMasukPath";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
                }
                $filesToDelete[] = $uncompressedSuratMasukPath;
                $filesToDelete[] = $oldSuratMasukPath;
                $suratMasukPath = $uncompressedSuratMasukPath; // memakai path hasil ghostscript untuk path surat masuk
            }

            $tahun = Carbon::createFromFormat('Y-m-d', $suratMasuk->tanggalSurat)->format('Y');
            $bulan = Carbon::createFromFormat('Y-m-d', $suratMasuk->tanggalSurat)->format('m');
            $newSuratMasukPath = 'uploads/surat-masuk/' . $tahun . '/' . $bulan . '/' . uniqid() . '.pdf'; // path surat berlampiran yg akan disimpan di database
            $pathPenggabungan = storage_path('app/public/' . $newSuratMasukPath); // path surat untuk keperluan penggabungan
            
            // proses penggabungan surat masuk dengan lampiran
            $pdfMerger = PDFMerger::init();
            $pdfMerger->addPDF($suratMasukPath, 'all');
            $pdfMerger->addPDF($fileLampiranPath, 'all');
            $pdfMerger->merge();
            $pdfMerger->save($pathPenggabungan);

            // simpan path surat masuk yg sdh berlampiran
            $suratMasuk->filePath = $newSuratMasukPath;
            $suratMasuk->save();

            // menghapus file yang tidak lagi terpakai
            $filesToDelete[] = $suratMasukPath;
            foreach ($filesToDelete as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }  
        }
        // END PROCESS file lampiran 


        $tujuanDisposisi = User::find($request->input('idTujuanDisposisi'));
        $status = "Diteruskan ke " . $tujuanDisposisi->namaJabatan;

        $distribusiSurat = new DistribusiSurat();
        $distribusiSurat->idTujuanDisposisi = $request->input('idTujuanDisposisi');
        $distribusiSurat->idPengirimDisposisi = $request->input('idPengirimDisposisi');
        $distribusiSurat->idSuratMasuk = $request->input('idSuratMasuk');
        $distribusiSurat->instruksi = $request->input('instruksi');
        $distribusiSurat->tanggalDiteruskan = now();
        $distribusiSurat->status = $status;
        $distribusiSurat->save();

        $suratMasuk = SuratMasuk::find($request->input('idSuratMasuk'));
        $suratMasuk->idPosisiDisposisi = $request->input('idTujuanDisposisi');
        $suratMasuk->status = $status;
        $sifatSurat = $suratMasuk->sifatSurat;
        $nomorSurat = $suratMasuk->nomorSurat;
        $suratMasuk->save();

        $penerima = $suratMasuk = User::find($distribusiSurat->idTujuanDisposisi);

        $job = new ProcessNotifDisposisi(
            $sifatSurat, 
            $nomorSurat, 
            auth()->user()->namaJabatan, 
            $penerima->namaJabatan, 
            $penerima->nama, 
            \Carbon\Carbon::parse($distribusiSurat->tanggalDiteruskan)->format('d/m/Y'), 
            $distribusiSurat->instruksi,
            $penerima->email)
        ;
        dispatch($job);

        

        

        return redirect($redirect)
            ->with('success', "Berhasil Meneruskan Pesan");
    }

    public function lacakDistribusi(SuratMasuk $suratMasuk) {
        $idUser = auth()->user()->id;
        $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $suratMasuk->id)->with(['pengirimDisposisi', 'tujuanDisposisi'])->get();
        $daftarPengirim = [];
        foreach ($distribusiSurat as $ds) {
            array_push($daftarPengirim, $ds->idPengirimDisposisi);
        }

        if ($suratMasuk->idPengirim != $idUser){
            if (! in_array($idUser, $daftarPengirim) && $idUser != 1 && $idUser != 2) {
                abort(403);
            }
        }
        // dd($distribusiSurat);
        return view('surat-masuk.lacak-distribusi', ['title' => 'Disposisi Surat Masuk', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk, 'distribusiSurat' => $distribusiSurat]);
    }

    public function unduhDisposisi(Request $request) {
        // $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $request->input('idSuratMasuk'))->with(['pengirimDisposisi', 'tujuanDisposisi'])->get();
        $suratMasuk = SuratMasuk::where('id', '=', $request->input('idSuratMasuk'))->get()[0];
        // $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $request->input('idSuratMasuk'))->get();
        $distribusiSurat = $suratMasuk->distribusiSurat;
        // dd($distribusiSurat);
        // $daftarPengirim = [];
        // foreach ($distribusiSurat as $ds) {
        //     array_push($daftarPengirim, $ds->idPengirimDisposisi);
        // }
        // $user = User::all()->keyBy('id');

        // $distribusiSurat = $distribusiSurat->map(function($item) use ($user) {
        //     $namaPengirim = isset($user[$item['idPengirimDisposisi']]) ? $user[$item['idPengirimDisposisi']]->namaJabatan : 'Unknown';
        //     $namaPenerima = isset($user[$item['idTujuanDisposisi']]) ? $user[$item['idTujuanDisposisi']]->namaJabatan : 'Unknown';
        
        //     // Mengembalikan item dengan tambahan field namaPengirim dan namaPenerima
        //     return array_merge($item->toArray(), [
        //         'namaPengirim' => $namaPengirim,
        //         'namaPenerima' => $namaPenerima
        //     ]);
        // });
        // dd($distribusiSurat);

        $pdf = Pdf::loadView('surat-masuk.lembar-disposisi', ['suratMasuk' => $suratMasuk, 'distribusiSurat' => $distribusiSurat]);
        $timestamp = now()->timestamp; // Mendapatkan timestamp saat ini
        $dompdfFilePath = storage_path('app/public/uploads/disposisi/disposisi_' . $timestamp . '.pdf');
        file_put_contents($dompdfFilePath, $pdf->output());

        $suratMasukPath = storage_path('app/public/' . $suratMasuk->filePath);
        $uncompressedSuratMasukPath = storage_path('app/public/uploads/disposisi/uncompressed_suratmasuk_' . $timestamp . '.pdf');

        // Coba buka PDF dengan FPDI untuk mendeteksi masalah
        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($suratMasukPath);
            $isProblematic = false;
        } catch (PdfParserException $e) {
            $isProblematic = true;
        }

        $ghostscriptPath = env('GHOSTSCRIPT_PATH');

        if ($isProblematic) {
            $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedSuratMasukPath $suratMasukPath";
            exec($command, $output, $return_var);

            if ($return_var !== 0) {
                unlink($dompdfFilePath);
                return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
            }

            $finalSuratMasukPath = $uncompressedSuratMasukPath;
        } else {
            $finalSuratMasukPath = $suratMasukPath;
        }

        // Menggabungkan PDF menggunakan Webklex\PDFMerger\PDFMerger
        $pdfMerger = PDFMerger::init();
        $pdfMerger->addPDF($dompdfFilePath, 'all');
        $pdfMerger->addPDF($finalSuratMasukPath, 'all');

        $pdfMerger->merge();
        // $pdfMerger->stream();
        $pdfMerger->setFileName('disposisi_suratmasuk_' . $suratMasuk->tahun . '_' . $suratMasuk->index . '.pdf');

        $pdfMerger->download();

        // Hapus file PDF yang dihasilkan oleh DomPDF setelah streaming
        unlink($dompdfFilePath);
        if ($isProblematic) {
            unlink($uncompressedSuratMasukPath);
        }
    }

    public function unduhDisposisi_lama(Request $request) {
        // $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $request->input('idSuratMasuk'))->with(['pengirimDisposisi', 'tujuanDisposisi'])->get();
        $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $request->input('idSuratMasuk'))->get();
        $suratMasuk = SuratMasuk::where('id', '=', $request->input('idSuratMasuk'))->get();
        $daftarPengirim = [];
        foreach ($distribusiSurat as $ds) {
            array_push($daftarPengirim, $ds->idPengirimDisposisi);
        }
        $user = User::all()->keyBy('id');

        $distribusiSurat = $distribusiSurat->map(function($item) use ($user) {
            $namaPengirim = isset($user[$item['idPengirimDisposisi']]) ? $user[$item['idPengirimDisposisi']]->namaJabatan : 'Unknown';
            $namaPenerima = isset($user[$item['idTujuanDisposisi']]) ? $user[$item['idTujuanDisposisi']]->namaJabatan : 'Unknown';
        
            // Mengembalikan item dengan tambahan field namaPengirim dan namaPenerima
            return array_merge($item->toArray(), [
                'namaPengirim' => $namaPengirim,
                'namaPenerima' => $namaPenerima
            ]);
        });
        // dd($distribusiSurat);

        $pdf = Pdf::loadView('surat-masuk.lembar-disposisi', ['suratMasuk' => $suratMasuk[0], 'distribusiSurat' => $distribusiSurat]);
        return $pdf->stream();
    }

    public function rekapSuratMasuk(Request $request) {
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

        return redirect('/surat-masuk/index')
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

    public function rekapSuratMasuk_lama(Request $request) {
        $tanggal = $request->input('bulanRekap');
        $tahun = Carbon::createFromFormat('Y-m', $tanggal)->format('Y');
        $bulan = Carbon::createFromFormat('Y-m', $tanggal)->format('m');
        $suratMasuk = SuratMasuk::whereMonth('tanggalSurat', '=', $bulan)->whereYear('tanggalSurat', '=', $tahun)->get();

        // dd($suratMasuk);

        $zip = new ZipArchive();
        $zipFilePath = storage_path('app/' . 'rekap_suratmasuk_' . $tahun . '_' . $bulan . '.zip') ;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($suratMasuk as $sm) {
                $fileToAdd = storage_path('app/public/' . $sm->filePath);
                $zip->addFile($fileToAdd, 'suratmasuk_' . $sm->tahun . '_' . $sm->index . '.' . pathinfo($fileToAdd, PATHINFO_EXTENSION));

                // GENERATE DISPOSISI
                $distribusiSurat = DistribusiSurat::where('idSuratMasuk', '=', $sm->id)->get();
                $suratMasuk = SuratMasuk::where('id', '=', $sm->id)->get();
                $daftarPengirim = [];
                foreach ($distribusiSurat as $ds) {
                    array_push($daftarPengirim, $ds->idPengirimDisposisi);
                }
                $user = User::all()->keyBy('id');

                $distribusiSurat = $distribusiSurat->map(function($item) use ($user) {
                    $namaPengirim = isset($user[$item['idPengirimDisposisi']]) ? $user[$item['idPengirimDisposisi']]->namaJabatan : 'Unknown';
                    $namaPenerima = isset($user[$item['idTujuanDisposisi']]) ? $user[$item['idTujuanDisposisi']]->namaJabatan : 'Unknown';
                
                    // Mengembalikan item dengan tambahan field namaPengirim dan namaPenerima
                    return array_merge($item->toArray(), [
                        'namaPengirim' => $namaPengirim,
                        'namaPenerima' => $namaPenerima
                    ]);
                });
                // dd($distribusiSurat);

                $pdf = Pdf::loadView('surat-masuk.lembar-disposisi', ['suratMasuk' => $suratMasuk[0], 'distribusiSurat' => $distribusiSurat]);
                $lembarDisposisi = $pdf->output();

                $zip->addFromString('suratmasuk_' . $sm->tahun . '_' . $sm->index . '_disposisi' . '.' . '.pdf', $lembarDisposisi);
            }
            $zip->close();
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            dd('gagal membuka file zip');
        }
        
    }

    public function laporanPerDireksi() {
        $suratMasuk = SuratMasuk::orderBy('idDireksi', 'asc');
        $suratMasuk->select('idDireksi', SuratMasuk::raw('COUNT(idDireksi) as total_surat'))->groupBy('idDireksi');
        if (request('tanggalAwal')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }
        if (request('tanggalAkhir')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }        
        return view('surat-masuk.laporan-per-direksi', ['title' => 'Surat Masuk Per Direksi', 'active' => 'laporan', 'suratMasuk' => $suratMasuk->get()]);
    }

    // public function nonSekreBelumDiteruskan() {
    //     $suratMasuk = SuratMasuk::where('idPosisiDisposisi', auth()->user()->id)->orderBy('id', 'desc')->get();
    //     return view('surat-masuk.surat-disposisi-belum-diteruskan', ['title' => 'Surat Masuk Belum Diteruskan', 'active' => 'belum diteruskan', 'suratMasuk' => $suratMasuk]);
    // }

    public function nonSekreBelumDiteruskan() {
        $suratMasuk = SuratMasuk::where('idPosisiDisposisi', auth()->user()->id)->with(['direksi', 'userPengirim'])->orderBy('id', 'desc');

        if (request('index')) {
            $suratMasuk = $suratMasuk->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }
        if (request('tanggalAkhir')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }        
        if (request('pengirim')) {
            $suratMasuk = $suratMasuk->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }
        if (request('nomorSurat')) {
            $suratMasuk = $suratMasuk->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }
        if (request('perihal')) {
            $suratMasuk = $suratMasuk->where('perihal', 'like', '%' . request('perihal') . '%');
        }
        if (request('status')) {
            $suratMasuk = $suratMasuk->where('status', 'like', '%' . request('status') . '%');
        }
        return view('surat-masuk.surat-disposisi-belum-diteruskan', ['title' => 'Surat Masuk Belum Diteruskan', 'active' => 'surat masuk', 'suratMasuk' => $suratMasuk->paginate(15)]);
    }

    public function nonSekreDikirim() {
        $suratMasuk = SuratMasuk::where('idPengirim', auth()->user()->id)->with(['direksi', 'userPengirim'])->orderBy('id', 'desc');

        if (request('index')) {
            $suratMasuk = $suratMasuk->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }
        if (request('tanggalAkhir')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }        
        if (request('pengirim')) {
            $suratMasuk = $suratMasuk->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }
        if (request('nomorSurat')) {
            $suratMasuk = $suratMasuk->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }
        if (request('perihal')) {
            $suratMasuk = $suratMasuk->where('perihal', 'like', '%' . request('perihal') . '%');
        }
        
        return view('surat-masuk.surat-disposisi-dikirim', ['title' => 'Surat Masuk Dikirim', 'active' => 'surat keluar', 'suratMasuk' => $suratMasuk->paginate(15)]);
    }

    public function nonSekreSudahDiteruskan() {

        // Old penarikan data
        $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDS;
        $suratMasuk = collect([]);
        foreach ($distribusiSurat as $ds) {
                $suratMasuk->push($ds->suratMasuk);
        }
        $suratMasuk = $suratMasuk->unique('id');
        $suratMasuk = $suratMasuk->sortBy([
            ['tahun', 'desc'],
            ['index', 'desc'],
        ]);
        $suratMasuk = $suratMasuk->where('status', '<>', 'Diarsipkan');
        
        // $idUser = auth()->user()->id;      
        // $suratMasuk = SuratMasuk::join('distribusi_surat', 'surat_masuk.id', '=', 'distribusi_surat.idSuratMasuk')
        // ->where('distribusi_surat.idPengirimDisposisi', $idUser)
        // ->where('surat_masuk.status', '<>', 'Diarsipkan')
        // ->select('surat_masuk.*')
        // ->with(['direksi', 'userPengirim'])
        // ->groupBy('surat_masuk.id')
        // ->orderBy('surat_masuk.tahun', 'DESC')
        // ->orderBy('surat_masuk.id', 'DESC')
        // ->get();
        

        // BEGINNING OF PENCARIAN
        if (request('index')) {
            $suratMasuk = $suratMasuk->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $tanggalAwal = request('tanggalAwal');
            $suratMasuk = $suratMasuk->filter(function ($item) use ($tanggalAwal) {
                return strtotime($item['tanggalSurat']) >= strtotime($tanggalAwal);
            });
        }        
        if (request('tanggalAkhir')) {
            $tanggalAkhir = request('tanggalAkhir');
            $suratMasuk = $suratMasuk->filter(function ($item) use ($tanggalAkhir) {
                return strtotime($item['tanggalSurat']) <= strtotime($tanggalAkhir);
            });
        }
        if (request('pengirim')) {
            $suratMasuk = $suratMasuk->filter(function ($item) {
                return stripos($item['pengirim'], request('pengirim')) !== false;
            });
        }
        if (request('nomorSurat')) {
            $suratMasuk = $suratMasuk->filter(function ($item) {
                return stripos($item['nomorSurat'], request('nomorSurat')) !== false;
            });
        }
        if (request('perihal')) {
            $suratMasuk = $suratMasuk->filter(function ($item) {
                return stripos($item['perihal'], request('perihal')) !== false;
            });
        }
        if (request('status')) {
            $suratMasuk = $suratMasuk->filter(function ($item) {
                return stripos($item['status'], request('status')) !== false;
            });
        }
        // END OF PENCARIAN

        // Make Pagination
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 15;
        $currentPageItems = $suratMasuk->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, $suratMasuk->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('surat-masuk.surat-disposisi-sudah-diteruskan', [
            'title' => 'Surat Masuk Sudah Diteruskan',
            'active' => 'surat masuk',
            'suratMasuk' => $paginatedItems
        ]);
    }

    public function nonSekreSudahDiarsipkan() {
        $distribusiSurat = User::where('id', '=', auth()->user()->id)->get()[0]->mengirimDS;
        $suratMasuk = collect([]);
        foreach ($distribusiSurat as $ds) {
                $suratMasuk->push($ds->suratMasuk);
        }
        $suratMasuk = $suratMasuk->unique('id');
        $suratMasuk = $suratMasuk->sortBy([
            ['tahun', 'desc'],
            ['index', 'desc'],
        ]);
        $suratMasuk = $suratMasuk->where('status', 'Diarsipkan');

        // $idUser = auth()->user()->id;      
        // $suratMasuk = SuratMasuk::join('distribusi_surat', 'surat_masuk.id', '=', 'distribusi_surat.idSuratMasuk')
        // ->where('distribusi_surat.idPengirimDisposisi', $idUser)
        // ->where('surat_masuk.status', 'Diarsipkan')
        // ->select('surat_masuk.*')
        // ->with(['direksi', 'userPengirim'])
        // ->groupBy('surat_masuk.id')
        // ->orderBy('surat_masuk.tahun', 'DESC')
        // ->orderBy('surat_masuk.id', 'DESC')
        // ->get();

        // BEGINNING OF PENCARIAN
        if (request('index')) {
            $suratMasuk = $suratMasuk->where('index', '=', request('index'));
        }
        if (request('tanggalAwal')) {
            $tanggalAwal = request('tanggalAwal');
            $suratMasuk = $suratMasuk->filter(function ($item) use ($tanggalAwal) {
                return strtotime($item['tanggalSurat']) >= strtotime($tanggalAwal);
            });
        }        
        if (request('tanggalAkhir')) {
            $tanggalAkhir = request('tanggalAkhir');
            $suratMasuk = $suratMasuk->filter(function ($item) use ($tanggalAkhir) {
                return strtotime($item['tanggalSurat']) <= strtotime($tanggalAkhir);
            });
        }
        if (request('pengirim')) {
            $suratMasuk = $suratMasuk->filter(function ($item) {
                return stripos($item['pengirim'], request('pengirim')) !== false;
            });
        }
        if (request('nomorSurat')) {
            $suratMasuk = $suratMasuk->filter(function ($item) {
                return stripos($item['nomorSurat'], request('nomorSurat')) !== false;
            });
        }
        if (request('perihal')) {
            $suratMasuk = $suratMasuk->filter(function ($item) {
                return stripos($item['perihal'], request('perihal')) !== false;
            });
        }
        // END OF PENCARIAN

        // make paginasi
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 15;
        $currentPageItems = $suratMasuk->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, $suratMasuk->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('surat-masuk.surat-disposisi-sudah-diarsipkan', [
            'title' => 'Surat Masuk Sudah Diarsipkan',
            'active' => 'surat masuk',
            'suratMasuk' => $paginatedItems
        ]);
    }


    public function arsipkan(Request $request) {
        $request->validate([
            'idTujuanDisposisi' => 'required',
            'idSuratMasuk' => 'required',
            'instruksi' => 'required',
            'idPengirimDisposisi' => 'required',
            'fileLampiranArsip' => 'mimes:pdf,jpg,png|max:5120'
        ]);

        $redirect = "/";
        if (auth()->user()->id == 1) {
            $redirect = "/surat-masuk/index"
                    . '?tanggalAwal=' . urlencode(session('search_tanggalAwal', ''))
                    . '&tanggalAkhir=' . urlencode(session('search_tanggalAkhir', ''))
                    . '&index=' . urlencode(session('search_index', ''))
                    . '&direksi=' . urlencode(session('search_direksi', ''))
                    . '&pengirim=' . urlencode(session('search_pengirim', ''))
                    . '&nomorSurat=' . urlencode(session('search_nomorSurat', ''))
                    . '&perihal=' . urlencode(session('search_perihal', ''))
                    . '&status=' . urlencode(session('search_status', ''))
            ;
        }

        session()->forget('search_tanggalAwal');
        session()->forget('search_tanggalAkhir');
        session()->forget('search_index');
        session()->forget('search_direksi');
        session()->forget('search_pengirim');
        session()->forget('search_nomorSurat');
        session()->forget('search_perihal');
        session()->forget('search_status');

        // START PROCESS file lampiran
        if ($request->file('fileLampiranArsip')) {
            // dd("masuk lampiran");
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

            // akses row surat masuk untuk menyimpan file surat masuk yang sdh digabung dengan lampiran  
            $suratMasuk = SuratMasuk::find($request->input('idSuratMasuk'));
            $suratMasukPath = storage_path('app/public/' . $suratMasuk->filePath); //path surat masuk sebelum digabung

            try { // memeriksa apakah versi pdf bermasalah atau tidak
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($suratMasukPath);
                $isSuratMasukProblematic = false;
            } catch (PdfParserException $e) {
                $isSuratMasukProblematic = true;
            }
            if ($isSuratMasukProblematic) { // jika versi pdf bermasalah, jalankan ghostscript untuk mengganti versi pdf
                $oldSuratMasukPath = $suratMasukPath;
                $ghostscriptPath = env('GHOSTSCRIPT_PATH');
                $uncompressedSuratMasukPath = storage_path('app/public/uploads/lampiran/' . uniqid() . '.pdf'); // path untuk hasil proses yang dilakukan ghostscript
                $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedSuratMasukPath $suratMasukPath";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
                }
                $filesToDelete[] = $uncompressedSuratMasukPath;
                $filesToDelete[] = $oldSuratMasukPath;
                $suratMasukPath = $uncompressedSuratMasukPath; // memakai path hasil ghostscript untuk path surat masuk
            }

            $tahun = Carbon::createFromFormat('Y-m-d', $suratMasuk->tanggalSurat)->format('Y');
            $bulan = Carbon::createFromFormat('Y-m-d', $suratMasuk->tanggalSurat)->format('m');
            $newSuratMasukPath = 'uploads/surat-masuk/' . $tahun . '/' . $bulan . '/' . uniqid() . '.pdf'; // path surat berlampiran yg akan disimpan di database
            $pathPenggabungan = storage_path('app/public/' . $newSuratMasukPath); // path surat untuk keperluan penggabungan
            
            // proses penggabungan surat masuk dengan lampiran
            $pdfMerger = PDFMerger::init();
            $pdfMerger->addPDF($suratMasukPath, 'all');
            $pdfMerger->addPDF($fileLampiranPath, 'all');
            $pdfMerger->merge();
            $pdfMerger->save($pathPenggabungan);

            // simpan path surat masuk yg sdh berlampiran
            $suratMasuk->filePath = $newSuratMasukPath;
            $suratMasuk->save();

            // menghapus file yang tidak lagi terpakai
            $filesToDelete[] = $suratMasukPath;
            foreach ($filesToDelete as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }  
        }

        $suratMasuk = SuratMasuk::find($request->input('idSuratMasuk'));
        $suratMasuk->statusArsip = 1;
        $suratMasuk->idPosisiDisposisi = 1;
        $suratMasuk->status = "Diarsipkan";
        $suratMasuk->save();

        $distribusiSurat = new DistribusiSurat();
        $distribusiSurat->idTujuanDisposisi = $request->input('idTujuanDisposisi');
        $distribusiSurat->idPengirimDisposisi = $request->input('idPengirimDisposisi');
        $distribusiSurat->idSuratMasuk = $request->input('idSuratMasuk');
        $distribusiSurat->instruksi = $request->input('instruksi');
        $distribusiSurat->tanggalDiteruskan = now();
        $distribusiSurat->status = "Diarsipkan";
        $distribusiSurat->save();
        return redirect($redirect)->with('success', 'Berhasil Mengarsipkan Surat');
    }

    public function bukaArsip(Request $request) {
        $distribusiSurat = DistribusiSurat::where("idSuratMasuk", $request->input('idSuratMasuk'))->get();
        $suratMasuk = SuratMasuk::find($request->input('idSuratMasuk'));
        $suratMasuk->statusArsip = 0;
        $suratMasuk->save();
        return redirect('/surat-masuk/disposisi/' . $request->input('idSuratMasuk'));
    }

    public function laporanDistribusiSurat(?string $keterangan = null) {
        $suratMasuk = SuratMasuk::orderBy('id', 'desc');
        $direksi = Direksi::all();
        $judul = "Laporan Surat Masuk";
        $terusan = User::where('id', '<>', 1)->where('id', '<>', 2)->get();

        if ($keterangan == "posisi-terakhir") {
            $suratMasuk->where('statusArsip', '=', 0);
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
                $suratMasuk->where('status', '=', 'Belum Diteruskan');
            } else {
                $suratMasuk->where('idPosisiDisposisi', '=', request('disposisiTerakhir'));
            }
        }

        if (request('statusArsip')) {
            if (request('statusArsip') == "Belum") {
                $suratMasuk = $suratMasuk->where('statusArsip', '=', 0);
            }elseif (request('statusArsip') == "Arsip") {
                $suratMasuk = $suratMasuk->where('statusArsip', '=', 1);
            }
        }

        if (request('tujuanDisposisi')) {
            $distribusiSurat = User::where('id', '=', request('tujuanDisposisi'))->get()[0]->menerimaDS;
            $idSM = collect([]);
            foreach ($distribusiSurat as $ds) {
                $idSM->push($ds->suratMasuk->id);
            }
            $idSM = $idSM->unique();
            $suratMasuk = $suratMasuk->whereIn('id', $idSM);
        }

        if (request('tanggalAwal')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $suratMasuk = $suratMasuk->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }     

        if (request('index')) {
            $suratMasuk->where('id', '=', request('index'));
        }

        if (request('tahun')) {
            $suratMasuk->whereYear('tanggalSurat', request('tahun'));
        }

        if (request('direksi')) {
            $suratMasuk->where('idDireksi', request('direksi'));
        }

        if (request('status')) {
            $suratMasuk->where('status', request('status'));
        }

        if (request('pengirim')) {
            $suratMasuk->where('pengirim', 'like', '%' . request('pengirim') . '%');
        }

        if (request('nomorSurat')) {
            $suratMasuk->where('nomorSurat', 'like', '%' . request('nomorSurat') . '%');
        }

        if (request('perihal')) {
            $suratMasuk->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        return view('surat-masuk.laporan-distribusi-surat', ['title' => $judul, 'active' => 'laporan', 'suratMasuk' => $suratMasuk->paginate(15), 'direksi' => $direksi, 'keterangan' => $keterangan, 'judul' => $judul, 'terusan' => $terusan]);
    }

    public function laporanPerTujuan() {

        // Mendapatkan jumlah surat masuk yang diteruskan ke masing-masing user
        $rekap = DB::table('surat_masuk')
        ->join('distribusi_surat', 'surat_masuk.id', '=', 'distribusi_surat.idSuratMasuk')
        ->join('users', 'distribusi_surat.idTujuanDisposisi', '=', 'users.id')
        ->select('users.namaJabatan', DB::raw('COUNT(DISTINCT surat_masuk.id) as jumlah_surat_masuk'))
        ->where('users.id', '<>', 1)
        ->groupBy('users.namaJabatan')
        ->orderBy('users.id', 'asc');

        if (request('tanggalAwal')) {
            $rekap = $rekap->whereDate('surat_masuk.tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $rekap = $rekap->whereDate('surat_masuk.tanggalSurat', '<=', request('tanggalAkhir'));
        }

        return view('surat-masuk.laporan-per-tujuan', ['title' => 'Surat Masuk Per Tujuan Disposisi', 'active' => 'laporan', 'rekap' => $rekap->get()]);
    }


}