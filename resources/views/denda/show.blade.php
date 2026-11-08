@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rincian Tagihan Denda #{{ $denda->id_denda }}</h5>
                    <span class="badge {{ $denda->status_bayar === 'Lunas' ? 'bg-success' : 'bg-danger' }}">
                        {{ $denda->status_bayar }}
                    </span>
                </div>
                <div class="card-body">
                    {{-- Informasi Peminjam --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">NIM / Nama Mahasiswa</p>
                            <h6 class="fw-bold">{{ $denda->pengembalian->peminjaman->mahasiswa->nim }} - {{ $denda->pengembalian->peminjaman->mahasiswa->nama }}</h6>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="text-muted mb-1">Tanggal Dikembalikan</p>
                            <h6 class="fw-bold">{{ \Carbon\Carbon::parse($denda->pengembalian->tgl_kembali)->format('d M Y') }}</h6>
                        </div>
                    </div>

                    <table class="table table-bordered my-3">
                        <thead class="table-light">
                            <tr>
                                <th>Keterangan Pelanggaran</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Terlambat {{ $denda->pengembalian->terlambat_hari }} Hari (Rp 1.000 / Hari)</td>
                                <td class="text-end">Rp {{ number_format($denda->pengembalian->terlambat_hari * 1000, 0, ',', '.') }}</td>
                            </tr>
                            @foreach($denda->pengembalian->kondisiBukuKembali as $kondisi)
                                @if($kondisi->denda_fisik > 0)
                                    <tr>
                                        <td>Kerusakan/Kehilangan Buku [{{ $kondisi->kode_buku }}] (Kondisi: {{ $kondisi->kondisi }})</td>
                                        <td class="text-end">Rp {{ number_format($kondisi->denda_fisik, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot class="fw-bold">
                            <tr>
                                <td>TOTAL DENDA</td>
                                <td class="text-end text-danger fs-5">Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    @if($denda->status_bayar === 'Lunas')
                        <div class="alert alert-success mt-3 mb-0">
                            <strong>Status: Lunas</strong><br>
                            Dibayar pada: {{ \Carbon\Carbon::parse($denda->tgl_bayar)->format('d M Y H:i') }} | 
                            Metode: {{ $denda->metode_bayar }} | 
                            Petugas: {{ $denda->user->nama ?? '-' }}
                        </div>
                    @else
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('denda.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalPelunasan">
                                Process Pembayaran Denda
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Form Pelunasan Denda --}}
<div class="modal fade" id="modalPelunasan" tabindex="-1" aria-labelledby="modalPelunasanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('denda.bayar', $denda->id_denda) }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-header-title mb-0" id="modalPelunasanLabel">Konfirmasi Pelunasan Denda</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Total pembayaran denda yang diterima:</p>
                    <h3 class="text-success fw-bold mb-3">Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}</h3>

                    <div class="mb-3">
                        <label for="metode_bayar" class="form-label fw-bold">Pilih Metode Pembayaran</label>
                        <select name="metode_bayar" id="metode_bayar" class="form-select" required>
                            <option value="Tunai" selected>Tunai (Cash)</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer Bank</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Pelunasan Diterima</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection