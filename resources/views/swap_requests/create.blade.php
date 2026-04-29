@extends('layouts.app')

@section('title', 'Yeni Takas Talebi')
@section('page-title', 'Yeni Takas Talebi Oluştur')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Takas Talebi Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('swap-requests.store') }}" method="POST" id="swapForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="duty_assignment_id">Takas Etmek İstediğiniz Nöbet <span class="text-danger">*</span></label>
                            <select class="form-select @error('duty_assignment_id') is-invalid @enderror" id="duty_assignment_id" name="duty_assignment_id" required>
                                <option value="">Nöbet Seçin</option>
                                @foreach($myAssignments as $assignment)
                                    <option value="{{ $assignment->id }}" {{ old('duty_assignment_id') == $assignment->id ? 'selected' : '' }}>
                                        {{ $assignment->dutySchedule->date->format('d.m.Y') }} - {{ $assignment->location->name }} ({{ $assignment->period_label }})
                                    </option>
                                @endforeach
                            </select>
                            @error('duty_assignment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="target_id">Takas Etmek İstediğiniz Öğretmen <span class="text-danger">*</span></label>
                            <select class="form-select @error('target_id') is-invalid @enderror" id="target_id" name="target_id" required>
                                <option value="">Öğretmen Seçin</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('target_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }} ({{ $teacher->branch }})
                                    </option>
                                @endforeach
                            </select>
                            @error('target_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="reason">Sebep</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3" placeholder="Takas sebebinizi belirtin...">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning" style="border-radius: 10px; border: none;">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Takas talebi yönetici onayına gönderilecektir.
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('swap-requests.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">
                                <i class="bi bi-arrow-left me-1"></i>Geri
                            </a>
                            <button type="submit" class="btn btn-primary-gradient" id="btnSendSwap">
                                <i class="bi bi-send me-1"></i>Talebi Gönder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
