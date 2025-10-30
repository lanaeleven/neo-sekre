<?php

namespace App\Jobs;

use ZipArchive;
use App\Mail\NotifDownload;
use App\Models\SuratKeluar;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessRekapSuratKeluar implements ShouldQueue
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
        // $suratKeluar = SuratKeluar::whereMonth('tanggalSurat', '=', $this->bulan)->whereYear('tanggalSurat', '=', $this->tahun)->get();
        $suratKeluar = SuratKeluar::whereDate('tanggalSurat', '>=', $this->awal)->whereDate('tanggalSurat', '<=', $this->akhir)->get();

        $fileName = 'rekap_suratkeluar_dari_' . $this->awal . '_sampai_' . $this->akhir;
        $zip = new ZipArchive();
        $zipFilePath = storage_path('app/' . $fileName . '.zip') ;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($suratKeluar as $sk) {
                $fileToAdd = storage_path('app/public/' . $sk->filePath);
                $zip->addFile($fileToAdd, 'suratkeluar_' . $sk->tahun . '_' . $sk->index . '.' . pathinfo($fileToAdd, PATHINFO_EXTENSION));
            }
            $zip->close();
            Mail::to('akunlana11@gmail.com')->send(new NotifDownload($fileName));
            // return response()->download($zipFilePath)->deleteFileAfterSend(true);

            // Misal simpan ke session (bisa juga ke database)
        // session()->put('zip_ready', true);
        // session()->put('zip_file', 'rekap_suratkeluar_' . $this->tahun . '_' . $this->bulan . '.zip');
        } else {
            dd('gagal membuka file zip');
        }
    }
}
