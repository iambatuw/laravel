# Deploy için gerekli dosyalar
 = "C:\Users\batuh\OneDrive\Masaüstü\laravel_deploy"
if (-not (Test-Path )) {
    New-Item -ItemType Directory -Path  | Out-Null
}

# Kopyalanacak dizinler
 = @("app", "bootstrap", "config", "database", "public", "resources", "routes")
 = @("artisan", "composer.json", ".env.production")

foreach ( in ) {
     = "C:\Users\batuh\OneDrive\Masaüstü\laravel\"
     = "\"
    if (Test-Path ) {
        Copy-Item -Path  -Destination  -Recurse -Force
        Write-Host "Kopyalandı: "
    }
}

foreach ( in ) {
     = "C:\Users\batuh\OneDrive\Masaüstü\laravel\"
     = "\"
    if (Test-Path ) {
        Copy-Item -Path  -Destination  -Force
        Write-Host "Kopyalandı: "
    }
}

Write-Host "Deploy dosyaları hazır: " -ForegroundColor Green
