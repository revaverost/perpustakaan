<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }
        h2 {
            text-align: center;
            color: #123b68;
            margin-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }
        th {
            background: #123b68;
            color: #fff;
        }
        th, td {
            border: 1px solid #bbb;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background: #f2f5f8;
        }
        .meta {
            text-align: center;
            color: #555;
        }
        .text-end {
            text-align: right;
        }
        .summary {
            margin-top: 12px;
            text-align: right;
            font-weight: bold;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h2>Laporan Data Tagihan Denda ({{ $status }})</h2>
    <div class="meta">Dicetak {{ now()->format('d/m/Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>ID Denda</th>
                <th>Mahasiswa Peminjam</th>
                <th>Keterlambatan</th>
                <th>Keterangan</th>
                <th class="text-end">Total Denda</th>
                <th>Status</th>
                <th>Tgl Bayar & Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($denda as $d)
                <tr>
                    <td>#{{ $d->id_denda }}</td>
                    <td>
                        <strong>{{ $d->pengembalian->peminjaman->mahasiswa->nama ?? '-' }}</strong><br>
                        NIM: {{ $d->pengembalian->peminjaman->nim ?? '-' }}
                    </td>
                    <td>
                        {{ ($d->pengembalian->terlambat_hari ?? 0) > 0 ? 'Telat ' . $d->pengembalian->terlambat_hari . ' Hari' : 'Tepat Waktu' }}<br>
                        <small>(Pinjam #{{ $d->pengembalian->id_peminjaman ?? '-' }})</small>
                    </td>
                    <td>{{ $d->keterangan ?? '-' }}</td>
                    <td class="text-end">Rp {{ number_format($d->jumlah_denda, 0, ',', '.') }}</td>
                    <td>{{ $d->status_bayar }}</td>
                    <td>
                        @if($d->status_bayar === 'Lunas')
                            {{ \Carbon\Carbon::parse($d->tgl_bayar)->format('d/m/Y H:i') }} ({{ $d->metode_bayar }})
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Total Akumulasi Denda: Rp {{ number_format($denda->sum('jumlah_denda'), 0, ',', '.') }}
    </div>
</body>
</html>