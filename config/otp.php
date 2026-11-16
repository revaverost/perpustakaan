<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pengaturan OTP Login Petugas (Admin & Pustakawan)
    |--------------------------------------------------------------------------
    |
    | Kode OTP dikirim ke email petugas setelah email + password valid.
    |
    */

    'length' => (int) env('OTP_LENGTH', 6),

    'ttl_minutes' => (int) env('OTP_TTL_MINUTES', 5),

    'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),

    'resend_seconds' => (int) env('OTP_RESEND_SECONDS', 60),

];
