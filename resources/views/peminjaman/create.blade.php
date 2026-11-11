@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white font-weight-bold">
                    <h5 class="mb-0">Form Transaksi Peminjaman Buku</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Mahasiswa --}}
                        <div class="mb-4">
                            <label for="nim" class="form-label fw-bold">Pilih Mahasiswa Peminjam</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="search" id="search-mahasiswa" class="form-control @error('nim') is-invalid @enderror" placeholder="Ketik nama anggota atau NIM..." autocomplete="off" required>
                            </div>
                            <input type="hidden" name="nim" id="nim" value="{{ old('nim') }}">
                            <div id="hasil-mahasiswa" class="list-group shadow-sm"></div>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        {{-- Section Dynamic Multiple Buku --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Daftar Buku Yang Dipinjam</h6>
                            <button type="button" class="btn btn-sm btn-success" id="btn-tambah-buku">
                                + Tambah Buku
                            </button>
                        </div>
                        <div id="wrapper-buku">
                            <div class="row g-2 mb-3 item-buku">
                                <div class="col-md-7">
                            <select name="buku[0][kode_buku]" class="form-select" required>
                                        <option value="" selected disabled>-- Pilih Buku --</option>
                                        @foreach($buku as $b)
                                            <option value="{{ $b->kode_buku }}">
                                                [{{ $b->kode_buku }}] {{ $b->judul }} (Stok: {{ $b->stok }})
                                            </option>
                                        @endforeach
                            </select>
                            @error('buku.0.kode_buku')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3">
                            <input type="number" name="buku[0][jumlah]" class="form-control" placeholder="Jumlah" value="1" min="1" required>
                            @error('buku.0.jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-outline-danger w-100 btn-hapus-buku" disabled>Hapus</button>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Peminjaman</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk Tambah/Hapus Form Buku --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let index = 1;
        const wrapper = document.getElementById('wrapper-buku');
        const btnTambah = document.getElementById('btn-tambah-buku');
        const memberInput = document.getElementById('search-mahasiswa');
        const memberHidden = document.getElementById('nim');
        const memberResults = document.getElementById('hasil-mahasiswa');
        const memberSearch = document.getElementById('search-mahasiswa');

        // Data sudah dimuat dari backend, sehingga pencarian dapat dilakukan
        // langsung tanpa request tambahan dan tetap bekerja pada baris dinamis.
        const members = @json($mahasiswa->map(fn ($mhs) => ['nim' => $mhs->nim, 'nama' => $mhs->nama, 'jurusan' => $mhs->jurusan]));
        const renderMembers = () => {
            const query = memberInput.value.trim().toLowerCase();
            memberResults.innerHTML = '';
            if (!query) {
                memberHidden.value = '';
                return;
            }
            members.filter(member => `${member.nama} ${member.nim}`.toLowerCase().includes(query)).slice(0, 8).forEach(member => {
                const result = document.createElement('button');
                result.type = 'button';
                result.className = 'list-group-item list-group-item-action';
                result.textContent = `${member.nama} (${member.nim}) - ${member.jurusan}`;
                result.addEventListener('click', () => {
                    memberInput.value = `${member.nama} (${member.nim})`;
                    memberHidden.value = member.nim;
                    memberResults.innerHTML = '';
                });
                memberResults.appendChild(result);
            });
        };
        memberSearch.addEventListener('input', renderMembers);
        memberInput.addEventListener('focus', renderMembers);
        @if(old('nim'))
            const selectedMember = members.find(member => member.nim === @json(old('nim')));
            if (selectedMember) memberInput.value = `${selectedMember.nama} (${selectedMember.nim})`;
        @endif

        btnTambah.addEventListener('click', function () {
            const rowBaru = document.createElement('div');
            rowBaru.classList.add('row', 'g-2', 'mb-3', 'item-buku');
            rowBaru.innerHTML = `
                <div class="col-md-7">
                    <select name="buku[${index}][kode_buku]" class="form-select" required>
                        <option value="" selected disabled>-- Pilih Buku --</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->kode_buku }}">
                                [{{ $b->kode_buku }}] {{ $b->judul }} (Stok: {{ $b->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="buku[${index}][jumlah]" class="form-control" placeholder="Jumlah" value="1" min="1" required>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-outline-danger w-100 btn-hapus-buku">Hapus</button>
                </div>
            `;
            wrapper.appendChild(rowBaru);
            index++;
            updateStatusTombolHapus();
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-hapus-buku')) {
                e.target.closest('.item-buku').remove();
                updateStatusTombolHapus();
            }
        });

        function updateStatusTombolHapus() {
            const rows = wrapper.querySelectorAll('.item-buku');
            rows.forEach(row => {
                const btn = row.querySelector('.btn-hapus-buku');
                btn.disabled = rows.length === 1;
            });
        }
    });
</script>
@endsection
