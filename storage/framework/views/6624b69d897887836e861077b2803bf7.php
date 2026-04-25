<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="Nöbetçi Öğretmen Takip Sistemi - Güvenli ve Dijital Yönetim Paneli">
    <title><?php echo $__env->yieldContent('title', 'Nöbet Kontrol v2.0'); ?></title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- SweetAlert2 Premium -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
            --background-dark: rgb(15, 23, 42);
            --sidebar-bg: rgb(30, 41, 59);
            --card-bg: rgb(44, 56, 74);
            --navbar-bg: rgba(15, 23, 42, 0.95);
            --sidebar-hover: rgba(255, 255, 255, 0.05);
            --text-main: rgb(248, 250, 252);
            --text-muted: rgb(170, 185, 205);
            --border-color: rgba(15, 23, 42, 1);
            --glass-bg: rgba(255, 255, 255, 0.02);
            --border-radius: 18px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -2px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--background-dark) !important;
            color: var(--text-main) !important;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            font-size: 13px; /* Versatile Scale */
        }

        /* Sidebar Modern Görünüm */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid rgba(255,255,255,0.05);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1001;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 30px 20px;
            text-align: center;
        }

        .brand-icon {
            width: 44px; /* Reduced */
            height: 44px;
            background: var(--primary-gradient);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            margin: 0 auto 12px;
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        }

        .sidebar-brand h4 {
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0px;
            font-size: 20px; 
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            padding: 5px 12px;
        }

        .menu-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1.5px;
            padding: 15px 12px 8px;
            opacity: 0.4;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            margin-bottom: 3px;
        }

        .sidebar-link:hover {
            color: var(--text-main);
            background: var(--sidebar-hover);
        }

        .sidebar-link.active {
            background: var(--primary-gradient);
            color: #fff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .sidebar-link i { font-size: 18px; width: 22px; text-align: center; }

        /* Ana İçerik Alanı */
        .main-wrapper {
            flex: 1;
            margin-left: 250px;
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-navbar {
            height: 75px; /* Reduced */
            background: var(--navbar-bg);
            backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header h1 {
            font-size: 22px; /* Reduced */
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .user-pill {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 6px 8px 6px 16px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .avatar-box {
            width: 36px;
            height: 36px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: 16px;
        }

        .content-body {
            padding: 30px; /* Reduced */
            flex: 1;
        }

        /* Kartlar ve Tablolar */
        .card {
            border: 1px solid var(--border-color) !important;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            background: linear-gradient(145deg, rgba(44, 56, 74, 1) 0%, rgba(30, 41, 59, 1) 100%) !important;
        }

        .table {
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
            background: transparent !important;
        }

        .table thead th {
            padding: 20px 30px;
            background: rgba(0, 0, 0, 0.2) !important;
            color: var(--text-muted) !important;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--border-color) !important;
        }

        .table td {
            padding: 24px 30px;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            background: transparent !important;
        }

        .table tbody tr:hover td {
            background: rgba(255, 255, 255, 0.02) !important;
        }

        h1, h2, h3, h4, h5, h6 { color: #fff !important; }
        
        /* Pagination Styles */
        .pagination { gap: 8px; margin-top: 20px; }
        .page-link {
            background: var(--sidebar-bg) !important;
            border-color: var(--border-color) !important;
            color: white !important;
            border-radius: 12px !important;
            padding: 12px 22px;
            font-weight: 700;
            transition: all 0.3s;
            font-size: 14px;
        }
        .page-item.active .page-link {
            background: var(--primary-gradient) !important;
            border-color: transparent !important;
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
        }
        .page-link:hover { background: var(--sidebar-hover) !important; transform: translateY(-2px); }
        .page-item.disabled .page-link { opacity: 0.3; cursor: not-allowed; }

        label { color: rgba(255,255,255,0.9) !important; font-weight: 700; margin-bottom: 10px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }

        .form-control, .form-select {
            background-color: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-radius: 14px !important;
            padding: 14px 20px !important;
            transition: all 0.3s !important;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(15, 23, 42, 0.8) !important;
            border-color: rgb(79, 70, 229) !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2) !important;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3) !important; }

        /* Pagination Summary Text */
        .text-muted, .small { color: rgba(255,255,255,0.4) !important; }
        .data-summary { font-size: 13px; color: rgba(255,255,255,0.4); margin-bottom: 5px; }

        /* Güvenlik Ekranı */
        #safety-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999999;
            background: var(--background-dark);
            color: white;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .footer {
            padding: 30px 40px;
            border-top: 1px solid var(--border-color);
            background: rgba(0,0,0,0.2);
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
        }

        .menu-toggle {
            width: 48px;
            height: 48px;
            display: none;
            align-items: center;
            justify-content: center;
            background: var(--glass-bg);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            color: white;
            cursor: pointer;
        }
        @media (max-width: 992px) { .menu-toggle { display: flex; } }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
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
            <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-grid-fill"></i>
                <span>Kontrol Paneli</span>
            </a>

            <a href="<?php echo e(route('schedules.today')); ?>" class="sidebar-link <?php echo e(request()->routeIs('schedules.today') ? 'active' : ''); ?>">
                <i class="bi bi-calendar2-week-fill"></i>
                <span>Günlük Akış</span>
            </a>

            <?php if(auth()->check() && auth()->user()->isAdmin()): ?>
                <div class="menu-label">Yönetim Birimi</div>
                <a href="<?php echo e(route('teachers.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('teachers.*') ? 'active' : ''); ?>">
                    <i class="bi bi-people-fill"></i>
                    <span class="small fw-bold">Öğretmen Yönetimi</span>
                </a>

                <a href="<?php echo e(route('locations.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('locations.*') ? 'active' : ''); ?>">
                    <i class="bi bi-pin-map-fill"></i>
                    <span>Nöbet Noktaları</span>
                </a>

                <a href="<?php echo e(route('schedules.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('schedules.*') && !request()->routeIs('schedules.today') ? 'active' : ''); ?>">
                    <i class="bi bi-layers-fill"></i>
                    <span>Çizelge Planlama</span>
                </a>
            <?php endif; ?>

            <div class="menu-label">Sistem & Profil</div>
            <a href="<?php echo e(route('swap-requests.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('swap-requests.*') ? 'active' : ''); ?>">
                <i class="bi bi-arrow-down-up"></i>
                <span>Takas Talepleri</span>
            </a>

            <a href="<?php echo e(route('profile.edit')); ?>" class="sidebar-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
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
                    <h1 class="text-white"><?php echo $__env->yieldContent('page-title', 'Genel Bakış'); ?></h1>
                </div>
            </div>

            <div class="dropdown">
                <div class="user-pill d-flex align-items-center gap-3" data-bs-toggle="dropdown" style="padding: 6px 10px 6px 20px;">
                    <div class="text-end d-none d-md-block" style="line-height: 1.1;">
                        <div class="fw-black text-white" style="font-size: 14px; letter-spacing: -0.2px;"><?php echo e(auth()->user()->name); ?></div>
                        <div class="text-primary fw-black text-uppercase mt-1" style="font-size: 8.5px; letter-spacing: 1px;"><?php echo e(auth()->user()->role === 'admin' ? 'SYSTEM ADMIN' : 'TEACHER'); ?></div>
                    </div>
                    <div class="avatar-box shadow-sm border border-white border-opacity-10">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-3" style="background: var(--sidebar-bg); border-radius: 20px; min-width: 250px;">
                    <li>
                        <a class="dropdown-item py-2 px-3 rounded-3 text-light d-flex align-items-center gap-3" href="<?php echo e(route('profile.edit')); ?>">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-2"><i class="bi bi-person-fill text-primary"></i></div>
                            <span>Kişisel Bilgiler</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider opacity-10 my-3"></li>
                    <li>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
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
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <footer class="footer py-4 mt-auto">
            <div class="text-white-50 opacity-50 small fw-bold" style="letter-spacing: 0.5px;">
                © <?php echo e(date('Y')); ?> Nöbet Kontrol Sistemi | Dijital Yönetim Altyapısı
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DevTools Tespiti (Gelişmiş)
            const checkSafety = () => {
                const threshold = 160;
                const body = document.getElementById('safety-overlay');
                if (window.outerWidth - window.innerWidth > threshold || window.outerHeight - window.innerHeight > threshold) {
                    body.style.display = 'flex';
                    console.clear();
                    console.log('%cDUR! BU ALANA ERIŞIM YASAKTIR.', 'color:red; font-size:30px; font-weight:bold;');
                }
            };
            setInterval(checkSafety, 1000);

            // Sağ Tık ve Tuş Engelleme
            document.addEventListener('contextmenu', e => e.preventDefault());
            document.onkeydown = function(e) {
                if(e.keyCode == 123) return false;
                if(e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 74 || e.keyCode == 67)) return false;
                if(e.ctrlKey && e.keyCode == 85) return false;
            };

            // Mobil Menü
            const mToggle = document.getElementById('mToggle');
            const sidebar = document.getElementById('mainSidebar');
            if(mToggle) {
                mToggle.onclick = () => sidebar.classList.toggle('active');
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>