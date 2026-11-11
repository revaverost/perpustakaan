@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-0">Katalog Buku</h4>
        <p class="text-muted small mb-0">Kelola inventaris dan ketersediaan stok buku</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('buku.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-journal-plus me-1"></i> Tambah Buku
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Kode Buku</th>
                        <th>Judul Buku</th>
                        <th>Pengarang / Penerbit</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga (Rp)</th>
                        <th>Lokasi Rak</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $b)
                        <tr>
                            <td class="ps-3 fw-bold"><code>{{ $b->kode_buku }}</code></td>
                            <td>
                                <div class="fw-bold">{{ $b->judul }}</div>
                                <small class="text-muted">Tahun {{ $b->tahun_terbit }}</small>
                            </td>
                            <td>
                                <div>{{ $b->pengarang }}</div>
                                <small class="text-muted">{{ $b->penerbit }}</small>
                            </td>
                            <td><span class="badge bg-secondary">{{ $b->kategori }}</span></td>
                            <td>
                                @if($b->stok > 0)
                                    <span class="badge bg-success">{{ $b->stok }} Eksemplar</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ number_format($b->harga, 0, ',', '.') }}</span></td>
                            <td><span class="badge bg-light text-dark border">{{ $b->lokasi_rak }}</span></td>
                            <td class="text-center pe-3">
                                <a href="{{ route('buku.edit', $b->kode_buku) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('buku.destroy', $b->kode_buku) }}" method="POST" class="d-inline form-hapus" data-pesan="Yakin ingin menghapus buku ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada buku terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($buku->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $buku->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
