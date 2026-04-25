<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Erişim Engellendi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f85032 0%, #e73827 100%);
            color: #fff;
        }
        .error-container { text-align: center; padding: 40px; }
        .error-code { font-size: 120px; font-weight: 800; opacity: 0.3; line-height: 1; }
        .error-title { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        .error-text { font-size: 16px; opacity: 0.8; margin-bottom: 32px; }
        .error-btn {
            display: inline-block; padding: 14px 32px;
            background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);
            border-radius: 10px; color: #fff; text-decoration: none;
            font-weight: 600; transition: all 0.3s;
        }
        .error-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">403</div>
        <h1 class="error-title">Erişim Engellendi</h1>
        <p class="error-text">Bu sayfaya erişim yetkiniz bulunmamaktadır.</p>
        <a href="<?php echo e(url('/dashboard')); ?>" class="error-btn">Ana Sayfaya Dön</a>
    </div>
</body>
</html>
<?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/errors/403.blade.php ENDPATH**/ ?>