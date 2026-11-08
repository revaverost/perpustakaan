@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-0">Data Mahasiswa / Anggota</h4>
        <p class="text-muted small mb-0">Kelola informasi anggota perpustakaan</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-add me-1"></i> Tambah Mahasiswa
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Jurusan / Angkatan</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswa as $m)
                        <tr>
                            <td class="ps-3 fw-bold"><code>{{ $m->nim }}</code></td>
                            <td>{{ $m->nama }}</td>
                            <td>
                                <div>{{ $m->jurusan }}</div>
                                <small class="text-muted">Angkatan {{ $m->angkatan }}</small>
                            </td>
                            <td>
                                <div>{{ $m->email }}</div>
                                <small class="text-muted">{{ $m->no_hp ?? '-' }}</small>
                            </td>
                            <td>
                                @if($m->status_aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="text-center pe-3">
                                <a href="{{ route('mahasiswa.edit', $m->nim) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('mahasiswa.destroy', $m->nim) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($mahasiswa->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $mahasiswa->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection