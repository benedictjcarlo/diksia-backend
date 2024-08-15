<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email</title>
</head>
<body>
    <h1>Verifikasi Email</h1>
    <p>Halo {{ $name }},</p>
    <p>Tolong tekan link dibawah ini untuk melakukan verifikasi email Anda:</p>
    <p><a href="{{ $verificationUrl }}">Verifikasi Email</a></p>
    <p>Link ini akan kedaluwarsa dalam 24 jam.</p>
</body>
</html>
