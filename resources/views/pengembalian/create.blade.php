@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="fw-bold mb-0">Form Pengembalian Buku</h4>
        <p class="text-muted small">ID Transaksi Peminjaman: <code>#{{ $peminjaman->id_peminjaman }}</code></p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger shadow-sm">
        <strong>Gagal memproses pengembalian:</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pengembalian.store') }}" method="POST" id="form-pengembalian">
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
                        <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" value="{{ old('tgl_kembali', date('Y-m-d')) }}" required>
                    </div>

                    <!-- RINGKASAN CALCULATOR DENDA -->
                    <div class="card bg-light border-0 p-3 mt-3">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Ringkasan Denda</h6>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Status Pengembalian:</span>
                            <span id="badge-status-terlambat" class="badge bg-success">Tepat Waktu</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Buku Dipilih:</span>
                            <span class="fw-bold"><span id="text-jumlah-dipilih">0</span> Buku</span>
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
                <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-book me-1"></i> Pilih Buku yang Dikembalikan</span>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="checkbox" id="check-semua-buku" checked>
                        <label class="form-check-label small fw-normal text-white" for="check-semua-buku">Pilih Semua</label>
                    </div>
                </div>
                <div class="card-body p-3">
                    @php
                        // Ambil hanya buku yang belum dikembalikan
                        $bukuBelumKembali = $peminjaman->detailPeminjaman->filter(function ($detail) use ($kodeBukuSudahKembali) {
                            return !in_array($detail->kode_buku, $kodeBukuSudahKembali ?? []);
                        })->values();
                    @endphp

                    @foreach($bukuBelumKembali as $index => $detail)
                        <div class="border rounded p-3 mb-3 shadow-sm item-card-buku bg-white" data-index="{{ $index }}">
                            <input type="hidden" name="items[{{ $index }}][kode_buku]" value="{{ $detail->kode_buku }}">
                            
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="form-check">
                                    <input class="form-check-input check-pilih-buku"
                                           type="checkbox"
                                           name="items[{{ $index }}][dipilih]"
                                           value="1"
                                           id="check-buku-{{ $index }}"
                                           data-index="{{ $index }}"
                                           checked>
                                    <label class="form-check-label" for="check-buku-{{ $index }}">
                                        <h6 class="fw-bold mb-1">{{ $detail->buku->judul }}</h6>
                                        <small class="text-muted">
                                            Kode: <code>{{ $detail->kode_buku }}</code> | 
                                            Jumlah: <strong>{{ $detail->jumlah }}</strong> | 
                                            Harga: <strong>Rp {{ number_format($detail->buku->harga, 0, ',', '.') }}</strong>
                                        </small>
                                    </label>
                                </div>
                            </div>

                            <div class="row g-2 align-items-center mt-2 panel-input-kondisi" id="panel-kondisi-{{ $index }}">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Kondisi Buku</label>
                                    <select name="items[{{ $index }}][kondisi]" class="form-select form-select-sm select-kondisi" data-index="{{ $index }}" required>
                                        <option value="Baik" {{ old("items.$index.kondisi", 'Baik') === 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak Ringan" {{ old("items.$index.kondisi") === 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                        <option value="Rusak Berat" {{ old("items.$index.kondisi") === 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                        <option value="Hilang" {{ old("items.$index.kondisi") === 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Denda Fisik (Rp)</label>
                                    <input type="number" name="items[{{ $index }}][denda_fisik]" id="denda-fisik-{{ $index }}" class="form-control form-control-sm input-denda-fisik" value="{{ old("items.$index.denda_fisik", 0) }}" min="0" data-index="{{ $index }}" required>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <input type="text" name="items[{{ $index }}][keterangan]" class="form-control form-control-sm" value="{{ old("items.$index.keterangan") }}" placeholder="Catatan kondisi (opsional)...">
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="text-end mt-4">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-success px-4" id="btn-submit-pengembalian">
                            <i class="bi bi-check-circle me-1"></i> Proses Pengembalian
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@php
    $hargaBukuData = [];
    foreach ($peminjaman->detailPeminjaman as $index => $detail) {
        $hargaBukuData[(string) $index] = $detail->buku->harga ?? 0;
    }
@endphp

<!-- JAVASCRIPT LOGIKA REAL-TIME CALCULATOR & CHECKLIST BUKU -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputTglKembali = document.getElementById('tgl_kembali');
    const tglTenggatStr = document.getElementById('text-tgl-tenggat').dataset.tenggat;
    const tglTenggat = new Date(tglTenggatStr);
    tglTenggat.setHours(0, 0, 0, 0);

    const badgeStatus = document.getElementById('badge-status-terlambat');
    const textJumlahDipilih = document.getElementById('text-jumlah-dipilih');
    const textHariTerlambat = document.getElementById('text-hari-terlambat');
    const textDendaTelat = document.getElementById('text-denda-telat');
    const textDendaFisik = document.getElementById('text-denda-fisik');
    const textTotalDenda = document.getElementById('text-total-denda');

    const checkSemua = document.getElementById('check-semua-buku');
    const checkBukuList = document.querySelectorAll('.check-pilih-buku:not(:disabled)');
    const selectKondisi = document.querySelectorAll('.select-kondisi');
    const inputDendaFisik = document.querySelectorAll('.input-denda-fisik');
    const btnSubmit = document.getElementById('btn-submit-pengembalian');

    const hargaBukuMap = @json($hargaBukuData);

    let dendaTelat = 0;

    // 1. Toggle Aktif/Nonaktif Input Kondisi Berdasarkan Checkbox Buku
    function updateStatusItemBuku(checkbox) {
        const idx = checkbox.dataset.index;
        const panel = document.getElementById(`panel-kondisi-${idx}`);
        const card = checkbox.closest('.item-card-buku');

        if (panel) {
            const inputs = panel.querySelectorAll('select, input');
            inputs.forEach(el => {
                el.disabled = !checkbox.checked;
            });
            panel.style.opacity = checkbox.checked ? '1' : '0.45';
        }

        if (card) {
            card.classList.toggle('border-primary', checkbox.checked);
        }
    }

    checkBukuList.forEach(chk => {
        chk.addEventListener('change', function () {
            updateStatusItemBuku(this);
            // Sinkronkan status checkbox "Pilih Semua"
            checkSemua.checked = Array.from(checkBukuList).every(c => c.checked);
            hitungTotalSemua();
        });
        updateStatusItemBuku(chk);
    });

    if (checkSemua) {
        checkSemua.addEventListener('change', function () {
            checkBukuList.forEach(chk => {
                chk.checked = checkSemua.checked;
                updateStatusItemBuku(chk);
            });
            hitungTotalSemua();
        });
    }

    // 2. Fungsi Hitung Keterlambatan Real-Time
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

    // 3. Listener Pilihan Kondisi Fisik Buku
    selectKondisi.forEach(select => {
        select.addEventListener('change', function () {
            const idx = this.dataset.index;
            const inputDenda = document.getElementById(`denda-fisik-${idx}`);
            const hargaBuku = hargaBukuMap[idx] || 0;

            if (this.value === 'Hilang') {
                inputDenda.value = hargaBuku;
            } else if (this.value === 'Rusak Berat') {
                inputDenda.value = Math.round(hargaBuku * 0.5);
            } else if (this.value === 'Rusak Ringan') {
                inputDenda.value = 15000;
            } else {
                inputDenda.value = 0;
            }
            hitungTotalSemua();
        });
    });

    // 4. Listener Perubahan Manual pada Denda Fisik
    inputDendaFisik.forEach(input => {
        input.addEventListener('input', hitungTotalSemua);
    });

    // 5. Hitung Total Akhir (Hanya menghitung buku yang dicentang)
    function hitungTotalSemua() {
        let totalFisik = 0;
        let jumlahDipilih = 0;

        checkBukuList.forEach(chk => {
            if (chk.checked) {
                jumlahDipilih++;
                const idx = chk.dataset.index;
                const inputDenda = document.getElementById(`denda-fisik-${idx}`);
                if (inputDenda) {
                    totalFisik += parseFloat(inputDenda.value) || 0;
                }
            }
        });

        textJumlahDipilih.textContent = jumlahDipilih;
        btnSubmit.disabled = jumlahDipilih === 0;

        const aktifDendaTelat = jumlahDipilih > 0 ? dendaTelat : 0;
        const totalAkumulasi = aktifDendaTelat + totalFisik;

        textDendaTelat.textContent = new Intl.NumberFormat('id-ID').format(aktifDendaTelat);
        textDendaFisik.textContent = new Intl.NumberFormat('id-ID').format(totalFisik);
        textTotalDenda.textContent = new Intl.NumberFormat('id-ID').format(totalAkumulasi);
    }

    inputTglKembali.addEventListener('change', hitungTerlambat);
    hitungTerlambat();
});
</script>
@endsection

@php
    $hargaBukuData = [];
    foreach ($bukuBelumKembali as $index => $detail) {
        $hargaBukuData[(string) $index] = $detail->buku->harga ?? 0;
    }
@endphp