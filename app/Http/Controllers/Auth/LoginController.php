<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public const SESSION_EMAIL = 'staff_otp_email';
    public const SESSION_REMEMBER = 'staff_otp_remember';
    public const SESSION_EXPIRES = 'staff_otp_expires_at';

    public function __construct(private OtpService $otpService) {}

    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memvalidasi email + password, lalu mengirim OTP tanpa login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->onlyInput('email');
        }

        $otp = $this->otpService->issue($user);

        $request->session()->regenerate();
        $request->session()->put([
            self::SESSION_EMAIL => $user->email,
            self::SESSION_REMEMBER => $request->boolean('remember'),
            self::SESSION_EXPIRES => $otp->expires_at->toIso8601String(),
        ]);

        return redirect()->route('login.otp')
            ->with('info', 'Kode OTP telah dikirim ke ' . $this->maskEmail($user->email) . '.');
    }

    /**
     * Memproses Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    private function maskEmail(string $email): string
    {
        [$name, $domain] = explode('@', $email, 2) + ['', ''];

        $visible = substr($name, 0, 2);

        return $visible . str_repeat('*', max(1, strlen($name) - 2)) . '@' . $domain;
    }
}
