<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginOtpController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    public function show(Request $request)
    {
        $email = $request->session()->get(LoginController::SESSION_EMAIL);

        if (! $email) {
            return redirect()->route('login');
        }

        return view('auth.otp', [
            'email' => $this->maskEmail($email),
            'secondsUntilResend' => $this->otpService->secondsUntilResend($email),
            'expiresAt' => $request->session()->get(LoginController::SESSION_EXPIRES),
        ]);
    }

    private function maskEmail(string $email): string
    {
        [$name, $domain] = explode('@', $email, 2) + ['', ''];

        $visible = substr($name, 0, 2);
        $masked = $visible . str_repeat('*', max(1, strlen($name) - 2));

        return $masked . '@' . $domain;
    }

    public function verify(Request $request)
    {
        $email = $request->session()->get(LoginController::SESSION_EMAIL);

        if (! $email) {
            return redirect()->route('login');
        }

        $length = (int) config('otp.length', 6);

        $request->validate([
            'code' => 'required|digits:' . $length,
        ], [
            'code.digits' => "Kode OTP harus {$length} digit.",
        ]);

        $status = $this->otpService->verify($email, $request->input('code'));

        if ($status !== OtpService::STATUS_OK) {
            return back()->withErrors([
                'code' => $this->statusMessage($status),
            ]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->forgetSession($request);

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun tidak ditemukan.']);
        }

        $remember = (bool) $request->session()->get(LoginController::SESSION_REMEMBER, false);

        Auth::login($user, $remember);
        $request->session()->regenerate();
        $this->forgetSession($request);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Selamat datang, ' . $user->nama . '!');
    }

    public function resend(Request $request)
    {
        $email = $request->session()->get(LoginController::SESSION_EMAIL);

        if (! $email) {
            return redirect()->route('login');
        }

        if (! $this->otpService->canResend($email)) {
            $seconds = $this->otpService->secondsUntilResend($email);

            return back()->withErrors([
                'code' => "Tunggu {$seconds} detik sebelum mengirim ulang kode.",
            ]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->forgetSession($request);

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun tidak ditemukan.']);
        }

        $otp = $this->otpService->issue($user);
        $request->session()->put(
            LoginController::SESSION_EXPIRES,
            $otp->expires_at->toIso8601String()
        );

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }

    private function forgetSession(Request $request): void
    {
        $request->session()->forget([
            LoginController::SESSION_EMAIL,
            LoginController::SESSION_REMEMBER,
            LoginController::SESSION_EXPIRES,
        ]);
    }

    private function statusMessage(string $status): string
    {
        return match ($status) {
            OtpService::STATUS_EXPIRED => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang.',
            OtpService::STATUS_LOCKED => 'Terlalu banyak percobaan. Silakan kirim ulang kode OTP.',
            OtpService::STATUS_NOT_FOUND => 'Kode OTP tidak ditemukan. Silakan kirim ulang.',
            default => 'Kode OTP salah.',
        };
    }
}
