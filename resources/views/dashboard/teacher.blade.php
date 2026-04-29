@extends('layouts.app')

@section('title', 'Öğretmen Paneli | Nöbet Kontrol')
@section('page-title')
    <span class="text-muted fw-light">Sisteme Hoş Geldiniz,</span> {{ auth()->user()->name }}
@endsection

@section('content')
    <div class="row g-4">
        <!-- Bugünkü Görevler -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-check me-2 text-primary"></i>Bugünkü Nöbetlerim</h5>
                    @if($todaySchedule)
                        <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill border border-primary border-opacity-25" style="font-size: 11px;">
                            {{ $todaySchedule->date->format('d.m.Y') }} | {{ $todaySchedule->day_of_week }}
                        </div>
                    @endif
                </div>
                <div class="card-body p-4">
                    @if($myTodayDuties->count() > 0)
                        <div class="row g-4">
                            @foreach($myTodayDuties as $duty)
                                <div class="col-md-6">
                                    <div class="p-4 rounded-4 position-relative overflow-hidden" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); transition: all 0.3s ease;">
                                        <div class="d-flex justify-content-between align-items-start mb-4">
                                            <div class="p-3 bg-primary bg-opacity-10 rounded-3 text-primary">
                                                <i class="bi bi-geo-alt-fill fs-4"></i>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge rounded-pill bg-dark border border-secondary text-white mb-1 d-block" style="font-size: 10px;">{{ $duty->period_label }}</span>
                                                @php
                                                    $sCls = $duty->status === 'completed' ? 'text-success' : ($duty->status === 'absent' ? 'text-danger' : 'text-info');
                                                @endphp
                                                <span class="small fw-bold {{ $sCls }}" style="font-size: 11px;">
                                                    <i class="bi bi-dot"></i> {{ $duty->status_label }}
                                                </span>
                                            </div>
                                        </div>
                                        <h5 class="fw-bold text-white mb-2">{{ $duty->location->name }}</h5>
                                        <p class="text-muted small mb-3"><i class="bi bi-layers me-1"></i> {{ $duty->location->floor ?? 'Zemin Kat' }}</p>
                                        
                                        @if($duty->start_time && $duty->end_time)
                                            <div class="d-flex align-items-center gap-2 text-primary small fw-semibold">
                                                <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($duty->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($duty->end_time)->format('H:i') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px dashed rgba(255, 255, 255, 0.1);">
                            <div class="mb-3 opacity-25"><i class="bi bi-emoji-smile fs-1"></i></div>
                            <h6 class="text-muted">Harika! Bugün planlanmış bir nöbet göreviniz bulunmuyor.</h6>
                            <p class="small text-muted mb-0">Havadisleri takip etmek için panoyu kontrol edebilirsiniz.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Program Planı -->
            <div class="card mt-5">
                <div class="card-header border-0 bg-transparent pt-4 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-calendar3 me-2 text-primary"></i>Yaklaşan Görev Planı</h5>
                </div>
                <div class="card-body p-4">
                    @if($upcomingDuties->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Tarih / Gün</th>
                                        <th>Nöbet Yeri</th>
                                        <th>Periyot</th>
                                        <th>Görev Durumu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingDuties as $duty)
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-white">{{ $duty->dutySchedule->date->format('d.m.Y') }}</div>
                                                <div class="text-muted small">{{ $duty->dutySchedule->day_of_week }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-pin-angle text-primary"></i>
                                                    {{ $duty->location->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge border border-secondary text-secondary px-3 py-1" style="font-size: 11px;">{{ $duty->period_label }}</span>
                                            </td>
                                            <td>
                                                <span class="small fw-medium">{{ $duty->status_label }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 bg-dark bg-opacity-25 rounded-3">
                            <span class="text-muted small">Henüz ileriye dönük bir atama yapılmamış.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Takas ve Duyuru Paneli -->
        <div class="col-lg-4">
            <div class="card border-0 bg-dark bg-opacity-50" style="border: 1px solid rgba(255,255,255,0.05) !important;">
                <div class="card-header border-0 bg-transparent pt-4 px-4 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-arrow-repeat me-2 text-warning"></i>Takas Taleplerim</h5>
                    <a href="{{ route('swap-requests.create') }}" class="btn btn-sm btn-dark border-secondary rounded-3">
                        <i class="bi bi-plus-lg text-warning"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($mySwapRequests as $swap)
                            <div class="list-group-item bg-transparent border-bottom border-light border-opacity-10 py-3 px-4 d-flex align-items-center gap-3">
                                <div class="user-avatar" style="width:38px;height:38px;font-size:14px;border-radius:12px; flex-shrink:0;">
                                    {{ strtoupper(substr($swap->target->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-semibold text-white text-truncate" style="font-size: 14px;">{{ $swap->target->name }}</div>
                                    <div class="text-muted small text-truncate">{{ $swap->dutyAssignment->location->name }}</div>
                                </div>
                                @php
                                    $stCls = $swap->status === 'approved' ? 'bg-success' : ($swap->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger');
                                @endphp
                                <span class="badge {{ $stCls }} rounded-pill px-2 py-1" style="font-size: 9px;">{{ $swap->status_label }}</span>
                            </div>
                        @endforeach
                    </div>
                    @if($mySwapRequests->isEmpty())
                        <div class="p-5 text-center text-muted small">
                            Aktif bir takas talebiniz bulunmuyor.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Destek / Bilgi Kartı -->
            <div class="card mt-4 border-0" style="background: var(--primary-gradient);">
                <div class="card-body p-4">
                    <h6 class="text-white fw-bold mb-2">Yardıma mı ihtiyacınız var?</h6>
                    <p class="text-white text-opacity-75 small mb-3">Nöbet değişiklikleri veya sistem kullanımı hakkında bilgi almak için admin ile iletişime geçebilirsiniz.</p>
                    <a href="mailto:admin@okul.edu.tr" class="btn btn-white btn-sm bg-white text-primary border-0 fw-bold px-3">E-posta Gönder</a>
                </div>
            </div>
        </div>
    </div>
@endsection
