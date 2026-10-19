<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
</head>
<body>
    <h1>Kayıt Ol</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/register">
        @csrf
        <div>
            <label>İsim Soyisim</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required>
        </div>
        <div>
            <label>E-posta</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Şifre</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Şifre Tekrarı</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Kayıt Ol</button>
    </form>

    <p>Zaten hesabın var mı? <a href="/login">Giriş Yap</a></p>
</body>
</html>
