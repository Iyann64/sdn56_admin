<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="margin:0;padding:0;background:#f4f7f8;font-family:Arial,sans-serif;color:#1f3447">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7f8;padding:24px 0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #d8e6e8">
                    <tr>
                        <td style="padding:24px;text-align:center;background:#006064;color:#ffffff">
                            <?php if (!empty($logoUrl)): ?>
                                <img src="<?= esc($logoUrl) ?>" alt="<?= esc($siteName) ?>" style="width:64px;height:64px;object-fit:contain;margin-bottom:12px">
                            <?php endif; ?>
                            <div style="font-size:20px;font-weight:700"><?= esc($siteName) ?></div>
                            <div style="font-size:13px;margin-top:6px;opacity:.9">Permintaan reset password admin</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px">
                            <p style="font-size:15px;line-height:1.6;margin:0 0 14px">Halo <strong><?= esc($nama) ?></strong>,</p>
                            <p style="font-size:15px;line-height:1.6;margin:0 0 18px">Kami menerima permintaan untuk mengatur ulang password akun admin Anda. Klik tombol di bawah ini untuk membuat password baru.</p>
                            <p style="text-align:center;margin:28px 0">
                                <a href="<?= esc($resetLink) ?>" style="display:inline-block;background:#006064;color:#ffffff;text-decoration:none;padding:13px 22px;border-radius:8px;font-weight:700;font-size:14px">Reset Password</a>
                            </p>
                            <p style="font-size:13px;line-height:1.6;margin:0 0 10px;color:#5d7484">Link berlaku sampai <strong><?= esc($expireTime) ?></strong>.</p>
                            <p style="font-size:13px;line-height:1.6;margin:0;color:#5d7484">Jika tombol tidak bisa dibuka, salin link berikut ke browser:</p>
                            <p style="font-size:12px;line-height:1.5;word-break:break-all;background:#f3f7f8;border:1px solid #d8e6e8;border-radius:8px;padding:12px;margin:10px 0 0">
                                <?= esc($resetLink) ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px;background:#f7fafb;color:#6d7d86;font-size:12px;line-height:1.5">
                            Abaikan email ini jika Anda tidak meminta reset password. Password lama tetap aktif sampai Anda membuat password baru.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
