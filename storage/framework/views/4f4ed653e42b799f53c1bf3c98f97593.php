<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nöbetçi Öğretmen Takip Sistemi - Güvenli Giriş">
    <title>Giriş Yap | Nöbet Kontrol Sistemi</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Cloudflare Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
            --bg-dark: rgb(15, 23, 42);
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-main: rgb(248, 250, 252);
            --text-muted: rgb(148, 163, 184);
            --border-color: rgba(255, 255, 255, 0.1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-dark);
            position: relative;
            overflow: hidden;
            color: var(--text-main);
        }

        /* Arkaplan Animasyonu */
        .bg-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            filter: blur(60px);
        }
        .glow-1 { top: -100px; left: -100px; }
        .glow-2 { bottom: -100px; right: -100px; }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeInScale 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .brand-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-gradient);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: rgb(255, 255, 255);
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        .brand-section h2 {
            font-weight: 700;
            font-size: 24px;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .brand-section p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .form-label {
            font-weight: 500;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: block;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px 12px 48px;
            color: var(--text-main);
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgb(99, 102, 241);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-login {
            width: 100%;
            background: var(--primary-gradient);
            border: none;
            color: rgb(255, 255, 255);
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(79, 70, 229, 0.4);
        }

        .form-check-label {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* Turnstile Widget Styling */
        .cf-turnstile {
            margin: 15px 0;
            display: flex;
            justify-content: center;
        }

        .error-msg {
            color: rgb(239, 68, 68);
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }

        .footer-links {
            text-align: center;
            margin-top: 25px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--text-main);
        }

        .sep {
            margin: 0 10px;
            color: var(--border-color);
        }
    </style>
</head>
<body>
    <div class="bg-glow glow-1"></div>
    <div class="bg-glow glow-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-section">
                <div class="brand-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h2>Hoş Geldiniz</h2>
                <p>Sisteme erişmek için kimlik bilgilerinizi girin.</p>
            </div>

            <form method="POST" action="<?php echo e(route('login.attempt')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">E-posta Adresi</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope"></i>
                        <input
                            type="email"
                            class="form-control-custom"
                            name="email"
                            value="<?php echo e(old('email')); ?>"
                            placeholder="eposta@okul.edu.tr"
                            required
                            autofocus
                        >
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-msg"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Güvenli Şifre</label>
                    <div class="input-group-custom">
                        <i class="bi bi-key"></i>
                        <input
                            type="password"
                            class="form-control-custom"
                            name="password"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-msg"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="remember">Beni hatırla</label>
                    </div>
                    <a href="<?php echo e(route('password.request')); ?>" style="font-size: 13px; color: rgb(129, 140, 248); text-decoration: none; font-weight: 500;">Şifremi unuttum?</a>
                </div>

                <!-- Cloudflare Turnstile Widget -->
                <div class="cf-turnstile" data-sitekey="1x00000000000000000000AA" data-theme="dark"></div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Sisteme Giriş Yap
                </button>
            </form>

            <div class="footer-links">
                <a href="<?php echo e(route('public.board')); ?>"><i class="bi bi-broadcast me-1"></i> Nöbet Panosu</a>
                <span class="sep">|</span>
                <span style="font-size: 12px; color: var(--text-muted);">v2.0 Güvenli Erişim</span>
            </div>
        </div>
    </div>

    <script>
        // Sağ tık ve DevTools Koruması
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.onkeydown = function(e) {
            if(e.keyCode == 123) return false;
            if(e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 74 || e.keyCode == 67)) return false;
            if(e.ctrlKey && e.keyCode == 85) return false;
        };
    </script>
</body>
</html>
<?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>