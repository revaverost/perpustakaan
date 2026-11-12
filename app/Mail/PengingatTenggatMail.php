<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengingatTenggatMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $sisaBuku;

    public function __construct(Peminjaman $peminjaman, $sisaBuku)
    {
        $this->peminjaman = $peminjaman;
        $this->sisaBuku = $sisaBuku;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Jatuh Tempo Besok - SIPERPUS (#' . $this->peminjaman->id_peminjaman . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengingat_tenggat',
        );
    }
}