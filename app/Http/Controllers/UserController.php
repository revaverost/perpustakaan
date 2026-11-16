<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest('nip')->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'      => 'required|string|size:10|unique:petugas,nip',
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:petugas,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:Admin,Pustakawan',
        ], [
            'nip.required' => 'NIP wajib diisi 10 karakter.',
            'nip.size'     => 'NIP harus pas 10 karakter.',
            'nip.unique'   => 'NIP sudah terdaftar.',
        ]);

        User::create([
            'nip'      => $request->nip,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'User petugas berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => ['required', 'email', Rule::unique('petugas', 'email')->ignore($user->nip, 'nip')],
            'role'     => 'required|in:Admin,Pustakawan',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'nama'  => $request->nama,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User petugas berhasil dihapus.');
    }
}
