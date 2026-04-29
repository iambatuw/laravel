<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nöbetçi Öğretmen Takip Sistemi - Güvenli Giriş">
    <title>Giriş Yap | Nöbet Kontrol Sistemi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0b0f1a;
            color: #e2e8f0;
        }

        .login-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            border-radius: 50%;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(147, 51, 234, 0.06) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            border-radius: 50%;
        }

        .login-right {
            width: 480px;
            min-height: 100vh;
            background: #111827;
            border-left: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
            z-index: 2;
        }

        .brand-panel {
            position: relative;
            z-index: 1;
            max-width: 400px;
            text-align: center;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            margin-bottom: 32px;
            box-shadow: 0 12px 32px rgba(99, 102, 241, 0.25);
        }

        .brand-panel h1 {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
        }

        .brand-panel p {
            color: #94a3b8;
            font-size: 15px;
            line-height: 1.7;
            max-width: 340px;
            margin: 0 auto 40px;
        }

        .brand-features {
            display: flex;
            flex-direction: column;
            gap: 16px;
            text-align: left;
        }

        .brand-features .feature {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 14px;
        }

        .brand-features .feature i {
            font-size: 20px;
            color: #818cf8;
            width: 24px;
            text-align: center;
        }

        .brand-features .feature span {
            font-size: 13px;
            color: #cbd5e1;
            font-weight: 500;
        }

        .form-wrapper {
            width: 100%;
        }

        .form-wrapper h2 {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .form-wrapper .subtitle {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .field .input-wrap {
            position: relative;
        }

        .field .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            font-size: 16px;
            transition: color 0.2s;
        }

        .field input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 13px 14px 13px 44px;
            color: #f1f5f9;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .field input:focus {
            outline: none;
            border-color: #6366f1;
            background: rgba(255,255,255,0.06);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .field input:focus + i,
        .field .input-wrap:focus-within i {
            color: #818cf8;
        }

        .field input::placeholder { color: #374151; }

        .error-msg {
            color: #f87171;
            font-size: 12px;
            margin-top: 6px;
            font-weight: 500;
        }

        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .options-row label {
            font-size: 13px;
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .options-row label input[type="checkbox"] {
            accent-color: #6366f1;
            width: 16px;
            height: 16px;
        }

        .options-row a {
            font-size: 13px;
            color: #818cf8;
            text-decoration: none;
            font-weight: 500;
        }

        .options-row a:hover { color: #a5b4fc; }

        .cf-turnstile {
            margin: 0 0 20px;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            color: #fff;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.2px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.35);
        }

        .btn-login:active { transform: translateY(0); }

        .login-footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .login-footer a {
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .login-footer a:hover { color: #818cf8; }

        .login-footer span {
            color: #334155;
            margin: 0 8px;
        }

        @media (max-width: 960px) {
            body { flex-direction: column; }
            .login-left { display: none; }
            .login-right {
                width: 100%;
                min-height: 100vh;
                border-left: none;
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-left">
        <div class="brand-panel">
            <div class="brand-logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h1>Nöbet Kontrol Sistemi</h1>
            <p>Öğretmen nöbet yönetimini dijital ortamda kolayca planlayın, takip edin ve raporlayın.</p>

            <div class="brand-features">
                <div class="feature">
                    <i class="bi bi-calendar-check"></i>
                    <span>Otomatik nöbet çizelgesi oluşturma</span>
                </div>
                <div class="feature">
                    <i class="bi bi-arrow-left-right"></i>
                    <span>Öğretmenler arası nöbet takas sistemi</span>
                </div>
                <div class="feature">
                    <i class="bi bi-display"></i>
                    <span>Canlı nöbet panosu ve anlık takip</span>
                </div>
                <div class="feature">
                    <i class="bi bi-file-earmark-pdf"></i>
                    <span>PDF çıktı ve raporlama desteği</span>
                </div>
            </div>
        </div>
    </div>

    <div class="login-right">
        <div class="form-wrapper">
            <h2>Sisteme Giriş</h2>
            <p class="subtitle">Devam etmek için kimlik bilgilerinizi giriniz.</p>

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <div class="field">
                    <label>E-posta Adresi</label>
                    <div class="input-wrap">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="ornek@okul.edu.tr" required autofocus>
                        <i class="bi bi-envelope"></i>
                    </div>
                    @error('email')
                        <div class="error-msg"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Parola</label>
                    <div class="input-wrap">
                        <input type="password" name="password" placeholder="Parolanızı giriniz" required>
                        <i class="bi bi-lock"></i>
                    </div>
                    @error('password')
                        <div class="error-msg"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="options-row">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Oturumu açık tut
                    </label>
                    <a href="{{ route('password.request') }}">Parolamı unuttum</a>
                </div>

                <div class="cf-turnstile" data-sitekey="0x4AAAAAADFkbAiMFLP3oXTM" data-theme="dark"></div>

                <button type="submit" class="btn-login">
                    Giriş Yap
                </button>
            </form>

            <div class="login-footer">
                <a href="{{ route('public.board') }}"><i class="bi bi-broadcast me-1"></i>Nöbet Panosu</a>
                <span>|</span>
                <span style="color: #334155; font-size: 12px;">&copy; {{ date('Y') }} Nöbet Kontrol</span>
            </div>
        </div>
    </div>
</body>
</html>
