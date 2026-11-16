<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::latest('nim')->paginate(10);
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:15|unique:mahasiswa,nim',
            'nama' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|digits:4|integer',
            'no_hp' => 'nullable|string|max:15',
            'email' => ['required', 'email', Rule::unique('mahasiswa', 'email'), Rule::unique('users', 'email')],
            'password' => 'required|string|min:6|confirmed',
            'status_aktif' => 'required|boolean',
        ], [
            'nim.unique' => 'NIM mahasiswa sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        Mahasiswa::create($request->except('password_confirmation'));

        return redirect()->route('mahasiswa.index')->with('success', 'Anggota mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|digits:4|integer',
            'no_hp' => 'nullable|string|max:15',
            'email' => [
                'required',
                'email',
                Rule::unique('mahasiswa', 'email')->ignore($mahasiswa->nim, 'nim'),
                Rule::unique('users', 'email'),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'status_aktif' => 'required|boolean',
        ], [
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = $request->except('password_confirmation');

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Data anggota mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
