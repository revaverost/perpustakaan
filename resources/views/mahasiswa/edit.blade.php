@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark fw-bold">Edit Mahasiswa [{{ $mahasiswa->nim }}]</div>
                <div class="card-body">
                    <form action="{{ route('mahasiswa.update', $mahasiswa->nim) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIM (Primary Key)</label>
                                <input type="text" class="form-control" value="{{ $mahasiswa->nim }}" disabled readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mahasiswa->nama) }}" placeholder="Nama lengkap anggota" required>
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Jurusan / Program Studi</label>
                                <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" value="{{ old('jurusan', $mahasiswa->jurusan) }}" required>
                                @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Angkatan</label>
                                <input type="number" name="angkatan" class="form-control @error('angkatan') is-invalid @enderror" value="{{ old('angkatan', $mahasiswa->angkatan) }}" min="2000" max="{{ date('Y') + 1 }}" placeholder="{{ date('Y') }}" required>
                                @error('angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $mahasiswa->email) }}" placeholder="nama@kampus.ac.id" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">No. HP / WhatsApp</label>
                                <input type="tel" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $mahasiswa->no_hp) }}" placeholder="08xxxxxxxxxx">
                                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Keanggotaan</label>
                            <select name="status_aktif" class="form-select @error('status_aktif') is-invalid @enderror" required>
                                <option value="1" {{ old('status_aktif', $mahasiswa->status_aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status_aktif', $mahasiswa->status_aktif) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status_aktif')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-between form-actions">
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning px-4">Perbarui Mahasiswa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
