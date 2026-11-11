<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengingatPengembalian extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Peminjaman $peminjaman) {}

    public function build()
    {
        return $this->subject('Pengingat pengembalian buku besok')
            ->view('emails.pengingat-pengembalian');
    }
}
