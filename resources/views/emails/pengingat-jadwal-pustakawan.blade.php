<h2>Pengingat Jadwal Shift</h2>
<p>Halo {{ $jadwal->pustakawan->nama }},</p>
<p>Anda dijadwalkan bertugas hari ini, {{ $jadwal->tanggal->format('d/m/Y') }}, pukul <strong>{{ $jadwal->shift_mulai }} - {{ $jadwal->shift_selesai }}</strong>.</p>
<p>Terima kasih.</p>
