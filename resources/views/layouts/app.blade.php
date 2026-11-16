<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SIPERPUS - Sistem Informasi Perpustakaan' }}</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-link.active {
            font-weight: 600;
        }
        .form-label { margin-bottom: .4rem; }
        .form-control, .form-select { min-height: 42px; }
        .invalid-feedback { display: block; }
        .form-text { font-size: .8rem; }
        @media (max-width: 576px) {
            .card-body { padding: 1rem; }
            .form-actions { flex-direction: column-reverse; gap: .75rem; }
            .form-actions .btn { width: 100%; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('buku.index') }}">
                <i class="bi bi-book-half fs-4"></i> SIPERPUS
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <!-- MENU NAVIGASI UTAMA -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        {{-- MASTER DATA --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                                <i class="bi bi-journal-bookmark me-1"></i> Katalog Buku
                            </a>
                        </li>
                        @if(Auth::user()->role === 'Admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}" href="{{ route('mahasiswa.index') }}">
                                <i class="bi bi-people me-1"></i> Mahasiswa
                            </a>
                        </li>
                        @endif

                        {{-- TRANSAKSI --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">
                                <i class="bi bi-journal-arrow-up me-1"></i> Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pengembalian.*') ? 'active' : '' }}" href="{{ route('pengembalian.index') }}">
                                <i class="bi bi-journal-arrow-down me-1"></i> Pengembalian
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('denda.*') ? 'active' : '' }}" href="{{ route('denda.index') }}">
                                <i class="bi bi-cash-coin me-1"></i> Denda & Pelunasan
                            </a>
                        </li>

                        {{-- KELOLA PETUGAS (KHUSUS ADMIN) --}}
                        @if(Auth::user()->role === 'Admin')
                        <li class="nav-item border-start ms-lg-2 ps-lg-2">
                            <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                                <i class="bi bi-person-gear me-1"></i> Kelola Petugas
                            </a>
                        </li>
                        @endif
                    </ul>

                    <!-- INFORMASI USER & LOGOUT -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-white text-end d-none d-sm-block">
                            <div class="fw-bold small">{{ Auth::user()->nama }}</div>
                            <div class="text-white-50" style="font-size: 0.75rem;">
                                NIP: {{ Auth::user()->nip }} ({{ Auth::user()->role }})
                            </div>
                        </div>

                        <!-- TOMBOL PROFIL -->
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" title="Profil & Password">
                            <i class="bi bi-person-circle"></i> Profil
                        </a>

                        <!-- TOMBOL LOGOUT -->
                        <button type="button" class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- CONTENT BODY CONTAINER -->
    <main class="py-4">
        <div class="container">
            <!-- KONTEN UTAMA HALAMAN -->
            @yield('content')
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-3 text-center text-muted small mt-auto">
        <div class="container">
            &copy; {{ date('Y') }} <strong>SIPERPUS</strong> — Sistem Informasi Perpustakaan Kampus
        </div>
    </footer>

    <!-- MODAL KONFIRMASI LOGOUT -->
    @auth
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white py-2">
                    <h6 class="modal-title" id="logoutModalLabel"><i class="bi bi-exclamation-circle me-1"></i> Konfirmasi Logout</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-3">
                    Apakah Anda yakin ingin keluar dari sistem?
                </div>
                <div class="modal-footer justify-content-center py-2 bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger px-3">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="modalKonfirmasiHapusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalKonfirmasiHapusLabel"><i class="bi bi-trash3 me-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center py-4" id="pesanKonfirmasiHapus">Data yang dipilih akan dihapus.</div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus"><i class="bi bi-trash3 me-1"></i>Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        function showToast(message, type = 'info') {
            const styles = {
                success: { background: 'linear-gradient(135deg, #198754, #20c997)', icon: '✓' },
                error: { background: 'linear-gradient(135deg, #dc3545, #fd7e14)', icon: '!' },
                info: { background: 'linear-gradient(135deg, #0d6efd, #6610f2)', icon: 'i' }
            };
            const style = styles[type] || styles.info;
            Toastify({
                text: `${style.icon}  ${message}`,
                duration: 4500,
                close: true,
                gravity: 'top',
                position: 'right',
                stopOnFocus: true,
                style: { background: style.background, borderRadius: '10px', boxShadow: '0 8px 24px rgba(0,0,0,.18)' }
            }).showToast();
        }
        @if(session('success')) showToast(@json(session('success')), 'success'); @endif
        @if(session('error')) showToast(@json(session('error')), 'error'); @endif
        @if(session('info')) showToast(@json(session('info')), 'info'); @endif

        document.querySelectorAll('.form-hapus, .form-konfirmasi').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                document.getElementById('pesanKonfirmasiHapus').textContent = form.dataset.pesan || 'Data yang dipilih akan dihapus.';
                document.getElementById('modalKonfirmasiHapusLabel').innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Konfirmasi ' + (form.dataset.aksi || 'Hapus');
                document.getElementById('btnKonfirmasiHapus').innerHTML = '<i class="bi bi-check-circle me-1"></i>' + (form.dataset.aksi || 'Hapus');
                const modalElement = document.getElementById('modalKonfirmasiHapus');
                const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                document.getElementById('btnKonfirmasiHapus').onclick = function () {
                    modal.hide();
                    form.submit();
                };
                modal.show();
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
