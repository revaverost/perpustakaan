<?php

namespace App\Services;

use App\Mail\KodeOtp;
use App\Models\LoginOtp;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public const STATUS_OK = 'ok';
    public const STATUS_INVALID = 'invalid';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_LOCKED = 'locked';
    public const STATUS_NOT_FOUND = 'not_found';

    /**
     * Membuat OTP baru, membatalkan OTP lama, lalu mengirimnya via email.
     */
    public function issue(User $user): LoginOtp
    {
        LoginOtp::where('expires_at', '<', now()->subDay())->delete();
        $this->invalidatePending($user->email);

        $length = max(4, (int) config('otp.length', 6));
        $minimum = (int) pow(10, $length - 1);
        $maximum = (int) pow(10, $length) - 1;
        $code = (string) random_int($minimum, $maximum);

        $otp = LoginOtp::create([
            'nip' => $user->nip,
            'email' => $user->email,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes((int) config('otp.ttl_minutes', 5)),
            'ip_address' => request()->ip(),
        ]);

        Mail::to($user->email)->send(new KodeOtp(
            $user->nama,
            $code,
            $otp->expires_at
        ));

        return $otp;
    }

    /**
     * Memverifikasi kode OTP terbaru milik email tersebut.
     */
    public function verify(string $email, string $code): string
    {
        return DB::transaction(function () use ($email, $code) {
            $otp = LoginOtp::where('email', $email)
                ->whereNull('consumed_at')
                ->latest('id')
                ->lockForUpdate()
                ->first();

            if (! $otp) {
                return self::STATUS_NOT_FOUND;
            }

            if ($otp->isExpired()) {
                $otp->update(['consumed_at' => now()]);

                return self::STATUS_EXPIRED;
            }

            $maxAttempts = (int) config('otp.max_attempts', 5);

            if ($otp->attempts >= $maxAttempts) {
                return self::STATUS_LOCKED;
            }

            if (! Hash::check($code, $otp->code_hash)) {
                $otp->attempts = $otp->attempts + 1;
                $otp->save();

                return $otp->attempts >= $maxAttempts
                    ? self::STATUS_LOCKED
                    : self::STATUS_INVALID;
            }

            $otp->update(['consumed_at' => now()]);

            return self::STATUS_OK;
        });
    }

    /**
     * Apakah OTP baru boleh dikirim ulang (cooldown).
     */
    public function canResend(string $email): bool
    {
        return $this->secondsUntilResend($email) <= 0;
    }

    /**
     * Sisa detik sebelum tombol kirim ulang aktif.
     */
    public function secondsUntilResend(string $email): int
    {
        $latest = LoginOtp::where('email', $email)
            ->latest('id')
            ->first();

        if (! $latest) {
            return 0;
        }

        $availableAt = $latest->created_at->copy()->addSeconds(
            (int) config('otp.resend_seconds', 60)
        );

        return max(0, now()->diffInSeconds($availableAt, false));
    }

    /**
     * Batalkan semua OTP yang belum dipakai untuk email tersebut.
     */
    public function invalidatePending(string $email): void
    {
        LoginOtp::where('email', $email)
            ->whereNull('consumed_at')
            ->update(['consumed_at' => now()]);
    }
}
