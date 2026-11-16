<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SIPERPUS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .otp-card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .otp-header { background: linear-gradient(135deg, #0d6efd, #0a58ca); border-top-left-radius: 12px; border-top-right-radius: 12px; }
        .otp-input { font-size: 1.5rem; letter-spacing: .5rem; text-align: center; }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card otp-card">
                    <div class="card-header otp-header text-white text-center py-4">
                        <h4 class="mb-1 fw-bold">Verifikasi OTP</h4>
                        <p class="mb-0 small text-white-50">SIPERPUS - Sistem Informasi Perpustakaan</p>
                    </div>
                    <div class="card-body p-4">

                        @if(session('info'))
                            <div class="alert alert-info py-2 small">{{ session('info') }}</div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                        @endif

                        <p class="text-muted small mb-3">
                            Kode <strong>{{ (int) config('otp.length', 6) }} digit</strong> telah dikirim ke
                            <strong>{{ $email }}</strong>. Periksa inbox atau folder spam email Anda.
                        </p>

                        @if($expiresAt)
                            <p class="text-muted small mb-3">
                                Kode berlaku sampai
                                <strong>{{ \Illuminate\Support\Carbon::parse($expiresAt)->timezone(config('app.timezone'))->format('H:i') }}</strong>.
                            </p>
                        @endif

                        <form action="{{ route('login.otp.verify') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="code" class="form-label fw-bold">Kode OTP</label>
                                <input type="text" name="code" id="code"
                                       class="form-control otp-input @error('code') is-invalid @enderror"
                                       placeholder="000000"
                                       maxlength="{{ (int) config('otp.length', 6) }}"
                                       inputmode="numeric" autocomplete="one-time-code" required autofocus>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Verifikasi & Masuk</button>
                        </form>

                        <div class="text-center mt-3">
                            <form action="{{ route('login.otp.resend') }}" method="POST" id="resendForm" class="d-inline">
                                @csrf
                                <button type="submit" id="resendButton" class="btn btn-link btn-sm text-decoration-none"
                                        @if($secondsUntilResend > 0) disabled @endif>
                                    Kirim ulang kode
                                </button>
                            </form>
                            <span id="resendCountdown" class="small text-muted"></span>
                        </div>

                        <div class="text-center mt-2">
                            <a href="{{ route('login') }}" class="small text-decoration-none">Kembali ke halaman login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var seconds = {{ (int) $secondsUntilResend }};
            var button = document.getElementById('resendButton');
            var label = document.getElementById('resendCountdown');

            function tick() {
                if (seconds <= 0) {
                    button.disabled = false;
                    label.textContent = '';
                    return;
                }
                button.disabled = true;
                label.textContent = '(' + seconds + ' detik)';
                seconds--;
                setTimeout(tick, 1000);
            }

            tick();
        })();
    </script>
</body>
</html>
