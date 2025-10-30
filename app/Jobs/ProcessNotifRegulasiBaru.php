<?php

namespace App\Jobs;

use App\Mail\EmailNotifRegulasi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessNotifRegulasiBaru implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email, $nama, $perihal;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $nama, $perihal)
    {
        $this->email = $email;
        $this->nama = $nama;
        $this->perihal = $perihal;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new EmailNotifRegulasi(
                $this->nama,
                $this->perihal
            ));
    }
}
