<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anasayfa</title>
</head>
<body>
    <h1>Hoş geldin, {{ Auth::user()->name }}!</h1>
    <p>Burası anasayfa. Yakında ürünler burada listelenecek.</p>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Çıkış Yap</button>
    </form>
</body>
</html>
