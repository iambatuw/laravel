<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Nöbetçi Öğretmen Takip Sistemi - Güvenli ve Dijital Yönetim Paneli">
    <title>@yield('title', 'Nöbet Kontrol v2.0')</title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- SweetAlert2 Premium -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body>
    <div id="safety-overlay">
        <div style="font-size: 120px; margin-bottom: 30px;">🔐</div>
        <h1 style="font-weight: 900; font-size: 48px; margin-bottom: 20px;">ERİŞİM REDDEDİLDİ</h1>
        <p style="opacity: 0.6; font-size: 20px; max-width: 600px;">Geliştirici araçlarının (F12) kullanımı güvenlik politikalarımız gereği engellenmiştir. İşlem günlüğe kaydedildi.</p>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" id="mainSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h4>Nöbet Kontrol</h4>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-label">Ana Panel</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Kontrol Paneli</span>
            </a>

            <a href="{{ route('schedules.today') }}" class="sidebar-link {{ request()->routeIs('schedules.today') ? 'active' : '' }}">
                <i class="bi bi-calendar2-week-fill"></i>
                <span>Günlük Akış</span>
            </a>

            @if(auth()->check() && auth()->user()->isAdmin())
                <div class="menu-label">Yönetim Birimi</div>
                <a href="{{ route('teachers.index') }}" class="sidebar-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span class="small fw-bold">Öğretmen Yönetimi</span>
                </a>

                <a href="{{ route('locations.index') }}" class="sidebar-link {{ request()->routeIs('locations.*') ? 'active' : '' }}">
                    <i class="bi bi-pin-map-fill"></i>
                    <span>Nöbet Noktaları</span>
                </a>

                <a href="{{ route('schedules.index') }}" class="sidebar-link {{ request()->routeIs('schedules.*') && !request()->routeIs('schedules.today') ? 'active' : '' }}">
                    <i class="bi bi-layers-fill"></i>
                    <span>Çizelge Planlama</span>
                </a>
            @endif

            <div class="menu-label">Sistem & Profil</div>
            <a href="{{ route('swap-requests.index') }}" class="sidebar-link {{ request()->routeIs('swap-requests.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-down-up"></i>
                <span>Takas Talepleri</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>Ayarlarım</span>
            </a>
        </nav>
    </aside>

    <!-- Content Wrapper -->
    <div class="main-wrapper">
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-4">
                <div class="menu-toggle" id="mToggle">
                    <i class="bi bi-list fs-3"></i>
                </div>
                <div class="page-header">
                    <h1 class="text-white">@yield('page-title', 'Genel Bakış')</h1>
                </div>
            </div>

            <div class="dropdown">
                <div class="user-pill d-flex align-items-center gap-3" data-bs-toggle="dropdown" style="padding: 6px 10px 6px 20px;">
                    <div class="text-end d-none d-md-block" style="line-height: 1.1;">
                        <div class="fw-black text-white" style="font-size: 14px; letter-spacing: -0.2px;">{{ auth()->user()->name }}</div>
                        <div class="text-primary fw-black text-uppercase mt-1" style="font-size: 8.5px; letter-spacing: 1px;">{{ auth()->user()->role === 'admin' ? 'SYSTEM ADMIN' : 'TEACHER' }}</div>
                    </div>
                    <div class="avatar-box shadow-sm border border-white border-opacity-10">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-3" style="background: var(--sidebar-bg); border-radius: 20px; min-width: 250px;">
                    <li>
                        <a class="dropdown-item py-2 px-3 rounded-3 text-light d-flex align-items-center gap-3" href="{{ route('profile.edit') }}">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-2"><i class="bi bi-person-fill text-primary"></i></div>
                            <span>Kişisel Bilgiler</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider opacity-10 my-3"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 px-3 rounded-3 text-danger fw-bold d-flex align-items-center gap-3">
                                <div class="bg-danger bg-opacity-10 p-2 rounded-2"><i class="bi bi-power text-danger"></i></div>
                                <span>Güvenli Çıkış Yap</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <div class="content-body">
            @yield('content')
        </div>

        <footer class="footer py-4 mt-auto">
            <div class="text-white-50 opacity-50 small fw-bold" style="letter-spacing: 0.5px;">
                © {{ date('Y') }} Nöbet Kontrol Sistemi | Dijital Yönetim Altyapısı
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
