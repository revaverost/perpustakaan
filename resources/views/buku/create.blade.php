@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">Tambah Buku Baru</div>
                <div class="card-body">
                    <form action="{{ route('buku.store') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kode Buku</label>
                                <input type="text" name="kode_buku" class="form-control @error('kode_buku') is-invalid @enderror" value="{{ old('kode_buku') }}" placeholder="Contoh: BKK-001" required>
                                @error('kode_buku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga Buku (Rp)</label>
                                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', 0) }}" min="0" required>
                                @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Buku</label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pengarang</label>
                                <input type="text" name="pengarang" class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang') }}" required>
                                @error('pengarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') }}" required>
                                @error('penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', date('Y')) }}" required>
                                @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Kategori</label>
                                <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" placeholder="Pemrograman / Sains" required>
                                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Stok Awal</label>
                                <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 1) }}" min="0" required>
                                @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Lokasi Rak</label>
                            <input type="text" name="lokasi_rak" class="form-control @error('lokasi_rak') is-invalid @enderror" value="{{ old('lokasi_rak') }}" placeholder="Rak A-1" required>
                            @error('lokasi_rak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Buku</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection