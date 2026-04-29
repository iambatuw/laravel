@extends('layouts.app')

@section('title', 'Çizelge Düzenle')
@section('page-title', 'Çizelge Düzenle')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i>{{ $schedule->date->format('d.m.Y') }} Çizelgesini Düzenle</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('schedules.update', $schedule) }}" method="POST" id="scheduleEditForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tarih</label>
                                <input type="text" class="form-control" value="{{ $schedule->date->format('d.m.Y') }} - {{ $schedule->day_of_week }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="status">Durum <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="draft" {{ old('status', $schedule->status) === 'draft' ? 'selected' : '' }}>Taslak</option>
                                    <option value="published" {{ old('status', $schedule->status) === 'published' ? 'selected' : '' }}>Yayında</option>
                                    <option value="completed" {{ old('status', $schedule->status) === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="title">Başlık</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $schedule->title) }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="notes">Notlar</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $schedule->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-outline-secondary" style="border-radius: 8px;">
                                <i class="bi bi-arrow-left me-1"></i>Geri
                            </a>
                            <button type="submit" class="btn btn-primary-gradient" id="btnUpdateSchedule">
                                <i class="bi bi-check-lg me-1"></i>Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
