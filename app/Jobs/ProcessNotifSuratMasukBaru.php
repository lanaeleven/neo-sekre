<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotifSuratMasukBaru;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessNotifSuratMasukBaru implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email, $nama, $noSurat;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $nama, $noSurat)
    {
        $this->email = $email;
        $this->nama = $nama;
        $this->noSurat = $noSurat;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
        ->send(new EmailNotifSuratMasukBaru(
            $this->nama,
            $this->noSurat
        ));
    }
}
