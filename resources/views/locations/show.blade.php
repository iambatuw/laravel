@extends('layouts.app')

@section('title', $location->name . ' - Nöbet Yeri')
@section('page-title', $location->name)

@section('content')
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center py-4">
                    <div style="width:64px;height:64px;border-radius:14px;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff;margin:0 auto 16px;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $location->name }}</h4>
                    <p class="text-muted mb-3">{{ $location->floor ?? 'Kat belirtilmemiş' }}</p>

                    @if($location->description)
                        <p style="font-size: 13px; color: #777;">{{ $location->description }}</p>
                    @endif

                    <div class="d-flex justify-content-around mt-3 pt-3 border-top">
                        <div>
                            <div class="fw-bold text-primary" style="font-size: 20px;">{{ $location->capacity }}</div>
                            <div class="text-muted" style="font-size: 12px;">Kapasite</div>
                        </div>
                        <div>
                            <div class="fw-bold text-success" style="font-size: 20px;">{{ $recentAssignments->total() }}</div>
                            <div class="text-muted" style="font-size: 12px;">Toplam Atama</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Nöbet Geçmişi</h5>
                </div>
                <div class="card-body p-0">
                    @if($recentAssignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Öğretmen</th>
                                        <th>Zaman</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAssignments as $assignment)
                                        <tr>
                                            <td class="fw-semibold">{{ $assignment->dutySchedule->date->format('d.m.Y') }}</td>
                                            <td>{{ $assignment->teacher->name }}</td>
                                            <td><span class="badge-status badge-{{ $assignment->period }}">{{ $assignment->period_label }}</span></td>
                                            <td><span class="badge-status badge-{{ $assignment->status }}">{{ $assignment->status_label }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center p-3">
                            {{ $recentAssignments->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-calendar-x d-block"></i>
                            <h5>Bu lokasyon için nöbet kaydı yok</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
