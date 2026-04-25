<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nöbetçi Öğretmen Takip Sistemi - Güvenli Şifre Yenileme">
    <title>Şifre Yenileme | Nöbet Kontrol Sistemi</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Cloudflare Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
            --bg-dark: rgb(15, 23, 42);
            --card-bg: rgba(30, 41, 59, 0.8);
            --text-main: rgb(248, 250, 252);
            --text-muted: rgb(148, 163, 184);
            --border-color: rgba(255, 255, 255, 0.12);
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
            overflow-x: hidden;
            color: var(--text-main);
        }

        .bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(147, 51, 234, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            filter: blur(100px);
        }
        .glow-1 { top: -200px; right: -200px; }
        .glow-2 { bottom: -200px; left: -200px; }

        .reset-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            padding: 24px;
        }

        .reset-card {
            background: var(--card-bg);
            backdrop-filter: blur(30px);
            border: 1px solid var(--border-color);
            border-radius: 32px;
            padding: 48px;
            box-shadow: 0 35px 70px -15px rgba(0, 0, 0, 0.6);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #fff;
            margin-bottom: 24px;
            box-shadow: 0 12px 25px rgba(147, 51, 234, 0.35);
        }

        .brand-section h2 {
            font-weight: 800;
            font-size: 28px;
            letter-spacing: -0.8px;
            margin-bottom: 10px;
        }

        .brand-section p {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 500;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 10px;
            display: block;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 24px;
        }

        .input-group-custom i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 20px;
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 14px 18px 14px 54px;
            color: var(--text-main);
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control-custom:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgb(129, 140, 248);
            box-shadow: 0 0 0 5px rgba(129, 140, 248, 0.15);
        }

        .btn-action {
            width: 100%;
            background: var(--primary-gradient);
            border: none;
            color: #fff;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.4s ease;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(147, 51, 234, 0.4);
        }

        .back-to-login {
            text-align: center;
            margin-top: 32px;
        }

        .back-to-login a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-to-login a:hover {
            color: var(--text-main);
        }

        .error-msg {
            color: rgb(239, 68, 68);
            font-size: 12px;
            margin-top: 6px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="bg-glow glow-1"></div>
    <div class="bg-glow glow-2"></div>

    <div class="reset-container">
        <div class="reset-card">
            <div class="brand-section">
                <div class="brand-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h2>Şifre Yenileme</h2>
                <p>Erişiminizi güvenli bir şekilde kurtarın.</p>
            </div>

            <form method="POST" action="<?php echo e(route('password.reset')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-2">
                    <label class="form-label">E-posta Adresi</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope-at-fill"></i>
                        <input
                            type="email"
                            class="form-control-custom"
                            name="email"
                            value="<?php echo e(old('email')); ?>"
                            placeholder="eposta@adresiniz.com"
                            required
                        >
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-msg"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Yeni Şifre</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill"></i>
                        <input
                            type="password"
                            class="form-control-custom"
                            name="password"
                            placeholder="Yeni şifrenizi girin"
                            required
                        >
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-msg"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Şifre Tekrar</label>
                    <div class="input-group-custom">
                        <i class="bi bi-patch-check-fill"></i>
                        <input
                            type="password"
                            class="form-control-custom"
                            name="password_confirmation"
                            placeholder="Şifreyi onaylayın"
                            required
                        >
                    </div>
                </div>

                <!-- Cloudflare Turnstile Widget -->
                <div class="cf-turnstile mb-4 d-flex justify-content-center" data-sitekey="1x00000000000000000000AA" data-theme="dark"></div>

                <button type="submit" class="btn-action">
                    <i class="bi bi-arrow-right-circle-fill me-2"></i> Şifremi Güncelle
                </button>
            </form>

            <div class="back-to-login">
                <a href="<?php echo e(route('login')); ?>">
                    <i class="bi bi-arrow-left"></i> Giriş Ekranına Dön
                </a>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/auth/reset.blade.php ENDPATH**/ ?>