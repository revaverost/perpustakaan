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
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 3px;
        }
        .badge-baik {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <h2>Laporan Data Pengembalian Buku</h2>
    <div class="meta">Dicetak {{ now()->format('d/m/Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>ID Kembali</th>
                <th>ID Pinjam</th>
                <th>NIM & Peminjam</th>
                <th>Tgl Kembali</th>
                <th>Keterlambatan</th>
                <th>Kondisi Fisik Buku</th>
                <th>Petugas</th>
                <th class="text-end">Denda</th>
                <th>Status Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengembalian as $k)
                <tr>
                    <td>#{{ $k->id_pengembalian }}</td>
                    <td>#{{ $k->id_peminjaman }}</td>
                    <td>
                        <strong>{{ $k->peminjaman->mahasiswa->nama ?? '-' }}</strong><br>
                        NIM: {{ $k->peminjaman->nim ?? '-' }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($k->tgl_kembali)->format('d/m/Y') }}</td>
                    <td>{{ $k->terlambat_hari > 0 ? 'Telat ' . $k->terlambat_hari . ' Hari' : 'Tepat Waktu' }}</td>
                    <td>
                        <strong>[{{ $k->kode_buku }}]</strong> {{ $k->buku->judul ?? '' }}<br>
                        <span class="badge {{ $k->kondisi === 'Baik' ? 'badge-baik' : 'badge-warning' }}">
                            {{ $k->kondisi }}
                        </span>
                    </td>
                    <td>{{ $k->user->nama ?? $k->nip }}</td>
                    <td class="text-end">
                        {{ $k->denda ? 'Rp ' . number_format($k->denda->jumlah_denda, 0, ',', '.') : '-' }}
                    </td>
                    <td>{{ $k->denda->status_bayar ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>