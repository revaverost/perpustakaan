@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h4 class="fw-bold mb-0">Detail Peminjaman #{{ $peminjaman->id_peminjaman }}</h4>
        <p class="text-muted small mb-0">Rincian buku, status, dan pengembalian transaksi</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <span class="fw-bold"><i class="bi bi-book me-1 text-primary"></i> Buku yang Dipinjam</span>
                @if($peminjaman->status === 'Dipinjam')
                    <span class="badge bg-warning text-dark">Dipinjam</span>
                @else
                    <span class="badge bg-success">Selesai</span>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Kode</th>
                                <th>Judul</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end pe-3">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman->detailPeminjaman as $detail)
                                <tr>
                                    <td class="ps-3"><code>{{ $detail->kode_buku }}</code></td>
                                    <td>{{ $detail->buku->judul ?? '-' }}</td>
                                    <td class="text-center">x{{ $detail->jumlah }}</td>
                                    <td class="text-end pe-3">
                                        Rp {{ number_format($detail->buku->harga ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Tidak ada detail buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold py-3"><i class="bi bi-person me-1 text-primary"></i> Informasi Transaksi</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted" width="45%">Mahasiswa</td>
                        <td class="fw-bold">{{ $peminjaman->mahasiswa->nama ?? '-' }} ({{ $peminjaman->nim }})</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Petugas</td>
                        <td>{{ $peminjaman->user->nama ?? $peminjaman->nip }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Pinjam</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Tenggat</td>
                        <td class="{{ \Carbon\Carbon::parse($peminjaman->tgl_tenggat)->isPast() && $peminjaman->status === 'Dipinjam' ? 'text-danger fw-bold' : '' }}">
                            {{ \Carbon\Carbon::parse($peminjaman->tgl_tenggat)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Perpanjangan</td>
                        <td>{{ $peminjaman->jumlah_perpanjang }}x</td>
                    </tr>
                </table>

                @if($peminjaman->status === 'Dipinjam' && Auth::user()->role === 'Pustakawan')
                    <hr>
                    <div class="d-flex gap-2">
                        <a href="{{ route('pengembalian.create', $peminjaman->id_peminjaman) }}" class="btn btn-success flex-fill">
                            <i class="bi bi-box-arrow-in-down-left me-1"></i> Kembalikan
                        </a>
                        <form action="{{ route('peminjaman.perpanjang', $peminjaman->id_peminjaman) }}" method="POST" class="flex-fill form-konfirmasi" data-pesan="Perpanjang masa pinjam 7 hari?" data-aksi="Perpanjang">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bi bi-clock-history me-1"></i> Perpanjang
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        @if($peminjaman->pengembalian)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3"><i class="bi bi-journal-check me-1 text-success"></i> Data Pengembalian</div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td class="text-muted" width="45%">Tanggal Kembali</td>
                            <td class="fw-bold">{{ \Carbon\Carbon::parse($peminjaman->pengembalian->tgl_kembali)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Keterlambatan</td>
                            <td>
                                @if($peminjaman->pengembalian->terlambat_hari > 0)
                                    <span class="badge bg-danger">{{ $peminjaman->pengembalian->terlambat_hari }} hari</span>
                                @else
                                    <span class="badge bg-success">Tepat waktu</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Denda</td>
                            <td>
                                @if($peminjaman->pengembalian->denda)
                                    <a href="{{ route('denda.show', $peminjaman->pengembalian->denda->id_denda) }}" class="fw-bold text-danger text-decoration-none">
                                        Rp {{ number_format($peminjaman->pengembalian->denda->jumlah_denda, 0, ',', '.') }}
                                        ({{ $peminjaman->pengembalian->denda->status_bayar }})
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada denda</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>
                    <div class="small">
                        <div class="fw-bold mb-2">Kondisi Fisik Buku</div>
                        <ul class="list-unstyled mb-0">
                            @foreach($peminjaman->pengembalian->kondisiBukuKembali as $kondisi)
                                <li class="mb-1">
                                    <code>[{{ $kondisi->kode_buku }}]</code> {{ $kondisi->buku->judul ?? '-' }}
                                    <span class="badge {{ $kondisi->kondisi === 'Baik' ? 'bg-info text-dark' : 'bg-warning text-dark' }}">{{ $kondisi->kondisi }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
