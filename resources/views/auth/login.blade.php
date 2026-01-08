<!DOCTYPE html>
<html>
<head>
    <title>Login Pasien</title>
</head>
<body>
    <h2>Login Pasien</h2>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/pasien/login">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="/pasien/register">Registrasi</a></p>
</body>
</html>
