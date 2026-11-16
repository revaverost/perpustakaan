<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        $data = $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('petugas', 'email')->ignore($user->nip, 'nip')],
        ]);

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|string|min:6|confirmed',
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.confirmed'                => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $request->session()->regenerate();

        return back()->with('success', 'Password berhasil diubah.');
    }
}