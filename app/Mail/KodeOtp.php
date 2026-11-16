<?php

namespace App\Mail;

use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KodeOtp extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nama,
        public string $kode,
        public CarbonInterface $expiresAt
    ) {}

    public function build()
    {
        return $this->subject('Kode OTP Login SIPERPUS')
            ->view('emails.kode-otp');
    }
}
