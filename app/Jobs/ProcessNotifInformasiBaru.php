<?php

namespace App\Jobs;

use App\Mail\EmailNotifInformasiBaru;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessNotifInformasiBaru implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $email, $nama, $jenisInformasi, $judul;

    public function __construct($email, $nama, $jenisInformasi, $judul)
    {
        $this->email = $email;
        $this->nama = $nama;
        $this->jenisInformasi = $jenisInformasi;
        $this->judul = $judul;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new EmailNotifInformasiBaru(
                $this->nama,
                $this->jenisInformasi,
                $this->judul
            ));
    }
}
