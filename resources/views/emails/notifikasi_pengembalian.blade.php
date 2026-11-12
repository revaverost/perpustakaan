<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
        .header { background-color: #3730a3; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .info-box { background-color: #f8fafc; border-left: 4px solid #0d9488; padding: 12px 15px; margin: 15px 0; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 13px; }
        th { background-color: #f4f4f8; }
        .alert-denda { background-color: #fef2f2; border-left: 4px solid #dc2626; padding: 12px 15px; margin-top: 16px; color: #991b1b; font-size: 13px; }
        .alert-lunas { background-color: #f0fdfa; border-left: 4px solid #0d9488; padding: 12px 15px; margin-top: 16px; color: #115e59; font-size: 13px; }
        .alert-parsial { background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 12px 15px; margin-top: 16px; color: #92400e; font-size: 13px; }
        .footer { background-color: #f9fafb; padding: 12px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">SIPERPUS</h2>
            <p style="margin:4px 0 0; font-size:13px;">Bukti Pengembalian Buku Perpustakaan</p>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $peminjaman->mahasiswa->nama ?? '-' }}</strong> (NIM: {{ $peminjaman->nim }}),</p>
            <p>Pengembalian buku untuk transaksi peminjaman <strong>#{{ $peminjaman->id_peminjaman }}</strong> telah diproses dengan rincian berikut:</p>

            <div class="info-box">
                <strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}<br>
                <strong>Tanggal Tenggat:</strong> {{ \Carbon\Carbon::parse($peminjaman->tgl_tenggat)->format('d/m/Y') }}<br>
                <strong>Tanggal Dikembalikan:</strong> {{ \Carbon\Carbon::parse($daftarBukuKembali->first()->tgl_kembali ?? now())->format('d/m/Y') }}<br>
                <strong>Status Transaksi Peminjaman:</strong> {{ $peminjaman->status }}
            </div>

            <p style="margin-bottom: 6px;"><strong>Buku yang Dikembalikan:</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                        <th>Kondisi</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarBukuKembali as $item)
                        <tr>
                            <td>{{ $item->kode_buku }}</td>
                            <td>{{ $item->buku->judul ?? '-' }}</td>
                            <td>{{ $item->kondisi }}</td>
                            <td>{{ $item->keterangan_kondisi ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($denda && $denda->jumlah_denda > 0)
                <div class="alert-denda">
                    <strong>Rincian Tagihan Denda (#{{ $denda->id_denda }}):</strong><br>
                    • Denda Keterlambatan ({{ $daftarBukuKembali->first()->terlambat_hari ?? 0 }} hari): Rp {{ number_format($denda->denda_terlambat, 0, ',', '.') }}<br>
                    • Denda Kerusakan / Hilang: Rp {{ number_format($denda->denda_fisik, 0, ',', '.') }}<br>
                    <hr style="border:0; border-top:1px solid #fca5a5; margin:6px 0;">
                    <strong>Total Tagihan Denda: Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}</strong> ({{ $denda->status_bayar }})
                </div>
            @else
                <div class="alert-lunas">
                    <strong>Status Denda:</strong> Dikembalikan tepat waktu &amp; kondisi baik (Tidak ada denda).
                </div>
            @endif

            @if($sisaBukuBelumKembali->isNotEmpty())
                <div class="alert-parsial">
                    <strong>Perhatian (Pengembalian Sebagian):</strong><br>
                    Masih terdapat <strong>{{ $sisaBukuBelumKembali->count() }} judul buku</strong> dari transaksi #{{ $peminjaman->id_peminjaman }} yang belum dikembalikan:
                    <ul style="margin:6px 0 0; padding-left:18px;">
                        @foreach($sisaBukuBelumKembali as $sisa)
                            <li>[{{ $sisa->kode_buku }}] {{ $sisa->buku->judul ?? '-' }} (x{{ $sisa->jumlah }})</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh Sistem Informasi Perpustakaan Kampus (SIPERPUS).
        </div>
    </div>
</body>
</html>