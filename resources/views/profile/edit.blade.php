@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="fw-bold mb-0">Profil Saya</h4>
        <p class="text-muted small mb-0">Kelola informasi akun dan password</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3"><i class="bi bi-person me-1 text-primary"></i> Informasi Akun</div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">NIP</label>
                        <input type="text" class="form-control" value="{{ $user->nip }}" disabled>
                        <div class="form-text">NIP tidak dapat diubah.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <input type="text" class="form-control" value="{{ $user->role }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Profil</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3"><i class="bi bi-shield-lock me-1 text-danger"></i> Ubah Password</div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-bold">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-danger"><i class="bi bi-key me-1"></i> Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
