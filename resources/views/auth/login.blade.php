<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas Perpustakaan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .login-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .login-header {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card login-card">
                    <div class="card-header login-header text-white text-center py-4">
                        <h4 class="mb-1 fw-bold">SIPERPUS</h4>
                        <p class="mb-0 small text-white-50">Sistem Informasi Perpustakaan Kampus</p>
                    </div>
                    <div class="card-body p-4">

                        {{-- Alert Pesan Sukses / Logout --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            {{-- Input NIP --}}
                            <div class="mb-3">
                                <label for="nip" class="form-label fw-bold">NIP (10 Karakter)</label>
                                <input type="text" name="nip" id="nip" 
                                       class="form-control @error('nip') is-invalid @enderror" 
                                       placeholder="Contoh: 1995031202" 
                                       value="{{ old('nip') }}" 
                                       maxlength="10" 
                                       required autofocus>
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Input Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Masukkan password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Remember Me --}}
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
                            </div>

                            {{-- Tombol Submit --}}
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Masuk Aplikasi</button>
                        </form>
                    </div>
                    <div class="card-footer bg-white text-center py-3 border-0">
                        <small class="text-muted">Akses Khusus Admin & Pustakawan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>