@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-0">Daftar Transaksi Peminjaman</h4>
        <p class="text-muted small mb-0">Kelola dan pantau peminjaman buku mahasiswa</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('peminjaman.export.pdf', request()->query()) }}" class="btn btn-outline-danger shadow-sm"><i class="bi bi-file-earmark-pdf me-1"></i> Export PDF</a>
            <a href="{{ route('peminjaman.export.csv', request()->query()) }}" class="btn btn-outline-success shadow-sm"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV</a>
        </div>
        @if(Auth::user()->role !== 'Admin')
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Transaksi Peminjaman Baru
        </a>
        @endif
    </div>
</div>

<form method="GET" action="{{ route('peminjaman.index') }}" class="card border-0 shadow-sm mb-3">
    <div class="card-body row g-2 align-items-end">
        <div class="col-md-4"><label class="form-label small fw-bold">Tanggal mulai</label><input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control"></div>
        <div class="col-md-4"><label class="form-label small fw-bold">Tanggal akhir</label><input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control"></div>
        <div class="col-md-4"><button class="btn btn-primary me-1"><i class="bi bi-filter me-1"></i> Filter</button><a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Reset</a></div>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Mahasiswa</th>
                        <th>Buku Dipinjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Tenggat</th>
                        <th>Petugas (NIP)</th>
                        <th>Status</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $p)
                        <tr>
                            <td class="ps-3 fw-bold">#{{ $p->id_peminjaman }}</td>
                            <td>
                                <div class="fw-bold">{{ $p->mahasiswa->nama ?? '-' }}</div>
                                <div class="text-muted small">NIM: {{ $p->nim }}</div>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                    @foreach($p->detailPeminjaman as $detail)
                                        <li>
                                            <i class="bi bi-book me-1 text-primary"></i> 
                                            {{ $detail->buku->judul ?? $detail->kode_buku }} 
                                            <span class="badge bg-secondary ms-1">x{{ $detail->jumlah }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                            <td>
                                <span class="{{ \Carbon\Carbon::parse($p->tgl_tenggat)->isPast() && $p->status === 'Dipinjam' ? 'text-danger fw-bold' : '' }}">
                                    {{ \Carbon\Carbon::parse($p->tgl_tenggat)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $p->user->nama ?? $p->nip }}</small>
                            </td>
                            <td>
                                @if($p->status === 'Dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif

                                @if($p->jumlah_perpanjang > 0)
                                    <br><span class="badge bg-info text-dark" style="font-size: 0.7rem;">
                                        <i class="bi bi-clock-history"></i> Diperpanjang {{ $p->jumlah_perpanjang }}x
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-3">
                                @if($p->status === 'Dipinjam')
                                        <div class="btn-group">
                                            <a href="{{ route('pengembalian.create', $p->id_peminjaman) }}" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-box-arrow-in-down-left me-1"></i> Kembalikan
                                            </a>
                                            <form action="{{ route('peminjaman.perpanjang', $p->id_peminjaman) }}" method="POST" class="d-inline form-konfirmasi" data-pesan="Perpanjang masa pinjam 7 hari?" data-aksi="Perpanjang">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-clock-history"></i> Perpanjang
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted small"><i class="bi bi-check-circle-fill text-success"></i> Tuntas</span>
                                    @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada transaksi peminjaman buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($peminjaman->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $peminjaman->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
