<?php

namespace App\Jobs;

use App\Mail\EmailNotifUndanganBaru;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessNotifUndanganBaru implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $email, $nama, $judul;

    public function __construct($email, $nama, $judul)
    {
        $this->email = $email;
        $this->nama = $nama;
        $this->judul = $judul;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new EmailNotifUndanganBaru(
                $this->nama,
                $this->judul
            ));
    }
}
