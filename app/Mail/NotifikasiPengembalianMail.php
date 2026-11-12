<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPengembalianMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $daftarBukuKembali;
    public $denda;
    public $sisaBukuBelumKembali;

    public function __construct(Peminjaman $peminjaman, $daftarBukuKembali, $denda = null, $sisaBukuBelumKembali = null)
    {
        $this->peminjaman = $peminjaman;
        $this->daftarBukuKembali = $daftarBukuKembali;
        $this->denda = $denda;
        $this->sisaBukuBelumKembali = $sisaBukuBelumKembali ?? collect();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Pengembalian Buku - SIPERPUS (#' . $this->peminjaman->id_peminjaman . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi_pengembalian',
        );
    }
}