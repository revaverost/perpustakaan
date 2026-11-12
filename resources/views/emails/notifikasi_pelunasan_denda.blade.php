<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
        .header { background-color: #3730a3; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .badge-lunas { display: inline-block; background-color: #0d9488; color: #ffffff; padding: 4px 12px; border-radius: 4px; font-weight: bold; font-size: 12px; letter-spacing: 0.5px; }
        .info-box { background-color: #f8fafc; border-left: 4px solid #0d9488; padding: 12px 15px; margin: 15px 0; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 13px; }
        th { background-color: #f4f4f8; }
        .total-row { background-color: #f0fdfa; font-weight: bold; color: #115e59; }
        .footer { background-color: #f9fafb; padding: 12px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">SIPERPUS</h2>
            <p style="margin:4px 0 0; font-size:13px;">Kuitansi Pelunasan Denda Perpustakaan</p>
        </div>

        <div class="content">
            @php
                $peminjaman = $denda->pengembalian->peminjaman ?? null;
                $mahasiswa = $peminjaman->mahasiswa ?? null;
            @endphp

            <p>Halo, <strong>{{ $mahasiswa->nama ?? '-' }}</strong> (NIM: {{ $peminjaman->nim ?? '-' }}),</p>
            <p>Pembayaran tagihan denda Anda telah kami terima. Berikut adalah rincian bukti pelunasan transaksi Anda:</p>

            <div class="info-box">
                <strong>ID Tagihan Denda:</strong> #{{ $denda->id_denda }} (Ref. Peminjaman #{{ $peminjaman->id_peminjaman ?? '-' }})<br>
                <strong>Status Pembayaran:</strong> <span class="badge-lunas">LUNAS</span><br>
                <strong>Tanggal &amp; Waktu Bayar:</strong> {{ $denda->tgl_bayar ? \Carbon\Carbon::parse($denda->tgl_bayar)->format('d/m/Y H:i') : '-' }}<br>
                <strong>Metode Pembayaran:</strong> {{ $denda->metode_bayar ?? '-' }}<br>
                <strong>Petugas Penerima:</strong> {{ $denda->user->nama ?? ($denda->nip ?? '-') }}
            </div>

            <p style="margin-bottom: 6px;"><strong>Rincian Komponen Denda:</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th style="text-align:right; width: 35%;">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($denda->denda_terlambat > 0)
                        <tr>
                            <td>Denda Keterlambatan ({{ $denda->pengembalian->terlambat_hari ?? 0 }} Hari)</td>
                            <td style="text-align:right;">Rp {{ number_format($denda->denda_terlambat, 0, ',', '.') }}</td>
                        </tr>
                    @endif

                    @if($denda->denda_fisik > 0)
                        <tr>
                            <td>
                                Denda Kerusakan / Kehilangan Buku:
                                @if($bukuBermasalah->isNotEmpty())
                                    <ul style="margin: 4px 0 0; padding-left: 16px; font-size: 12px; color: #555;">
                                        @foreach($bukuBermasalah as $item)
                                            <li>[{{ $item->kode_buku }}] {{ $item->buku->judul ?? '' }} ({{ $item->kondisi }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td style="text-align:right; vertical-align: top;">Rp {{ number_format($denda->denda_fisik, 0, ',', '.') }}</td>
                        </tr>
                    @endif

                    <tr class="total-row">
                        <td>TOTAL DIBAYARKAN</td>
                        <td style="text-align:right;">Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <p style="margin-top: 16px; font-size: 12px; color: #555;">
                Simpan email ini sebagai bukti sah pelunasan kewajiban administrasi perpustakaan Anda.
            </p>
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh Sistem Informasi Perpustakaan Kampus (SIPERPUS).
        </div>
    </div>
</body>
</html>