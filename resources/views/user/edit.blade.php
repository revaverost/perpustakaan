@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark fw-bold">Edit Petugas [{{ $user->nip }}]</div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->nip) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIP (Primary Key)</label>
                                <input type="text" class="form-control" value="{{ $user->nip }}" disabled readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Petugas</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Role Akses</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Pustakawan" {{ old('role', $user->role) == 'Pustakawan' ? 'selected' : '' }}>Pustakawan</option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password Baru <small class="text-muted font-weight-normal">(Kosongkan jika tidak ingin mengganti password)</small></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isi hanya jika ingin memperbarui password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning px-4">Perbarui Petugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection