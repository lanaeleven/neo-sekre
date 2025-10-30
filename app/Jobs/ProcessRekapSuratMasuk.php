<?php

namespace App\Jobs;

use ZipArchive;
use App\Models\User;
use setasign\Fpdi\Fpdi;
use App\Models\SuratMasuk;
use App\Mail\NotifDownload;
use Illuminate\Bus\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use setasign\Fpdi\PdfParser\PdfParserException;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class ProcessRekapSuratMasuk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

     protected $awal, $akhir;

    public function __construct($awal, $akhir)
    {
        $this->awal = $awal;
        $this->akhir = $akhir;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $rekapSuratMasuk = SuratMasuk::whereDate('tanggalSurat', '>=', $this->awal)->whereDate('tanggalSurat', '<=', $this->akhir)->with(['distribusiSurat'])->get();
        // $user = User::all()->keyBy('id');

        $zip = new ZipArchive();
        $zipFilePath = storage_path('app/' . 'rekap_suratmasuk_dari_' . $this->awal . '_sampai_' . $this->akhir . '.zip');
        $fileName = 'rekap_suratmasuk_dari_' . $this->awal . '_sampai_' . $this->akhir;
        
        // end (setup dengan awal dan akhir)

        if ($rekapSuratMasuk->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada Surat Masuk pada rentang tanggal tersebut');
        }

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($rekapSuratMasuk as $sm) {
                // GENERATE DISPOSISI
                $distribusiSurat = $sm->distribusiSurat;
                $suratMasuk = $sm;
                // $daftarPengirim = [];
                // foreach ($distribusiSurat as $ds) {
                //     array_push($daftarPengirim, $ds->idPengirimDisposisi);
                // }
                

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
                $dompdfFilePath = storage_path('app/public/uploads/disposisi/suratmasuk_' . $sm->tahun . '_' . $sm->index . '_disposisi_' . $timestamp . '.' . '.pdf');
                file_put_contents($dompdfFilePath, $pdf->output());

                $suratMasukPath = storage_path('app/public/' . $sm->filePath);
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
                    // dd($suratMasukPath);
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

                $gabunganPath = storage_path('app/public/uploads/suratmasuk_gabungan_' . $sm->tahun . '_' . $sm->index . '_disposisi_' . $timestamp . '.' . '.pdf');
                $pdfMerger->merge();
                $pdfMerger->save($gabunganPath);

                $zip->addFile($gabunganPath, 'disposisi_suratmasuk_' . $sm->tahun . '_' . $sm->index . '.pdf');

                // Tambahkan file sementara ke daftar file yang akan dihapus
                $filesToDelete[] = $dompdfFilePath;
                $filesToDelete[] = $gabunganPath;
                if ($isProblematic) {
                    $filesToDelete[] = $uncompressedSuratMasukPath;
                }
            }
            $zip->close();

            foreach ($filesToDelete as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }        

            $emailPenerima = env("EMAIL_PENERIMA");

            Mail::to($emailPenerima)->send(new NotifDownload($fileName));

            // return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            dd('gagal membuka file zip');
        }

        
    }
}
