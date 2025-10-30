<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Spo;
use App\Models\Direksi;
use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\PdfParserException;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class SpoController extends Controller
{
    public function create()
    {

        $spo = Spo::orderBy('tahun', 'desc')->orderBy('index', 'desc');
        $direksi = Direksi::all();
        $judul = "Standar Prosedur Operasional";

        if (request('index')) {
            $spo->where('index', '=', request('index'));
        }

        if (request('tanggalAwal')) {
            $spo = $spo->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $spo = $spo->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        if (request('direksi')) {
            $spo->where('idDireksi', request('direksi'));
        }

        if (request('tujuan')) {
            $spo->where('tujuan', 'like', '%' . request('tujuan') . '%');
        }

        if (request('perihal')) {
            $spo->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        if (request('keterangan')) {
            $spo->where('keterangan', 'like', '%' . request('keterangan') . '%');
        }

        if (request('tahun')) {
            $spo->where('tahun', request('tahun'));
        }

        return view('spo.index', ['title' =>  $judul, 'active' => 'spo', 'spo' => $spo->with('direksi')->paginate(15), 'direksi' => $direksi, 'judul' => $judul]);
    }

    public function listSpoNs()
    {
        $userUnitIds = auth()->user()->units->pluck('id');

        $spo = Spo::whereHas('units', function ($query) use ($userUnitIds) {
            $query->whereIn('unit.id', $userUnitIds);
        });

        $direksi = Direksi::all();
        $judul = "Standar Prosedur Operasional";

        if (request('index')) {
            $spo->where('index', '=', request('index'));
        }

        if (request('tanggalAwal')) {
            $spo = $spo->whereDate('tanggalSurat', '>=', request('tanggalAwal'));
        }

        if (request('tanggalAkhir')) {
            $spo = $spo->whereDate('tanggalSurat', '<=', request('tanggalAkhir'));
        }

        if (request('tujuan')) {
            $spo->where('tujuan', 'like', '%' . request('tujuan') . '%');
        }

        if (request('perihal')) {
            $spo->where('perihal', 'like', '%' . request('perihal') . '%');
        }

        if (request('keterangan')) {
            $spo->where('keterangan', 'like', '%' . request('keterangan') . '%');
        }

        return view('spo.index-ns', ['title' =>  $judul, 'active' => 'spo', 'spo' => $spo->with('direksi')->orderBy('tahun', 'desc')->orderBy('index', 'desc')->paginate(15), 'direksi' => $direksi, 'judul' => $judul]);
    }

    public function tambah()
    {
        $direksi = Direksi::all();
        $units = Unit::all();

        return view('spo.tambah', ['title' => 'Tambah Surat Prosedur Operasional', 'active' => 'spo', 'direksi' => $direksi, 'units' => $units]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming file. Refuses anything bigger than 5120 kilobyes (=5MB)
        $request->validate([
            'tanggalSurat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'direksi' => 'required',
            'units' => 'required|array',
            'fileSurat' => 'required|mimes:pdf|max:5120'
        ]);

        $tahun = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');
        // Get the maximum id for the given year
        $maxIndex = Spo::where('tahun', $tahun)->max('index');
        // Determine the new id for the given year
        $newIndex = $maxIndex ? $maxIndex + 1 : 1;

        // Store the file in storage\app\public folder
        $file = $request->file('fileSurat');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('uploads/spo/' . $tahun . '/' . $bulan, 'public');


        // Store file information in the database
        $spo = new Spo();
        $spo->index = $newIndex;
        $spo->tahun = $tahun;
        $spo->idDireksi = $request->input('direksi');
        $spo->tanggalSurat = $request->input('tanggalSurat');
        $spo->tujuan = $request->input('tujuan');
        $spo->perihal = $request->input('perihal');
        $spo->keterangan = $request->input('keterangan');
        $spo->fileName = $fileName;
        $spo->filePath = $filePath;
        $spo->save();

        $spo->units()->attach($request->input('units'));

        // Redirect back to the index page with a success message
        return redirect('/spo/index?tahun=' . config('app.tahun'))
            ->with('success', 'Berhasil Menambahkan Standar Prosedur Operasional');
    }

    public function edit(Spo $spo)
    {
        $direksi = Direksi::all();
        $spo = SPO::with('units')->findOrFail($spo->id);
        $units = Unit::all();

        return view('spo.edit', ['title' => 'Edit Standar Prosedur Operasional', 'active' => 'spo', 'spo' => $spo, 'direksi' => $direksi, 'units' => $units]);
    }

    public function save(Request $request): RedirectResponse
    {
        // Validate the incoming file. Refuses anything bigger than 2048 kilobyes (=2MB)
        $request->validate([
            'id' => 'required',
            'tanggalSurat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'direksi' => 'required',
            'fileSurat' => 'mimes:pdf|max:5120',
            'units' => 'required|array',
            'revisi' => 'mimes:pdf|max:5120'
        ]);
        

        $tahunInput = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('Y');
        $bulan = Carbon::createFromFormat('Y-m-d', $request->input('tanggalSurat'))->format('m');

        if ($request->file('fileSurat')) {
            // Store the file in storage\app\public folder
            $file = $request->file('fileSurat');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('uploads/spo/' . $tahunInput . '/' . $bulan, 'public');
        }

        // START PROCESS file lampiran
        if ($request->file('revisi')) {
            $filesToDelete = [];
            $mimeType = $request->file('revisi')->getMimeType();
            if (strpos($mimeType, 'image') !== false) { // jika input user berupa image, maka convert image to pdf
                $imageContent = file_get_contents($request->file('revisi')->getRealPath());
                $data = [
                    'imageContent' => $imageContent,
                ];
                $pdf = PDF::loadView('pdf.image-to-pdf', $data);
                $uploadImagePdfPath = 'public/uploads/revisi/' . uniqid() . '.pdf'; // path untuk menyimpan file lampiran yg img-to-pdf
                Storage::put($uploadImagePdfPath, $pdf->output());
                $revisiPath = storage_path('app/' . $uploadImagePdfPath); // path sementara untuk file lampiran
                $filesToDelete[] = $revisiPath;
            } else { // jika input user berupa pdf
                $revisiPath = storage_path('app/public/' . $request->file('revisi')->store('uploads/revisi', 'public')); // path sementara untuk file lampiran
                $filesToDelete[] = $revisiPath;
            }
            try { // memeriksa apakah versi pdf bermasalah atau tidak
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($revisiPath);
                $isProblematic = false;
            } catch (PdfParserException $e) {
                $isProblematic = true;
            }
            if ($isProblematic) { // jika versi pdf bermasalah, jalankan ghostscript untuk mengganti versi pdf
                $ghostscriptPath = env('GHOSTSCRIPT_PATH');
                $uncompressedRevisiPath = storage_path('app/public/uploads/revisi/' . uniqid() . '.pdf'); // path untuk hasil proses yang dilakukan ghostscript
                $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedRevisiPath $revisiPath";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
                }
                $revisiPath = $uncompressedRevisiPath; // memakai path hasil ghostscript untuk path file lampiran
                $filesToDelete[] = $revisiPath;
            }

            // akses row surat masuk untuk menyimpan file surat masuk yang sdh digabung dengan lampiran  
            $spo = SPO::find($request->input('id'));
            $spoPath = storage_path('app/public/' . $spo->filePath); //path surat masuk sebelum digabung

            try { // memeriksa apakah versi pdf bermasalah atau tidak
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($spoPath);
                $isSpoProblematic = false;
            } catch (PdfParserException $e) {
                $isSpoProblematic = true;
            }
            if ($isSpoProblematic) { // jika versi pdf bermasalah, jalankan ghostscript untuk mengganti versi pdf
                $oldSpoPath = $spoPath;
                $ghostscriptPath = env('GHOSTSCRIPT_PATH');
                $uncompressedSpoPath = storage_path('app/public/uploads/revisi/' . uniqid() . '.pdf'); // path untuk hasil proses yang dilakukan ghostscript
                $command = "$ghostscriptPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$uncompressedSpoPath $spoPath";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    return redirect()->back()->with('error', 'Failed to process PDF with Ghostscript.');
                }
                $filesToDelete[] = $uncompressedSpoPath;
                $filesToDelete[] = $oldSpoPath;
                $spoPath = $uncompressedSpoPath; // memakai path hasil ghostscript untuk path surat masuk
            }

            $tahun = Carbon::createFromFormat('Y-m-d', $spo->tanggalSurat)->format('Y');
            $bulan = Carbon::createFromFormat('Y-m-d', $spo->tanggalSurat)->format('m');
            $newSpoPath = 'uploads/spo/' . $tahun . '/' . $bulan . '/' . uniqid() . '.pdf'; // path surat berlampiran yg akan disimpan di database
            $pathPenggabungan = storage_path('app/public/' . $newSpoPath); // path surat untuk keperluan penggabungan
            
            // proses penggabungan surat masuk dengan lampiran
            $pdfMerger = PDFMerger::init();
            $pdfMerger->addPDF($spoPath, 'all');
            $pdfMerger->addPDF($revisiPath, 'all');
            $pdfMerger->merge();
            $pdfMerger->save($pathPenggabungan);

            // simpan path surat masuk yg sdh berlampiran
            $spo->filePath = $newSpoPath;
            $spo->save();

            // menghapus file yang tidak lagi terpakai
            $filesToDelete[] = $spoPath;
            foreach ($filesToDelete as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }  
        }
        // END PROCESS file lampiran 

        // Store file information in the database
        $spo = Spo::find($request->input('id'));

        $spo->idDireksi = $request->input('direksi');
        $spo->tanggalSurat = $request->input('tanggalSurat');
        $spo->tujuan = $request->input('tujuan');
        $spo->perihal = $request->input('perihal');
        $spo->keterangan = $request->input('keterangan');
        if ($request->file('fileSurat')) {
            $spo->fileName = $fileName;
            $spo->filePath = $filePath;
        }

        if ($tahunInput != $request->input('tahun')) {
            // Get the maximum id for the given year
            $maxIndex = Spo::where('tahun', $tahunInput)->max('index');
            // Determine the new id for the given year
            $newIndex = $maxIndex ? $maxIndex + 1 : 1;

            $spo->tahun = $tahunInput;
            $spo->index = $newIndex;
        }
        $spo->save();

        $spo->units()->sync($request->input('units'));

        // Redirect back to the index page with a success message
        return redirect('/spo/index?tahun=' . config('app.tahun'))
            ->with('success', 'Berhasil Mengedit SPO');
    }

    public function rekapSpo(Request $request)
    {
        $tanggal = $request->input('bulanRekap');
        $tahun = Carbon::createFromFormat('Y-m', $tanggal)->format('Y');
        $bulan = Carbon::createFromFormat('Y-m', $tanggal)->format('m');
        $spo = Spo::whereMonth('tanggalSurat', '=', $bulan)->whereYear('tanggalSurat', '=', $tahun)->get();

        $zip = new ZipArchive();
        $zipFilePath = storage_path('app/' . 'rekap_spo_' . $tahun . '_' . $bulan . '.zip');

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($spo as $s) {
                $fileToAdd = storage_path('app/public/' . $s->filePath);
                $zip->addFile($fileToAdd, 'spo_' . $s->tahun . '_' . $s->index . '.' . pathinfo($fileToAdd, PATHINFO_EXTENSION));
            }
            $zip->close();
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            dd('gagal membuka file zip');
        }
    }
}
