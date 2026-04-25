# Nöbetçi Öğretmen Takip Sistemi

Okul bünyesindeki günlük nöbet çizelgelerini oluşturan ve nöbet yerlerini (bahçe, katlar vb.) dijital ortamda yöneten Laravel tabanlı web paneli.

## Proje Hakkında

Bu sistem ile:
- Günlük nöbet çizelgeleri oluşturulabilir
- Nöbet yerleri (bahçe, kat koridorları, kantin önü vb.) yönetilebilir
- Öğretmenler nöbet yerlerine atanabilir
- Öğretmenler kendi aralarında nöbet takası talep edebilir
- Nöbet geçmişi ve istatistikleri takip edilebilir

## Teknik Özellikler

- **Framework:** Laravel 11
- **Veritabanı:** MySQL
- **Authentication:** Manuel Login sistemi
- **Yetkilendirme:** Admin Middleware
- **Arayüz:** Blade Template Engine + Bootstrap 5
- **Bildirimler:** SweetAlert2 (Flash Messages)
- **Soft Deletes:** Tüm modellerde aktif
- **Pagination:** Tüm liste sayfalarında aktif

## Kurulum

### Gereksinimler
- PHP 8.2+
- Composer
- MySQL
- Node.js (opsiyonel, Vite için)

### Adımlar

1. **Projeyi klonlayın:**
```bash
git clone <REPO_URL>
cd nobetci-ogretmen-takip
```

2. **Bağımlılıkları yükleyin:**
```bash
composer install
```

3. **Ortam dosyasını oluşturun:**
```bash
cp .env.example .env
```

4. **Uygulama anahtarını oluşturun:**
```bash
php artisan key:generate
```

5. **Veritabanı ayarlarını yapın:**
`.env` dosyasındaki `DB_DATABASE`, `DB_USERNAME` ve `DB_PASSWORD` alanlarını düzenleyin.

6. **Tabloları oluşturun ve test verisi yükleyin:**
```bash
php artisan migrate --seed
```

7. **Storage linkini oluşturun:**
```bash
php artisan storage:link
```

8. **Sunucuyu başlatın:**
```bash
php artisan serve
```

Uygulama `http://localhost:8000` adresinde açılacaktır.

## Giriş Bilgileri (Test)

| Rol | E-posta | Şifre |
|-----|---------|-------|
| **Admin** | admin@nobetci.com | password |
| **Öğretmen** | fatma.demir@nobetci.com | password |

## Veritabanı Yapısı

```
users            - Yöneticiler ve öğretmenler
locations        - Nöbet yerleri (bahçe, kat koridorları vb.)
duty_schedules   - Günlük nöbet çizelgeleri
duty_assignments - Nöbet atamaları (öğretmen-yer-zaman)
swap_requests    - Nöbet takas talepleri
```

### İlişkiler (Eloquent Relationships)

- `User` hasMany `DutyAssignment` (Bir öğretmenin birçok nöbeti)
- `User` hasMany `DutySchedule` (Yöneticinin oluşturduğu çizelgeler)
- `Location` hasMany `DutyAssignment` (Bir yerin birçok ataması)
- `DutySchedule` hasMany `DutyAssignment` (Bir çizelgenin birçok ataması)
- `DutyAssignment` belongsTo `User`, `Location`, `DutySchedule`
- `SwapRequest` belongsTo `User` (requester, target, approver)

## Proje Yapısı

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/LoginController.php
│   │   ├── DashboardController.php
│   │   ├── DutyAssignmentController.php
│   │   ├── DutyScheduleController.php
│   │   ├── LocationController.php
│   │   ├── ProfileController.php
│   │   ├── SwapRequestController.php
│   │   └── TeacherController.php
│   ├── Middleware/
│   │   └── AdminMiddleware.php
│   └── Requests/
│       ├── StoreDutyScheduleRequest.php
│       ├── StoreLocationRequest.php
│       ├── StoreTeacherRequest.php
│       └── UpdateLocationRequest.php
├── Models/
│   ├── DutyAssignment.php
│   ├── DutySchedule.php
│   ├── Location.php
│   ├── SwapRequest.php
│   └── User.php
database/
├── factories/
├── migrations/
└── seeders/DatabaseSeeder.php
resources/views/
├── assignments/
├── auth/
├── dashboard/
├── errors/
├── layouts/
├── locations/
├── profile/
├── schedules/
├── swap_requests/
└── teachers/
```

## Kullanılan Laravel Özellikleri

- **Migrations:** Tüm tablolar migration ile oluşturulmuştur
- **Eloquent ORM:** Model ilişkileri (hasMany, belongsTo)
- **Seeders:** 20 öğretmen, 10 nöbet yeri, 1 haftalık çizelge test verisi
- **Middleware:** Admin erişim kontrolü
- **Form Request Validation:** Ayrı Request sınıfları ile doğrulama
- **Soft Deletes:** Silinen kayıtlar `deleted_at` ile işaretlenir
- **Resource Controllers:** CRUD operasyonları standart metot isimleri ile
- **Named Routes:** Tüm linkler `route()` helper ile
- **Blade Templating:** `@extends`, `@section`, `@include`, `@stack` kullanımı
- **Flash Messages:** SweetAlert2 ile anlık bildirimler
- **File Storage:** Avatar yüklemeleri Laravel Storage sistemi ile
- **Pagination:** Sayfalama tüm listeleme sayfalarında aktif

## Lisans

MIT
