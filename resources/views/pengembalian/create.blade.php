@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="fw-bold mb-0">Form Pengembalian Buku</h4>
        <p class="text-muted small">ID Transaksi Peminjaman: <code>#{{ $peminjaman->id_peminjaman }}</code></p>
    </div>
</div>

<form action="{{ route('pengembalian.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id_peminjaman }}">

    <div class="row">
        <!-- INFORMASI PEMINJAMAN & TANGGAL -->
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white font-weight-bold">
                    <i class="bi bi-info-circle me-1"></i> Informasi Peminjaman
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-3">
                        <tr>
                            <td class="text-muted" width="40%">Mahasiswa</td>
                            <th width="60%">: {{ $peminjaman->mahasiswa->nama ?? '-' }} ({{ $peminjaman->nim }})</th>
                        </tr>
                        <tr>
                            <td class="text-muted">Tgl Pinjam</td>
                            <th>: {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</th>
                        </tr>
                        <tr>
                            <td class="text-muted">Tgl Tenggat</td>
                            <th>: <span id="text-tgl-tenggat" data-tenggat="{{ $peminjaman->tgl_tenggat }}">{{ \Carbon\Carbon::parse($peminjaman->tgl_tenggat)->format('d/m/Y') }}</span></th>
                        </tr>
                    </table>

                    <hr>

                    <!-- INPUT TANGGAL KEMBALI -->
                    <div class="mb-3">
                        <label for="tgl_kembali" class="form-label fw-bold">Tanggal Pengembalian</label>
                        <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- RINGKASAN CALCULATOR DENDA -->
                    <div class="card bg-light border-0 p-3 mt-3">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Ringkasan Denda</h6>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Status Pengembalian:</span>
                            <span id="badge-status-terlambat" class="badge bg-success">Tepat Waktu</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Terlambat:</span>
                            <span class="fw-bold"><span id="text-hari-terlambat">0</span> Hari</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Denda Telat (Rp 1.000/hari):</span>
                            <span class="fw-bold text-danger">Rp <span id="text-denda-telat">0</span></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Denda Fisik / Hilang:</span>
                            <span class="fw-bold text-danger">Rp <span id="text-denda-fisik">0</span></span>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">TOTAL DENDA:</span>
                            <h5 class="fw-bold text-danger mb-0">Rp <span id="text-total-denda">0</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DAFTAR BUKU & PEMILIHAN KONDISI -->
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="bi bi-book me-1"></i> Kondisi Fisik Buku
                </div>
                <div class="card-body p-3">
                    @foreach($peminjaman->detailPeminjaman as $index => $detail)
                        <div class="border rounded p-3 mb-3 bg-white shadow-sm">
                            <input type="hidden" name="kondisi[{{ $index }}][kode_buku]" value="{{ $detail->kode_buku }}">
                            
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $detail->buku->judul }}</h6>
                                    <small class="text-muted">Kode: <code>{{ $detail->kode_buku }}</code> | Harga: <strong>Rp {{ number_format($detail->buku->harga, 0, ',', '.') }}</strong></small>
                                </div>
                            </div>

                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Kondisi Buku</label>
                                    <select name="kondisi[{{ $index }}][status]" class="form-select form-select-sm select-kondisi" data-index="{{ $index }}" required>
                                        <option value="Baik" selected>Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                        <option value="Hilang">Hilang</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Denda Fisik (Rp)</label>
                                    <input type="number" name="kondisi[{{ $index }}][denda_fisik]" id="denda-fisik-{{ $index }}" class="form-control form-control-sm input-denda-fisik" value="0" min="0" data-index="{{ $index }}">
                                </div>
                                <div class="col-md-12 mt-2">
                                    <input type="text" name="kondisi[{{ $index }}][keterangan]" class="form-control form-control-sm" placeholder="Catatan kondisi (opsional)...">
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="text-end mt-4">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle me-1"></i> Proses Pengembalian
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- JAVASCRIPT LOGIKA REAL-TIME CALCULATOR -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputTglKembali = document.getElementById('tgl_kembali');
    const tglTenggatStr = document.getElementById('text-tgl-tenggat').dataset.tenggat;
    const tglTenggat = new Date(tglTenggatStr);
    tglTenggat.setHours(0, 0, 0, 0);

    const badgeStatus = document.getElementById('badge-status-terlambat');
    const textHariTerlambat = document.getElementById('text-hari-terlambat');
    const textDendaTelat = document.getElementById('text-denda-telat');
    const textDendaFisik = document.getElementById('text-denda-fisik');
    const textTotalDenda = document.getElementById('text-total-denda');

    const selectKondisi = document.querySelectorAll('.select-kondisi');
    const inputDendaFisik = document.querySelectorAll('.input-denda-fisik');

    // Mapping harga buku untuk pengisian denda otomatis saat buku hilang/rusak
    const hargaBukuMap = {
        @foreach($peminjaman->detailPeminjaman as $index => $detail)
            "{{ $index }}": {{ $detail->buku->harga ?? 0 }},
        @endforeach
    };

    let dendaTelat = 0;

    // 1. Fungsi Hitung Keterlambatan Real-Time
    function hitungTerlambat() {
        const valKembali = inputTglKembali.value;
        if (!valKembali) return;

        const tglKembali = new Date(valKembali);
        tglKembali.setHours(0, 0, 0, 0);

        const diffTime = tglKembali - tglTenggat;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays > 0) {
            badgeStatus.className = 'badge bg-danger';
            badgeStatus.textContent = 'Terlambat';
            textHariTerlambat.textContent = diffDays;
            dendaTelat = diffDays * 1000;
        } else {
            badgeStatus.className = 'badge bg-success';
            badgeStatus.textContent = 'Tepat Waktu';
            textHariTerlambat.textContent = 0;
            dendaTelat = 0;
        }

        textDendaTelat.textContent = new Intl.NumberFormat('id-ID').format(dendaTelat);
        hitungTotalSemua();
    }

    // 2. Listener Pilihan Kondisi Fisik Buku
    selectKondisi.forEach(select => {
        select.addEventListener('change', function () {
            const idx = this.dataset.index;
            const inputDenda = document.getElementById(`denda-fisik-${idx}`);
            const hargaBuku = hargaBukuMap[idx] || 0;

            if (this.value === 'Hilang') {
                inputDenda.value = hargaBuku; // Denda seharga buku
            } else if (this.value === 'Rusak Berat') {
                inputDenda.value = Math.round(hargaBuku * 0.5); // 50% harga buku
            } else if (this.value === 'Rusak Ringan') {
                inputDenda.value = 15000;
            } else {
                inputDenda.value = 0;
            }
            hitungTotalSemua();
        });
    });

    // 3. Listener Perubahan Manual pada Denda Fisik
    inputDendaFisik.forEach(input => {
        input.addEventListener('input', hitungTotalSemua);
    });

    // 4. Hitung Total Akhir (Denda Telat + Denda Fisik)
    function hitungTotalSemua() {
        let totalFisik = 0;
        inputDendaFisik.forEach(input => {
            totalFisik += parseFloat(input.value) || 0;
        });

        const totalAkumulasi = dendaTelat + totalFisik;
        textDendaFisik.textContent = new Intl.NumberFormat('id-ID').format(totalFisik);
        textTotalDenda.textContent = new Intl.NumberFormat('id-ID').format(totalAkumulasi);
    }

    // Jalankan kalkulasi pertama kali saat halaman dimuat
    inputTglKembali.addEventListener('change', hitungTerlambat);
    hitungTerlambat();
});
</script>
@endsection