@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h1 class="h3 mb-1">Dashboard Analitik</h1><p class="text-muted mb-0">Ringkasan aktivitas perpustakaan 7 hari terakhir.</p></div>
</div>

<div class="row g-3 mb-4">
    @foreach ([['Total Buku', $totalBuku, 'bi-book', 'primary'], ['Total Anggota', $totalMahasiswa, 'bi-people', 'success'], ['Peminjaman Aktif', $peminjamanAktif, 'bi-journal-arrow-up', 'warning'], ['Total Denda', 'Rp '.number_format($totalDenda, 0, ',', '.'), 'bi-cash-coin', 'danger']] as [$label, $value, $icon, $color])
    <div class="col-12 col-sm-6 col-xl-3"><div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center justify-content-between"><div><div class="text-muted small">{{ $label }}</div><div class="fs-4 fw-bold mt-1">{{ $value }}</div></div><div class="rounded-circle bg-{{ $color }} bg-opacity-10 text-{{ $color }} p-3"><i class="bi {{ $icon }} fs-4"></i></div></div></div></div>
    @endforeach
</div>

<div class="card border-0 shadow-sm mb-4"><div class="card-body"><h2 class="h5 mb-3">Tren Peminjaman</h2><div style="height: 280px"><canvas id="loanTrendChart"></canvas></div></div></div>

<div class="card border-0 shadow-sm"><div class="card-body"><h2 class="h5 mb-3">Member Activity Monitoring</h2><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Anggota</th><th>Aktivitas</th><th>Buku</th><th>Tanggal</th><th>Status</th></tr></thead><tbody>
@forelse ($activities as $activity)
<tr><td class="fw-semibold">{{ $activity->mahasiswa->nama ?? 'Anggota dihapus' }}</td><td>Meminjam buku</td><td>{{ $activity->detailPeminjaman->first()?->buku?->judul ?? 'Tidak tersedia' }}@if($activity->detailPeminjaman->count() > 1) <span class="text-muted">(+{{ $activity->detailPeminjaman->count() - 1 }} lainnya)</span>@endif</td><td>{{ \Carbon\Carbon::parse($activity->tgl_pinjam)->format('d/m/Y') }}</td><td><span class="badge text-bg-{{ $activity->status === 'Dipinjam' ? 'warning' : 'success' }}">{{ $activity->status }}</span></td></tr>
@empty <tr><td colspan="5" class="text-center text-muted py-4">Belum ada aktivitas peminjaman.</td></tr>@endforelse
</tbody></table></div></div></div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>new Chart(document.getElementById('loanTrendChart'), { type:'line', data:{labels:@json($trendLabels),datasets:[{label:'Peminjaman',data:@json($trendValues),borderColor:'#0d6efd',backgroundColor:'rgba(13,110,253,.12)',fill:true,tension:.35}]}, options:{responsive:true,maintainAspectRatio:false,scales:{y:{beginAtZero:true, ticks:{precision:0}}},plugins:{legend:{display:false}}} });</script>
@endpush
