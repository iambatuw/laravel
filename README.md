# Nöbetçi Öğretmen Takip Sistemi

Okul bünyesindeki günlük nöbet çizelgelerini dijital ortamda oluşturan, öğretmen atamalarını yöneten ve canlı nöbet panosu sunan Laravel tabanlı modern web uygulaması.

> **Canlı Demo:** [https://1648.altekbilisim.com/public/](https://1648.altekbilisim.com/public/)

---

## Özellikler

### Temel Fonksiyonlar
- Günlük / haftalık nöbet çizelgesi oluşturma ve yönetme
- Öğretmenleri nöbet noktalarına atama (periyot bazlı)
- Nöbet noktaları yönetimi (bahçe, kat koridorları, kantin önü vb.)
- Öğretmenler arası nöbet takas talep sistemi
- Canlı nöbet panosu (TV / projeksiyon görünümü)
- Hızlı nöbet atama (admin dashboard'dan tek tıkla)
- Nöbet çizelgesi PDF yazdırma
- Profil ve parola yönetimi

### Güvenlik
- **Cloudflare Turnstile** entegrasyonu (bot koruması)
- **Content Security Policy (CSP)** başlıkları
- HSTS, X-Frame-Options, X-Content-Type-Options başlıkları
- Rate limiting ile brute-force koruması
- CSRF token doğrulaması

### Tasarım ve Arayüz
- Koyu tema (dark mode) tasarım
- **Inter** font ailesi
- Bootstrap 5 + özel CSS değişkenleri
- Duyarlı tasarım (mobil uyumlu)
- SweetAlert2 ile onay diyalogları ve bildirimler
- Türkçe arayüz ve sayfalama

---

## Teknik Altyapı

| Bileşen | Teknoloji |
|---------|-----------|
| Framework | Laravel 11 |
| PHP | 8.2+ |
| Veritabanı | MySQL |
| Ön Yüz | Blade + Bootstrap 5 |
| Varlık Derleme | Vite |
| Font | Inter (Google Fonts) |
| İkonlar | Bootstrap Icons |
| Bildirimler | SweetAlert2 |
| Bot Koruması | Cloudflare Turnstile |
| Deploy | GitHub Actions + FTP |

---

## Kurulum

### Gereksinimler
- PHP 8.2+
- Composer
- MySQL
- Node.js 20+ ve npm

### Adımlar

```bash
# 1. Projeyi klonlayın
git clone https://github.com/iambatuw/laravel.git
cd laravel

# 2. PHP bağımlılıklarını yükleyin
composer install

# 3. Ortam dosyasını oluşturun
cp .env.example .env

# 4. Uygulama anahtarını oluşturun
php artisan key:generate

# 5. .env dosyasında veritabanı ayarlarını yapın
# DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Tabloları oluşturun ve test verisi yükleyin
php artisan migrate --seed

# 7. Storage linkini oluşturun
php artisan storage:link

# 8. Vite varlıklarını derleyin
npm install && npm run build

# 9. Sunucuyu başlatın
php artisan serve
```

Uygulama `http://localhost:8000` adresinde açılacaktır.

### Cloudflare Turnstile Yapılandırması

`.env` dosyasına Turnstile anahtarlarını ekleyin:

```env
TURNSTILE_SITE_KEY=your_site_key
TURNSTILE_SECRET_KEY=your_secret_key
```

> Anahtarlar boş bırakılırsa Turnstile devre dışı kalır, giriş normal şekilde çalışır.

---

## Giriş Bilgileri (Test)

| Rol | E-posta | Parola |
|-----|---------|--------|
| Yönetici | admin@nobetci.com | password |
| Öğretmen | fatma.demir@nobetci.com | password |

---

## Veritabanı Yapısı

```
users              Yöneticiler ve öğretmenler
locations          Nöbet yerleri (bahçe, kat koridorları vb.)
duty_schedules     Günlük nöbet çizelgeleri
duty_assignments   Nöbet atamaları (öğretmen - yer - zaman)
swap_requests      Nöbet takas talepleri
sessions           Oturum yönetimi
cache              Önbellek tablosu
```

### İlişkiler

- `User` hasMany `DutyAssignment`, `DutySchedule`, `SwapRequest`
- `Location` hasMany `DutyAssignment`
- `DutySchedule` hasMany `DutyAssignment`, belongsTo `User` (oluşturan)
- `DutyAssignment` belongsTo `User`, `Location`, `DutySchedule`
- `SwapRequest` belongsTo `User` (talep eden, hedef, onaylayan)

---

## Proje Yapısı

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   └── PasswordResetController.php
│   │   ├── DashboardController.php
│   │   ├── DutyAssignmentController.php
│   │   ├── DutyScheduleController.php
│   │   ├── LocationController.php
│   │   ├── ProfileController.php
│   │   ├── PublicController.php
│   │   ├── SwapRequestController.php
│   │   └── TeacherController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       └── SecurityHeadersMiddleware.php
├── Models/
│   ├── DutyAssignment.php
│   ├── DutySchedule.php
│   ├── Location.php
│   ├── SwapRequest.php
│   └── User.php
config/
└── services.php              (Turnstile yapılandırması)
resources/
├── css/app.css               (Ana stil dosyası)
├── js/app.js
└── views/
    ├── auth/                 (Giriş, parola sıfırlama)
    ├── dashboard/            (Admin ve öğretmen paneli)
    ├── layouts/              (Ana şablon, sidebar, navbar)
    ├── locations/            (Nöbet noktaları CRUD)
    ├── profile/              (Profil ve güvenlik ayarları)
    ├── schedules/            (Çizelge CRUD, yazdırma)
    ├── swap_requests/        (Takas talepleri)
    └── teachers/             (Öğretmen yönetimi)
```

---

## Deploy

Proje **GitHub Actions** ile otomatik deploy edilmektedir.

- `main` dalına push yapıldığında workflow tetiklenir
- Composer bağımlılıkları yüklenir, Vite varlıkları derlenir
- FTP ile sunucuya aktarılır

Workflow dosyası: `.github/workflows/deploy.yml`

> **Not:** `.env` dosyası deploy kapsamında gönderilmez. Sunucudaki `.env` dosyası FTP ile manuel yönetilir.

---

## Kullanılan Laravel Özellikleri

- **Eloquent ORM** — Model ilişkileri (hasMany, belongsTo, SoftDeletes)
- **Migrations & Seeders** — Veritabanı şeması ve test verileri
- **Middleware** — Admin erişim kontrolü, güvenlik başlıkları (CSP)
- **Form Request Validation** — Ayrı Request sınıfları ile doğrulama
- **Soft Deletes** — Silinen kayıtlar geri alınabilir
- **Resource Controllers** — Standart CRUD operasyonları
- **Named Routes** — Tüm bağlantılar `route()` helper ile
- **Blade Templating** — `@extends`, `@section`, `@stack`, `@push`
- **Flash Messages** — SweetAlert2 ile bildirimler
- **File Storage** — Avatar yüklemeleri
- **Pagination** — Türkçe sayfalama (Bootstrap 5)
- **Vite** — CSS ve JS varlık derleme

---

## Lisans

MIT
