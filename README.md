<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Egegen Laravel API

Laravel 11 tabanlı bu API projesi, Bearer Token doğrulama ve kuyruk (queue) mekanizması ile yapılandırılmıştır.

---

## 🚀 Kurulum Adımları

1. **Bağımlılıkları Yükleyin**

```bash
composer install
```

2. **`.env` Dosyasını Oluşturun ve Ayarları Yapın**

```bash
cp .env.example .env
```

`.env` içerisine aşağıdaki satır mutlaka eklenmeli:

```env
BEARER_TOKEN=
```

Veritabanı ve diğer ayarları tamamlayın (`DB_*`, `APP_URL`, vs.).

3. **Uygulama Anahtarı Oluşturun**

```bash
php artisan key:generate
```

4. **Veritabanı Tablolarını Oluşturun**

```bash
php artisan migrate
```

---

## 🪄 Queue (Kuyruk) Sistemi

Bu projede queue yapısı aktif olarak kullanılmaktadır.

### Queue Tablosunu Oluşturun (gerekirse)

```bash
php artisan queue:table
php artisan migrate
```

### Kuyruğu Başlatın

```bash
php artisan queue:work
```

---

## 🔐 API Token Kullanımı

API istekleri için `BEARER_TOKEN` zorunludur.

### Örnek:

```bash
curl --location 'http://yourdomain.test/api/news' \
--header 'Authorization: Bearer {{token}}'
```

---

## 🧪 Test Verisi Üretimi

```bash
php artisan db:seed
```

---
