@extends('layouts.app')

@section('title', 'Yeni Öğretmen Ekle | Nöbet Kontrol')
@section('page-title', 'Öğretmen Kayıt')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-transparent border-light border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold text-white">
                        <i class="bi bi-person-plus-fill me-2 text-primary"></i>
                        Yeni Öğretmen Profil Tanımlama
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Öğretmen Adı Soyadı <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Ad Soyad girin" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">E-posta Adresi <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="eposta@adresiniz.com" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Uzmanlık Branşı <span class="text-danger">*</span></label>
                                <select class="form-select @error('branch') is-invalid @enderror" name="branch" required>
                                    <option value="">Bir branş seçin...</option>
                                    @foreach(['Matematik', 'Türkçe', 'Fizik', 'Kimya', 'Biyoloji', 'Tarih', 'Coğrafya', 'İngilizce', 'Almanca', 'Müzik', 'Beden Eğitimi', 'Görsel Sanatlar', 'Bilişim Teknolojileri', 'Din Kültürü', 'Felsefe', 'Edebiyat'] as $branch)
                                        <option value="{{ $branch }}" {{ old('branch') === $branch ? 'selected' : '' }}>{{ $branch }}</option>
                                    @endforeach
                                </select>
                                @error('branch') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">İletişim Numarası</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="05XX XXX XX XX">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Sistem Yetkisi <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                                    <option value="teacher" {{ old('role', 'teacher') === 'teacher' ? 'selected' : '' }}>Öğretmen (Sınırlı Erişim)</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Yönetici (Tam Erişim)</option>
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Profil Fotoğrafı</label>
                                <input type="file" class="form-control" name="avatar" accept="image/*">
                            </div>

                            <div class="col-md-12">
                                <hr class="opacity-10 my-4">
                                <h6 class="text-primary fw-bold mb-3"><i class="bi bi-key-fill me-2"></i>Erişim Parolası</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Parola Belirleyin <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Parolayı Doğrulayın <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5 pt-4 border-top border-light border-opacity-10">
                            <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary px-4 border-0 text-muted">
                                <i class="bi bi-x-circle me-1"></i> İptal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow">
                                <i class="bi bi-person-check-fill me-1"></i> Kaydı Tamamla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
