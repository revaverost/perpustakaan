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
                        {{-- MASTER DATA --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                                <i class="bi bi-journal-bookmark me-1"></i> Katalog Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}" href="{{ route('mahasiswa.index') }}">
                                <i class="bi bi-people me-1"></i> Mahasiswa
                            </a>
                        </li>

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
            <!-- FLASH MESSAGES ALERT -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>