<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailNotifInformasiBaru extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    var $nama, $jenisInformasi, $judul;
    public function __construct($nama, $jenisInformasi, $judul)
    {
        $this->nama = $nama;
        $this->jenisInformasi = $jenisInformasi;
        $this->judul = $judul;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->jenisInformasi . ' Baru (' . $this->judul . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.notif-informasi-baru',
            with: [
                'nama' => $this->nama,
                'jenisInformasi' => $this->jenisInformasi,
                'judul' => $this->judul,
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
