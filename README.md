# kle

Laravel ile geliştirilmiş basit bir ürün yönetim uygulaması. Kullanıcılar kayıt olup giriş yapabilir, ürün ekleyip düzenleyebilir.

## Kullanılan Teknolojiler

- PHP 8.3
- Laravel 12
- MySQL
- Docker / Laravel Sail

## Kurulum

### Gereksinimler

- Docker Desktop bilgisayarınızda kurulu ve çalışıyor olmalı

### Adımlar

1. Repoyu klonlayın:

```bash
git clone https://github.com/Wolvolord/kle.git
cd kle
```

2. `.env` dosyasını oluşturun:

```bash
cp .env.example .env
```

3. Docker container'larını başlatın:

```bash
./vendor/bin/sail up -d
```

4. Uygulama anahtarını oluşturun:

```bash
./vendor/bin/sail artisan key:generate
```

5. Veritabanı tablolarını oluşturun:

```bash
./vendor/bin/sail artisan migrate
```

6. Tarayıcıda açın:

```
http://localhost
```

## Durdurma

```bash
./vendor/bin/sail down
```
