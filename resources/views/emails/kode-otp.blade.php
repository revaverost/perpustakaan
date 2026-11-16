<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP SIPERPUS</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, Helvetica, sans-serif; color:#212529;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9; padding:24px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:480px; background:#ffffff; border-radius:12px; overflow:hidden;">
                    <tr>
                        <td style="background:#0d6efd; padding:24px; text-align:center; color:#ffffff;">
                            <h2 style="margin:0; font-size:20px;">SIPERPUS</h2>
                            <p style="margin:4px 0 0; font-size:13px; opacity:.85;">Sistem Informasi Perpustakaan Kampus</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 24px;">
                            <p style="margin:0 0 12px; font-size:15px;">Halo, <strong>{{ $nama }}</strong>,</p>
                            <p style="margin:0 0 20px; font-size:14px; line-height:1.6;">
                                Gunakan kode OTP berikut untuk menyelesaikan proses login Anda:
                            </p>
                            <div style="text-align:center; margin:0 0 20px;">
                                <span style="display:inline-block; padding:14px 28px; background:#e7f1ff; color:#0d6efd; font-size:28px; font-weight:bold; letter-spacing:8px; border-radius:10px;">
                                    {{ $kode }}
                                </span>
                            </div>
                            <p style="margin:0 0 8px; font-size:13px; color:#6c757d;">
                                Kode ini berlaku sampai <strong>{{ $expiresAt->timezone(config('app.timezone'))->format('d-m-Y H:i') }}</strong>.
                            </p>
                            <p style="margin:0; font-size:13px; color:#6c757d;">
                                Jangan bagikan kode ini kepada siapa pun. Jika Anda tidak merasa melakukan login, abaikan email ini.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 24px; background:#f8f9fa; text-align:center; font-size:12px; color:#adb5bd;">
                            &copy; {{ date('Y') }} SIPERPUS
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
