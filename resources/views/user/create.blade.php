@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">Tambah Petugas Baru</div>
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIP (10 Karakter)</label>
                                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" maxlength="10" placeholder="1995031202" required>
                                @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Petugas</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Role Akses</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Pustakawan" {{ old('role') == 'Pustakawan' ? 'selected' : '' }}>Pustakawan</option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Petugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection