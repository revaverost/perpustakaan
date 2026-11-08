<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses autentikasi NIP dan Password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required|string|size:10',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['nip' => $credentials['nip'], 'password' => $credentials['password']], $request->remember)) {
            $request->session()->regenerate();

            // Redirect eksplisit ke peminjaman.index
            return redirect()->route('peminjaman.index')
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->nama . '!');
        }

        return back()->withErrors([
            'nip' => 'NIP atau password yang Anda masukkan salah.',
        ])->onlyInput('nip');
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
}
