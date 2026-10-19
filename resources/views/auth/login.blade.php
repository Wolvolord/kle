<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
</head>
<body>
    <h1>Giriş Yap</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/login">
        @csrf
        <div>
            <label>E-posta</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Şifre</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Giriş Yap</button>
    </form>

    <p>Hesabın yok mu? <a href="/register">Kayıt Ol</a></p>
</body>
</html>
