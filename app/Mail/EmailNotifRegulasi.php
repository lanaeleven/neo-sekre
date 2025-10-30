<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailNotifRegulasi extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    var $nama, $perihal;
    public function __construct($nama, $perihal)
    {
        $this->nama = $nama;
        $this->perihal = $perihal;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Regulasi Baru (' . $this->perihal . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.notif-regulasi-baru',
            with: [
                'nama' => $this->nama,
                'perihal' => $this->perihal,
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
