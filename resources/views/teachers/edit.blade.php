@extends('layouts.app')

@section('title', 'Öğretmen Düzenle | Nöbet Kontrol')
@section('page-title')
    <span class="text-muted fw-light">Profil Yönetimi:</span> {{ $teacher->name }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header py-4 px-5 border-0 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3 bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-light">Öğretmen Bilgilerini Güncelle</h5>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data" id="teacherEditForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Sol Kolon: Temel Bilgiler -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Ad Soyad</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 text-primary px-3" style="background:rgba(255,255,255,0.05);"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" class="form-control bg-dark border-0 text-light py-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $teacher->name) }}" required>
                                    </div>
                                    @error('name') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">E-posta Adresi</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 text-primary px-3" style="background:rgba(255,255,255,0.05);"><i class="bi bi-envelope-at"></i></span>
                                        <input type="email" class="form-control bg-dark border-0 text-light py-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email', $teacher->email) }}" required>
                                    </div>
                                    @error('email') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Uzmanlık / Branş</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 text-primary px-3" style="background:rgba(255,255,255,0.05);"><i class="bi bi-mortarboard"></i></span>
                                        <select class="form-select bg-dark border-0 text-light py-3 @error('branch') is-invalid @enderror" name="branch" required>
                                            @foreach(['Matematik', 'Türkçe', 'Fizik', 'Kimya', 'Biyoloji', 'Tarih', 'Coğrafya', 'İngilizce', 'Almanca', 'Müzik', 'Beden Eğitimi', 'Görsel Sanatlar', 'Bilişim Teknolojileri', 'Din Kültürü', 'Felsefe', 'Edebiyat'] as $branch)
                                                <option value="{{ $branch }}" {{ old('branch', $teacher->branch) === $branch ? 'selected' : '' }}>{{ $branch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('branch') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Sağ Kolon: Detaylar -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">İletişim Numarası</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 text-primary px-3" style="background:rgba(255,255,255,0.05);"><i class="bi bi-phone"></i></span>
                                        <input type="text" class="form-control bg-dark border-0 text-light py-3 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $teacher->phone) }}">
                                    </div>
                                    @error('phone') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Sistem Yetkisi</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 text-primary px-3" style="background:rgba(255,255,255,0.05);"><i class="bi bi-shield-check"></i></span>
                                        <select class="form-select bg-dark border-0 text-light py-3 @error('role') is-invalid @enderror" name="role" required>
                                            <option value="teacher" {{ old('role', $teacher->role) === 'teacher' ? 'selected' : '' }}>Öğretmen</option>
                                            <option value="admin" {{ old('role', $teacher->role) === 'admin' ? 'selected' : '' }}>Sistem Yöneticisi</option>
                                        </select>
                                    </div>
                                    @error('role') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Profil Görseli</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 text-primary px-3" style="background:rgba(255,255,255,0.05);"><i class="bi bi-image"></i></span>
                                        <input type="file" class="form-control bg-dark border-0 text-light py-3 @error('avatar') is-invalid @enderror" name="avatar" accept="image/*">
                                    </div>
                                    @if($teacher->avatar)
                                        <div class="mt-2 small text-info"><i class="bi bi-info-circle me-1"></i> Mevcut bir profil fotoğrafı tanımlı.</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 my-3">
                                <div class="d-flex align-items-center gap-3">
                                    <hr class="flex-grow-1 opacity-10">
                                    <span class="text-muted small fw-bold text-uppercase">Güvenlik Ayarları</span>
                                    <hr class="flex-grow-1 opacity-10">
                                </div>
                            </div>

                            <!-- Şifre Kolonu -->
                            <div class="col-md-6">
                                <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Yeni Şifre (İsteğe Bağlı)</label>
                                <div class="input-group">
                                        <span class="input-group-text border-0 text-warning px-3" style="background:rgba(255,255,255,0.05);"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control bg-dark border-0 text-light py-3 @error('password') is-invalid @enderror" name="password" placeholder="Değiştirmek istemiyorsanız boş bırakın">
                                </div>
                                @error('password') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Şifre Onayı</label>
                                <div class="input-group">
                                        <span class="input-group-text border-0 text-warning px-3" style="background:rgba(255,255,255,0.05);"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control bg-dark border-0 text-light py-3" name="password_confirmation" placeholder="Yeni şifreyi onaylayın">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 border-top border-light border-opacity-10">
                            <a href="{{ route('teachers.index') }}" class="btn btn-dark px-4 py-3 rounded-3 border-0" style="background: rgba(255,255,255,0.05);">
                                <i class="bi bi-arrow-left me-2"></i> İptal ve Geri Dön
                            </a>
                            <button type="submit" class="btn btn-warning px-5 py-3 rounded-3 shadow-lg fw-bold border-0 text-dark">
                                <i class="bi bi-save2-fill me-2"></i> Bilgileri Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
