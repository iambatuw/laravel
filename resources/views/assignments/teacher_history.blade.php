@extends('layouts.app')

@section('title', 'Nöbet Geçmişi - ' . $teacher->name)
@section('page-title', $teacher->name . ' - Nöbet Geçmişi')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="user-avatar" style="width:48px;height:48px;font-size:18px;border-radius:12px;">
                {{ strtoupper(substr($teacher->name, 0, 1)) }}
            </div>
            <div>
                <h5 class="mb-0 fw-bold">{{ $teacher->name }}</h5>
                <span class="text-muted" style="font-size: 13px;">{{ $teacher->branch }} - Nöbet Geçmişi</span>
            </div>
        </div>
        <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-outline-primary" style="border-radius: 8px;">
            <i class="bi bi-arrow-left me-1"></i>Öğretmen Profiline Dön
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($assignments->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Gün</th>
                                <th>Nöbet Yeri</th>
                                <th>Kat</th>
                                <th>Zaman</th>
                                <th>Saat</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignments as $assignment)
                                <tr>
                                    <td class="fw-semibold">{{ $assignment->dutySchedule->date->format('d.m.Y') }}</td>
                                    <td>{{ $assignment->dutySchedule->day_of_week }}</td>
                                    <td><i class="bi bi-geo-alt text-primary me-1"></i>{{ $assignment->location->name }}</td>
                                    <td style="color: #666;">{{ $assignment->location->floor ?? '-' }}</td>
                                    <td><span class="badge-status badge-{{ $assignment->period }}">{{ $assignment->period_label }}</span></td>
                                    <td style="font-size: 12px; color: #999;">
                                        @if($assignment->start_time && $assignment->end_time)
                                            {{ \Carbon\Carbon::parse($assignment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($assignment->end_time)->format('H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td><span class="badge-status badge-{{ $assignment->status }}">{{ $assignment->status_label }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p-3">
                    {{ $assignments->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-calendar-x d-block"></i>
                    <h5>Nöbet geçmişi bulunmuyor</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
