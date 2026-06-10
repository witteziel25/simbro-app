<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP SIMBRO</title>
</head>
<body>
    <h2>Halo, {{ $nama }}!</h2>
    <p>Kami menerima permintaan reset password untuk akun Anda.</p>
    <p>Gunakan kode OTP berikut untuk melanjutkan:</p>
    <h1 style="background: #FF6B00; color: white; display: inline-block; padding: 10px 20px; border-radius: 8px;">
        {{ $otp }}
    </h1>
    <p>Kode ini berlaku selama 15 menit.</p>
    <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.</p>
    <br>
    <p>Tim SIMBRO</p>
</body>
</html>
