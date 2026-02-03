<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailNotifSuratMasukBaru extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    var $nama, $noSurat, $appName, $appUrl;
    public function __construct($nama, $noSurat)
    {
        $this->nama = $nama;
        $this->noSurat = $noSurat;
        $this->appName = config('app.name');
        $this->appUrl = config('app.url');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Surat ' . $this->noSurat . ' sudah masuk ke dalam ' . $this->appName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.notifsuratmasukbaru',
            with: [
                'nama' => $this->nama,
                'noSurat' => $this->noSurat, 
                'appName' => $this->appName, 
                'appUrl' => $this->appUrl, 
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
