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
    var $nama, $noSurat;
    public function __construct($nama, $noSurat)
    {
        $this->nama = $nama;
        $this->noSurat = $noSurat;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Surat ' . $this->noSurat . ' sudah masuk ke dalam E-Disposisi',
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
                'noSurat' => $this->noSurat
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
