<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
        .header { background-color: #3730a3; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .warning-box { background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 12px 15px; margin: 15px 0; font-size: 13px; color: #92400e; }
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
            <p style="margin:4px 0 0; font-size:13px;">Pengingat Batas Waktu Pengembalian Buku</p>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $peminjaman->mahasiswa->nama ?? '-' }}</strong> (NIM: {{ $peminjaman->nim }}),</p>
            <p>Kami mengingatkan bahwa masa peminjaman buku Anda dengan ID transaksi <strong>#{{ $peminjaman->id_peminjaman }}</strong> akan jatuh tempo <strong>besok</strong>.</p>

            <div class="warning-box">
                <strong>Batas Pengembalian (Tenggat):</strong> {{ \Carbon\Carbon::parse($peminjaman->tgl_tenggat)->format('d/m/Y') }}<br>
                Harap segera mengembalikan buku ke perpustakaan tepat waktu untuk menghindari denda keterlambatan sebesar <strong>Rp 1.000 / hari</strong>.
            </div>

            <p style="margin-bottom: 6px;"><strong>Daftar Buku yang Masih Dipinjam:</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                        <th style="text-align:center;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sisaBuku as $detail)
                        <tr>
                            <td>{{ $detail->kode_buku }}</td>
                            <td>{{ $detail->buku->judul ?? '-' }}</td>
                            <td style="text-align:center;">{{ $detail->jumlah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh Sistem Informasi Perpustakaan Kampus (SIPERPUS).
        </div>
    </div>
</body>
</html>