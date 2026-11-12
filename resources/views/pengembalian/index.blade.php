@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-0">Riwayat Pengembalian Buku</h4>
        <p class="text-muted small mb-0">Catatan pengembalian buku dan status keterlambatan</p>
    </div>
    <div class="col-md-6 text-md-end mt-2 mt-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('pengembalian.export.pdf', request()->query()) }}" class="btn btn-outline-danger shadow-sm"><i class="bi bi-file-earmark-pdf me-1"></i> Export PDF</a>
            <a href="{{ route('pengembalian.export.csv', request()->query()) }}" class="btn btn-outline-success shadow-sm"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV</a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID Kembali</th>
                        <th>ID Pinjam</th>
                        <th>Peminjam</th>
                        <th>Tgl Kembali</th>
                        <th>Keterlambatan</th>
                        <th>Kondisi Fisik</th>
                        <th>Penerima (Petugas)</th>
                        <th class="text-end pe-3">Denda Keterlambatan/Fisik</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalian as $k)
                        <tr>
                            <td class="ps-3 fw-bold">#{{ $k->id_pengembalian }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">#{{ $k->id_peminjaman }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $k->peminjaman->mahasiswa->nama ?? '-' }}</div>
                                <div class="text-muted small">NIM: {{ $k->peminjaman->nim ?? '-' }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($k->tgl_kembali)->format('d/m/Y') }}</td>
                            <td>
                                @if($k->terlambat_hari > 0)
                                    <span class="badge bg-danger">Telat {{ $k->terlambat_hari }} Hari</span>
                                @else
                                    <span class="badge bg-success">Tepat Waktu</span>
                                @endif
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                        <code>[{{ $k->kode_buku }}]</code> {{ $k->buku->judul ?? '' }}:
                                        <span class="badge {{ $k->kondisi === 'Baik' ? 'bg-info text-dark' : 'bg-warning text-dark' }}">
                                            {{ $k->kondisi }}
                                        </span>
                                </ul>
                            </td>
                            <td>
                                <small class="text-muted">{{ $k->user->nama ?? $k->nip }}</small>
                            </td>
                            <td class="text-end pe-3">
                                @if($k->denda)
                                    <div class="fw-bold text-danger">
                                        Rp {{ number_format($k->denda->jumlah_denda, 0, ',', '.') }}
                                    </div>
                                    <a href="{{ route('denda.show', $k->denda->id_denda) }}" class="badge text-decoration-none {{ $k->denda->status_bayar === 'Lunas' ? 'bg-success' : 'bg-outline-danger border border-danger text-danger' }}">
                                        {{ $k->denda->status_bayar }}
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada catatan pengembalian buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pengembalian->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $pengembalian->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection