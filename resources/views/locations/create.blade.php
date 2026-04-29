@extends('layouts.app')

@section('title', 'Yeni Nöbet Yeri Ekle')
@section('page-title', 'Yeni Nöbet Yeri Ekle')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Nöbet Yeri Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('locations.store') }}" method="POST" id="locationForm">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Yer Adı <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Örn: Ana Bahçe" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="floor">Kat</label>
                                <select class="form-select @error('floor') is-invalid @enderror" id="floor" name="floor">
                                    <option value="">Kat Seçin</option>
                                    @foreach(['Bodrum Kat', 'Zemin Kat', '1. Kat', '2. Kat', '3. Kat', '4. Kat', '5. Kat'] as $floor)
                                        <option value="{{ $floor }}" {{ old('floor') === $floor ? 'selected' : '' }}>{{ $floor }}</option>
                                    @endforeach
                                </select>
                                @error('floor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="description">Açıklama</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Nöbet yeri hakkında kısa bilgi...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="capacity">Kapasite <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity', 1) }}" min="1" max="10" required>
                                <small class="text-muted">Aynı anda kaç öğretmen nöbet tutabilir?</small>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="is_active">Durum</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Pasif</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">
                                <i class="bi bi-arrow-left me-1"></i>Geri
                            </a>
                            <button type="submit" class="btn btn-primary-gradient" id="btnSaveLocation">
                                <i class="bi bi-check-lg me-1"></i>Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
