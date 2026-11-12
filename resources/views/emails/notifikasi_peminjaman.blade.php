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
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 13px; }
        th { background-color: #f4f4f8; }
        .footer { background-color: #f9fafb; padding: 12px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">SIPERPUS</h2>
            <p style="margin:4px 0 0; font-size:13px;">Bukti Transaksi Peminjaman Buku</p>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $peminjaman->mahasiswa->nama ?? '-' }}</strong> (NIM: {{ $peminjaman->nim }}),</p>
            <p>Transaksi peminjaman buku Anda dengan ID <strong>#{{ $peminjaman->id_peminjaman }}</strong> telah berhasil dicatat.</p>

            <div class="info-box">
                <strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}<br>
                <strong>Batas Pengembalian (Tenggat):</strong> <span style="color:#dc2626; font-weight:bold;">{{ \Carbon\Carbon::parse($peminjaman->tgl_tenggat)->format('d/m/Y') }}</span><br>
                <strong>Petugas:</strong> {{ $peminjaman->user->nama ?? $peminjaman->nip }}
            </div>

            <p style="margin-bottom: 6px;"><strong>Daftar Buku yang Dipinjam:</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                        <th style="text-align:center;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman->detailPeminjaman as $detail)
                        <tr>
                            <td>{{ $detail->kode_buku }}</td>
                            <td>{{ $detail->buku->judul ?? '-' }}</td>
                            <td style="text-align:center;">{{ $detail->jumlah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="margin-top: 16px; font-size: 12px; color: #555;">
                * Harap mengembalikan buku sebelum tanggal tenggat untuk menghindari denda keterlambatan sebesar <strong>Rp 1.000 / hari</strong>.
            </p>
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh Sistem Informasi Perpustakaan Kampus (SIPERPUS).
        </div>
    </div>
</body>
</html>