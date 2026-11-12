<?php

namespace App\Mail;

use App\Models\Denda;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPelunasanDendaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $denda;
    public $bukuBermasalah;

    public function __construct(Denda $denda, $bukuBermasalah = null)
    {
        $this->denda = $denda;
        $this->bukuBermasalah = $bukuBermasalah ?? collect();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Pelunasan Denda - SIPERPUS (#' . $this->denda->id_denda . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi_pelunasan_denda',
        );
    }
}