<?php

namespace App\Mail;

use App\Models\JadwalPustakawan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengingatJadwalPustakawan extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JadwalPustakawan $jadwal) {}

    public function build()
    {
        return $this->subject('Pengingat jadwal shift pustakawan hari ini')
            ->view('emails.pengingat-jadwal-pustakawan');
    }
}
