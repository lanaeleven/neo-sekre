<?php

namespace App\Mail;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotifDisposisi extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    var $sifatSurat, $nomorSurat, $pengirim, $penerima, $nama, $tanggal, $instruksi;
    public function __construct($sifatSurat, $nomorSurat, $pengirim, $penerima, $nama, $tanggal, $instruksi)
    {
        $this->sifatSurat = $sifatSurat;
        $this->nomorSurat = $nomorSurat;
        $this->pengirim = $pengirim;
        $this->penerima = $penerima;
        $this->nama = $nama;
        $this->tanggal = $tanggal;
        $this->instruksi = $instruksi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: Str::upper($this->sifatSurat) . ' - dari ' . $this->pengirim . ' [' . $this->nomorSurat . ']',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.notifdisposisi',
            with: [
                'pengirim' => $this->pengirim, 
                'penerima' => $this->penerima, 
                'nama' => $this->nama,
                'tanggal' => $this->tanggal,
                'instruksi' => $this->instruksi
                ],
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
