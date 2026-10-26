# kle

Laravel ile geliştirilmiş basit bir ürün yönetim uygulaması. Kullanıcılar kayıt olup giriş yapabilir, ürün ekleyip düzenleyebilir.

## Kullanılan Teknolojiler

- PHP 8.4
- Laravel 12
- MySQL 8.0
- Nginx
- Docker

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

3. `.env` dosyasında veritabanı ayarlarını güncelleyin:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=kle
DB_USERNAME=kle_user
DB_PASSWORD=secret
```

4. Docker container'larını başlatın:

```bash
docker compose up -d --build
```

5. Uygulama anahtarını oluşturun:

```bash
docker compose exec app php artisan key:generate
```

6. Veritabanı tablolarını oluşturun:

```bash
docker compose exec app php artisan migrate
```

7. Tarayıcıda açın:

```
http://localhost:8000
```

## Durdurma

```bash
docker compose down
```
