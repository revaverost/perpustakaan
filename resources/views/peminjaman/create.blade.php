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

                    <form action="{{ route('peminjaman.store') }}" method="POST" id="form-peminjaman">
                        @csrf

                        {{-- Pilih Mahasiswa --}}
                        <div class="mb-4 position-relative">
                            <label for="search-mahasiswa" class="form-label fw-bold">Pilih Mahasiswa Peminjam</label>
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="search" id="search-mahasiswa" class="form-control @error('nim') is-invalid @enderror" placeholder="Ketik nama anggota atau NIM..." autocomplete="off" required>
                            </div>
                            <input type="hidden" name="nim" id="nim" value="{{ old('nim') }}">
                            <div id="hasil-mahasiswa" class="list-group shadow-sm position-absolute w-100" style="z-index: 1050;"></div>
                            @error('nim')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
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
                            @php
                                $oldBuku = old('buku', [['kode_buku' => '', 'jumlah' => 1]]);
                            @endphp

                            @foreach($oldBuku as $i => $item)
                                <div class="row g-2 mb-3 item-buku align-items-start">
                                    <div class="col-md-7 position-relative">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-book"></i></span>
                                            <input type="search"
                                                   class="form-control search-buku @error("buku.$i.kode_buku") is-invalid @enderror"
                                                   placeholder="Ketik judul atau kode buku..."
                                                   autocomplete="off"
                                                   required>
                                        </div>
                                        <input type="hidden"
                                               name="buku[{{ $i }}][kode_buku]"
                                               class="hidden-kode-buku"
                                               value="{{ $item['kode_buku'] ?? '' }}">
                                        <div class="list-group shadow-sm hasil-buku position-absolute w-100" style="z-index: 1040;"></div>
                                        @error("buku.$i.kode_buku")
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <input type="number"
                                               name="buku[{{ $i }}][jumlah]"
                                               class="form-control input-jumlah @error("buku.$i.jumlah") is-invalid @enderror"
                                               placeholder="Jumlah"
                                               value="{{ $item['jumlah'] ?? 1 }}"
                                               min="1"
                                               required>
                                        @error("buku.$i.jumlah")
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-outline-danger w-100 btn-hapus-buku" {{ count($oldBuku) === 1 ? 'disabled' : '' }}>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
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

@php
    $membersData = $mahasiswa->map(function ($mhs) {
        return [
            'nim' => $mhs->nim,
            'nama' => $mhs->nama,
            'jurusan' => $mhs->jurusan,
        ];
    })->values();

    $booksData = $buku->map(function ($b) {
        return [
            'kode_buku' => $b->kode_buku,
            'judul' => $b->judul,
            'pengarang' => $b->pengarang,
            'stok' => $b->stok,
        ];
    })->values();
@endphp

{{-- Script Autocomplete Mahasiswa & Dinamis Buku --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let index = {{ count($oldBuku) }};
        const wrapper = document.getElementById('wrapper-buku');
        const btnTambah = document.getElementById('btn-tambah-buku');
        const formPeminjaman = document.getElementById('form-peminjaman');

        // =========================================================================
        // 1. PENCARIAN MAHASISWA
        // =========================================================================
        const memberInput = document.getElementById('search-mahasiswa');
        const memberHidden = document.getElementById('nim');
        const memberResults = document.getElementById('hasil-mahasiswa');

        const members = @json($membersData);

        const renderMembers = () => {
            const query = memberInput.value.trim().toLowerCase();
            memberResults.innerHTML = '';
            if (!query) {
                memberHidden.value = '';
                return;
            }
            members
                .filter(member => `${member.nama} ${member.nim}`.toLowerCase().includes(query))
                .slice(0, 8)
                .forEach(member => {
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

        memberInput.addEventListener('input', () => {
            memberHidden.value = '';
            renderMembers();
        });
        memberInput.addEventListener('focus', renderMembers);

        @if(old('nim'))
            const oldNim = @json(old('nim'));
            const selectedMember = members.find(member => member.nim === oldNim);
            if (selectedMember) {
                memberInput.value = `${selectedMember.nama} (${selectedMember.nim})`;
            }
        @endif

        // =========================================================================
        // 2. PENCARIAN BUKU (MENDUKUNG MULTIPLE ROW DINAMIS)
        // =========================================================================
        const books = @json($booksData);

        function setupBookRow(rowElement) {
            const searchInput = rowElement.querySelector('.search-buku');
            const hiddenInput = rowElement.querySelector('.hidden-kode-buku');
            const resultsBox = rowElement.querySelector('.hasil-buku');
            const jumlahInput = rowElement.querySelector('.input-jumlah');

            if (hiddenInput.value) {
                const preselected = books.find(b => b.kode_buku === hiddenInput.value);
                if (preselected) {
                    searchInput.value = `[${preselected.kode_buku}] ${preselected.judul} (Stok: ${preselected.stok})`;
                    jumlahInput.max = preselected.stok;
                }
            }

            const renderBooks = () => {
                const query = searchInput.value.trim().toLowerCase();
                resultsBox.innerHTML = '';
                if (!query) {
                    hiddenInput.value = '';
                    jumlahInput.removeAttribute('max');
                    return;
                }

                const selectedCodes = Array.from(wrapper.querySelectorAll('.hidden-kode-buku'))
                    .filter(inp => inp !== hiddenInput && inp.value !== '')
                    .map(inp => inp.value);

                const filtered = books
                    .filter(b => `${b.kode_buku} ${b.judul} ${b.pengarang}`.toLowerCase().includes(query))
                    .slice(0, 8);

                if (filtered.length === 0) {
                    const emptyItem = document.createElement('div');
                    emptyItem.className = 'list-group-item text-muted small';
                    emptyItem.textContent = 'Buku tidak ditemukan...';
                    resultsBox.appendChild(emptyItem);
                    return;
                }

                filtered.forEach(book => {
                    const isAlreadySelected = selectedCodes.includes(book.kode_buku);
                    const isOutOfStock = book.stok <= 0;

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';

                    if (isOutOfStock || isAlreadySelected) {
                        btn.disabled = true;
                        btn.classList.add('text-muted', 'bg-light');
                    }

                    btn.innerHTML = `
                        <span>
                            <strong>[${book.kode_buku}]</strong> ${book.judul}
                            <small class="text-muted d-block">${book.pengarang}</small>
                        </span>
                        <span class="badge ${isOutOfStock ? 'bg-danger' : (isAlreadySelected ? 'bg-secondary' : 'bg-info text-dark')}">
                            ${isOutOfStock ? 'Stok Habis' : (isAlreadySelected ? 'Sudah Dipilih' : 'Stok: ' + book.stok)}
                        </span>
                    `;

                    btn.addEventListener('click', () => {
                        searchInput.value = `[${book.kode_buku}] ${book.judul} (Stok: ${book.stok})`;
                        hiddenInput.value = book.kode_buku;
                        jumlahInput.max = book.stok;
                        if (parseInt(jumlahInput.value) > book.stok) {
                            jumlahInput.value = book.stok;
                        }
                        resultsBox.innerHTML = '';
                    });

                    resultsBox.appendChild(btn);
                });
            };

            searchInput.addEventListener('input', () => {
                hiddenInput.value = '';
                renderBooks();
            });
            searchInput.addEventListener('focus', renderBooks);
        }

        wrapper.querySelectorAll('.item-buku').forEach(setupBookRow);

        btnTambah.addEventListener('click', function () {
            const rowBaru = document.createElement('div');
            rowBaru.classList.add('row', 'g-2', 'mb-3', 'item-buku', 'align-items-start');
            rowBaru.innerHTML = `
                <div class="col-md-7 position-relative">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-book"></i></span>
                        <input type="search"
                               class="form-control search-buku"
                               placeholder="Ketik judul atau kode buku..."
                               autocomplete="off"
                               required>
                    </div>
                    <input type="hidden" name="buku[${index}][kode_buku]" class="hidden-kode-buku">
                    <div class="list-group shadow-sm hasil-buku position-absolute w-100" style="z-index: 1040;"></div>
                </div>
                <div class="col-md-3">
                    <input type="number" name="buku[${index}][jumlah]" class="form-control input-jumlah" placeholder="Jumlah" value="1" min="1" required>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-outline-danger w-100 btn-hapus-buku">Hapus</button>
                </div>
            `;
            wrapper.appendChild(rowBaru);
            setupBookRow(rowBaru);
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

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#search-mahasiswa') && !e.target.closest('#hasil-mahasiswa')) {
                memberResults.innerHTML = '';
            }
            wrapper.querySelectorAll('.item-buku').forEach(row => {
                if (!row.contains(e.target)) {
                    row.querySelector('.hasil-buku').innerHTML = '';
                }
            });
        });

        formPeminjaman.addEventListener('submit', function (e) {
            if (!memberHidden.value) {
                e.preventDefault();
                alert('Silakan pilih mahasiswa peminjam dari daftar pencarian yang muncul.');
                memberInput.focus();
                return;
            }

            const emptyBookRow = Array.from(wrapper.querySelectorAll('.item-buku')).find(row => {
                return !row.querySelector('.hidden-kode-buku').value;
            });

            if (emptyBookRow) {
                e.preventDefault();
                alert('Silakan pilih buku yang valid dari daftar pencarian pada setiap baris.');
                emptyBookRow.querySelector('.search-buku').focus();
            }
        });
    });
</script>
@endsection