<h2>Pengingat Pengembalian Buku</h2>
<p>Halo {{ $peminjaman->mahasiswa->nama ?? 'Anggota' }},</p>
<p>Ini pengingat bahwa buku yang Anda pinjam harus dikembalikan besok, {{ $peminjaman->tgl_tenggat }}.</p>
<ul>@foreach($peminjaman->detailPeminjaman as $detail)<li>{{ $detail->buku->judul ?? $detail->kode_buku }} ({{ $detail->jumlah }})</li>@endforeach</ul>
