@extends('layouts.app')

@section('title', $teacher->name . ' - Öğretmen Detayı')
@section('page-title', 'Öğretmen Detayı')

@section('content')
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-body py-4">
                    <div class="user-avatar mx-auto mb-3" style="width:80px;height:80px;font-size:28px;border-radius:16px;">
                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                    </div>
                    <h4 class="fw-bold mb-1 text-white">{{ $teacher->name }}</h4>
                    <span class="badge border border-primary border-opacity-25 text-primary px-3 py-2 mb-3" style="background: rgba(79, 70, 229, 0.1);">
                        {{ $teacher->branch }}
                    </span>

                    <div class="text-start mt-3 px-2">
                        <div class="d-flex justify-content-between py-2 border-bottom border-white border-opacity-10">
                            <span class="text-white-50 small text-uppercase fw-bold" style="letter-spacing: 0.5px;"><i class="bi bi-envelope me-2 text-primary"></i>E-posta</span>
                            <span class="text-white fw-bold small">{{ $teacher->email }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom border-white border-opacity-10">
                            <span class="text-white-50 small text-uppercase fw-bold" style="letter-spacing: 0.5px;"><i class="bi bi-phone me-2 text-primary"></i>Telefon</span>
                            <span class="text-white fw-bold small">{{ $teacher->phone ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom border-white border-opacity-10">
                            <span class="text-white-50 small text-uppercase fw-bold" style="letter-spacing: 0.5px;"><i class="bi bi-person-badge me-2 text-primary"></i>Rol</span>
                            <span class="text-white fw-bold small">{{ $teacher->isAdmin() ? 'Yönetici' : 'Öğretmen' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-white-50 small text-uppercase fw-bold" style="letter-spacing: 0.5px;"><i class="bi bi-calendar-plus me-2 text-primary"></i>Kayıt</span>
                            <span class="text-white fw-bold small">{{ $teacher->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4 justify-content-center">
                        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow border-0" style="border-radius: 12px;">
                            <i class="bi bi-pencil-square"></i> Düzenle
                        </a>
                        <a href="{{ route('assignments.teacher_history', $teacher) }}" class="btn btn-dark d-flex align-items-center gap-2 px-4 border-0" style="border-radius: 12px; background: rgba(255,255,255,0.05);">
                            <i class="bi bi-clock-history"></i> Geçmiş
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Son Nöbet Atamaları</h5>
                </div>
                <div class="card-body p-0">
                    @if($recentDuties->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Gün</th>
                                        <th>Nöbet Yeri</th>
                                        <th>Zaman</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentDuties as $duty)
                                        <tr>
                                            <td class="fw-semibold">{{ $duty->dutySchedule->date->format('d.m.Y') }}</td>
                                            <td>{{ $duty->dutySchedule->day_of_week }}</td>
                                            <td><i class="bi bi-geo-alt text-primary me-1"></i>{{ $duty->location->name }}</td>
                                            <td><span class="badge-status badge-{{ $duty->period }}">{{ $duty->period_label }}</span></td>
                                            <td><span class="badge-status badge-{{ $duty->status }}">{{ $duty->status_label }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center p-3">
                            {{ $recentDuties->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-calendar-x d-block"></i>
                            <h5>Henüz nöbet ataması yok</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
