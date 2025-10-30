<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\EmailNotifDisposisi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessNotifDisposisi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $sifatSurat,
            $nomorSurat,
            $pengirim,
            $penerima,
            $nama,
            $tanggal,
            $instruksi,
            $email;

    public function __construct($sifatSurat,
                                $nomorSurat,
                                $pengirim,
                                $penerima,
                                $nama,
                                $tanggal,
                                $instruksi,
                                $email)
    {
        $this->sifatSurat = $sifatSurat;
        $this->nomorSurat = $nomorSurat;
        $this->pengirim = $pengirim;
        $this->penerima = $penerima;
        $this->nama = $nama;
        $this->tanggal = $tanggal;
        $this->instruksi = $instruksi;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
        ->send(new EmailNotifDisposisi(
            $this->sifatSurat,
            $this->nomorSurat,
            $this->pengirim,
            $this->penerima,
            $this->nama,
            $this->tanggal,
            $this->instruksi
        ));
    }
}
