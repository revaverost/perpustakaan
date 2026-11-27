@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-5">
        <h4 class="fw-bold mb-0">Daftar Tagihan Denda</h4>
        <p class="text-muted small mb-0">Kelola denda keterlambatan pengembalian dan kerusakan buku</p>
    </div>
    
    {{-- Filter Status Bayar & Tombol Export --}}
    <div class="col-md-7 text-md-end mt-3 mt-md-0 d-flex flex-wrap justify-content-md-end gap-2">
        <div class="btn-group shadow-sm" role="group" aria-label="Filter Status">
            <a href="{{ route('denda.index', ['status' => 'Belum Lunas']) }}" 
               class="btn btn-outline-primary btn-sm {{ $status === 'Belum Lunas' ? 'active' : '' }}">
                <i class="bi bi-clock-history me-1"></i> Belum Lunas
            </a>
            <a href="{{ route('denda.index', ['status' => 'Lunas']) }}" 
               class="btn btn-outline-success btn-sm {{ $status === 'Lunas' ? 'active' : '' }}">
                <i class="bi bi-check-circle me-1"></i> Lunas
            </a>
            <a href="{{ route('denda.index', ['status' => 'Semua']) }}" 
               class="btn btn-outline-secondary btn-sm {{ $status === 'Semua' ? 'active' : '' }}">
                Semua Data
            </a>
        </div>

        <div>
                  <a href="{{ route('denda.export.pdf', request()->query()) }}" class="btn btn-outline-danger shadow-sm"><i class="bi bi-file-earmark-pdf me-1"></i> Export PDF</a>
            <a href="{{ route('denda.export.csv', request()->query()) }}" class="btn btn-outline-success shadow-sm"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV</a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID Denda</th>
                        <th>Mahasiswa Peminjam</th>
                        <th>Rincian Keterlambatan</th>
                        <th>Keterangan / Alasan</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                        <th>Tanggal Bayar / Metode</th>
                        <th class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($denda as $d)
                        <tr>
                            <td class="ps-3 fw-bold">#{{ $d->id_denda }}</td>
                            <td>
                                <div class="fw-bold">{{ $d->pengembalian->peminjaman->mahasiswa->nama ?? '-' }}</div>
                                <div class="text-muted small">NIM: {{ $d->pengembalian->peminjaman->nim ?? '-' }}</div>
                            </td>
                            <td>
                                @if($d->pengembalian->terlambat_hari > 0)
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        Telat {{ $d->pengembalian->terlambat_hari }} Hari
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        Tepat Waktu
                                    </span>
                                @endif
                                <div class="text-muted small mt-1">
                                    ID Pinjam: #{{ $d->pengembalian->id_peminjaman }}
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ $d->keterangan ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="fw-bold fs-6 text-danger">
                                    Rp {{ number_format($d->jumlah_denda, 0, ',', '.') }}
                                </span>
                                
                                <div class="text-muted small">
                                    Telat: Rp {{ number_format($d->denda_terlambat, 0, ',', '.') }} |
                                    Fisik: Rp {{ number_format($d->denda_fisik, 0, ',', '.') }}
                                </div>
                            </td>
                            <td>
                                @if($d->status_bayar === 'Lunas')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-lg me-1"></i> Lunas
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-exclamation-circle me-1"></i> Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($d->status_bayar === 'Lunas')
                                    <div class="small fw-semibold text-dark">
                                        {{ \Carbon\Carbon::parse($d->tgl_bayar)->format('d/m/Y H:i') }}
                                    </div>
                                    <span class="badge bg-light text-dark border">
                                        {{ $d->metode_bayar }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                           
                        
                            <td class="text-center pe-3">
                                @if($d->status_bayar === 'Belum Lunas')
                                    <a href="{{ route('denda.show', $d->id_denda) }}" class="btn btn-sm btn-success">
                                        <i class="bi bi-cash-stack me-1"></i> Process Bayar
                                    </a>
                                @else
                                    <a href="{{ route('denda.show', $d->id_denda) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="bi bi-cash-coin fs-2 d-block mb-2 text-secondary"></i>
                                Tidak ada catatan denda {{ $status !== 'Semua' ? 'dengan status ' . strtolower($status) : '' }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($denda->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $denda->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection