@extends('layouts.app')

@section('title', 'Profilim | Nöbet Kontrol')
@section('page-title', 'Kişisel Profil Ayarları')

@section('content')
    <div class="row g-4 justify-content-center">
        <!-- Profil Bilgileri -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-light border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-person-bounding-box me-2 text-primary"></i>Profil Detayları</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-5">
                            <div class="user-avatar mx-auto mb-3" style="width:80px;height:80px;font-size:32px;border-radius:20px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill border border-primary border-opacity-25" style="font-size: 11px;">
                                {{ $user->isAdmin() ? 'Sistem Yöneticisi' : 'Öğretmen' }}
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold">Tam Ad Soyad</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-white">E-posta Adresi</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-white">İletişim No</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="05XX XXX XX XX">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="text-end mt-5 pt-4 border-top border-light border-opacity-10">
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg">
                                Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Şifre Güncelleme -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-light border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-shield-lock me-2 text-primary"></i>Güvenlik Ayarları</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Geçerli Parola</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Yeni Parola</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Parola Tekrarı</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="p-3 bg-dark bg-opacity-25 rounded-3 mb-4">
                            <div class="d-flex gap-3">
                                <i class="bi bi-info-circle text-info fs-5"></i>
                                <small class="text-muted">Güçlü bir parola için en az 8 karakter, rakam ve sembol kullanmanız önerilir.</small>
                            </div>
                        </div>

                        <div class="text-end mt-auto">
                            <button type="submit" class="btn btn-outline-primary w-100 fw-bold py-2">
                                Parolayı Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
