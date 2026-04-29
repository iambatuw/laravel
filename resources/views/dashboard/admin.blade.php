@extends('layouts.app')

@section('title', 'Kontrol Merkezi | Nöbet Kontrol')
@section('page-title', 'Sistem Yönetim Paneli')

@section('content')
    <!-- Hızlı İstatistik Kartları -->
    <!-- Hızlı İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(147, 51, 234, 0.05) 100%) !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary text-white shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-opacity-50 small fw-bold text-uppercase letter-spacing-1" style="font-size: 10px;">Öğretmen Kadrosu</div>
                        <h3 class="mb-0 fw-bold text-white">{{ $stats['totalTeachers'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%) !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success text-white shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-opacity-50 small fw-bold text-uppercase letter-spacing-1" style="font-size: 10px;">Aktif Noktalar</div>
                        <h3 class="mb-0 fw-bold text-white">{{ $stats['totalLocations'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.05) 100%) !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-warning text-white shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-opacity-50 small fw-bold text-uppercase letter-spacing-1" style="font-size: 10px;">Bugünkü Görev</div>
                        <h3 class="mb-0 fw-bold text-white">{{ $stats['todayAssignments'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(185, 28, 28, 0.05) 100%) !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-danger text-white shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <i class="bi bi-arrow-left-right fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-opacity-50 small fw-bold text-uppercase letter-spacing-1" style="font-size: 10px;">Takas Talebi</div>
                        <h3 class="mb-0 fw-bold text-white">{{ $stats['pendingSwaps'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sol Kolon: Anlık Akış -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-broadcast fs-5"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Canlı Nöbet Akışı</h6>
                    </div>
                    @if($todaySchedule)
                        <a href="{{ route('schedules.show', $todaySchedule) }}" class="btn btn-dark btn-sm rounded-3 py-1 px-3 shadow-sm border-0" style="background: rgba(255,255,255,0.05); font-size: 12px;">
                            Tüm Liste <i class="bi bi-arrow-right ms-1 text-primary"></i>
                        </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if($todaySchedule && $todaySchedule->assignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th class="ps-4 text-white-50">Öğretmen</th>
                                        <th class="text-white-50">Nöbet Alanı</th>
                                        <th class="text-center text-white-50">Periyot</th>
                                        <th class="text-center text-white-50">Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todaySchedule->assignments->take(8) as $assignment)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-box" style="width:30px;height:30px;font-size:12px;border-radius:10px;">
                                                        {{ strtoupper(substr($assignment->teacher->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-white">{{ $assignment->teacher->name }}</div>
                                                        <div class="text-white-50 small opacity-75" style="font-size: 11px;">{{ $assignment->teacher->branch }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-primary"><i class="bi bi-pin-map me-1"></i> {{ $assignment->location->name }}</div>
                                                <div class="text-white-50 small opacity-50 fw-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">
                                                    <i class="bi bi-layers me-1"></i> {{ $assignment->location->floor ?? 'ZM' }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="px-2 py-1 rounded bg-white bg-opacity-10 text-white-50 small border border-white border-opacity-10" style="font-size: 11px;">
                                                    {{ $assignment->period_label }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $statusClasses = [
                                                        'assigned' => 'bg-info',
                                                        'completed' => 'bg-success',
                                                        'absent' => 'bg-danger',
                                                        'swapped' => 'bg-warning text-dark'
                                                    ];
                                                    $cls = $statusClasses[$assignment->status] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $cls }} shadow-sm px-3 py-2" style="font-size: 10px; min-width: 90px;">
                                                    {{ $assignment->status_label }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4 opacity-10"><i class="bi bi-calendar-event" style="font-size: 80px;"></i></div>
                            <h5 class="text-white fw-bold">Henüz Bugün İçin Çizelge Yayınlanmadı</h5>
                            <p class="text-white-50 mb-4 px-5">Günlük nöbet akışını başlatmak için çizelge oluşturun veya mevcut bir taslağı yayınlayın.</p>
                            <a href="{{ route('schedules.create') }}" class="btn btn-primary px-5 py-3 rounded-3 shadow">
                                <i class="bi bi-plus-lg me-2"></i> Bugünün Çizelgesini Başlat
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Son İşlemler & Planlama Geçmişi (Yeni Görünüm) -->
            <div class="card border-0 shadow-lg">
                <div class="card-header py-3 px-4 border-0 d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 bg-info bg-opacity-10 text-info">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Planlama Geçmişi</h6>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0">
                        @foreach($recentSchedules->take(4) as $schedule)
                        <div class="col-md-6 border-bottom border-end border-light border-opacity-10">
                            <a href="{{ route('schedules.show', $schedule) }}" class="d-flex align-items-center gap-3 p-3 text-decoration-none transition-hover">
                                <div class="text-center p-2 rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); min-width: 55px;">
                                    <div class="fw-black text-white h5 mb-0">{{ $schedule->date->format('d') }}</div>
                                    <div class="text-uppercase text-primary small fw-bold" style="font-size: 9px;">{{ $schedule->date->locale('tr')->shortMonthName }}</div>
                                </div>
                                <div style="min-width: 0;">
                                    <h6 class="text-white fw-bold mb-0 small text-truncate">{{ $schedule->day_of_week }}</h6>
                                    <div class="mt-1">
                                        @php $sCls = $schedule->status === 'published' ? 'bg-success' : ($schedule->status === 'draft' ? 'bg-warning text-dark' : 'bg-info'); @endphp
                                        <span class="badge {{ $sCls }} rounded-pill px-2" style="font-size: 8px;">{{ $schedule->status_label }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Sağ Kolon: Hızlı Atama (YENİ) & Kısayollar -->
        <div class="col-lg-4">
            <!-- HIZLI ATAMA FORMU -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(165deg, rgba(79, 70, 229, 0.1) 0%, rgba(15, 23, 42, 1) 100%) !important; border: 1px solid rgba(79, 70, 229, 0.2) !important;">
                <div class="card-header py-3 px-3 border-0 d-flex align-items-center gap-2">
                    <div class="p-1 rounded bg-primary text-white shadow-sm">
                        <i class="bi bi-lightning-charge-fill small"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-white small">Hızlı Nöbet Atama</h6>
                </div>
                <div class="card-body px-3 pb-3">
                    <form action="{{ route('assignments.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Nöbet Tarihi</label>
                            <input type="date" name="date" class="form-control bg-dark border-0 text-white py-2 shadow-sm" value="{{ date('Y-m-d') }}" style="font-size: 13px;" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Öğretmen Seçimi</label>
                            <select name="user_id" class="form-select bg-dark border-0 text-white py-2 shadow-sm" style="font-size: 13px;" required>
                                <option value="">Seçiniz...</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Nöbet Noktası</label>
                            <select name="location_id" class="form-select bg-dark border-0 text-white py-2 shadow-sm" style="font-size: 13px;" required>
                                <option value="">Belirleyin...</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Nöbet Periyodu</label>
                            <select name="period" id="quickPeriod" class="form-select bg-dark border-0 text-white py-2 shadow-sm" style="font-size: 13px;" required>
                                <option value="morning">Sabah (08:00 - 11:30)</option>
                                <option value="afternoon">Öğle (11:30 - 13:30)</option>
                                <option value="evening">İkindi (13:30 - 17:20)</option>
                            </select>
                            <input type="hidden" name="start_time" id="quickStartTime" value="08:00">
                            <input type="hidden" name="end_time" id="quickEndTime" value="11:30">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 shadow-lg border-0 fw-bold small">
                            Hemen Görevlendir
                        </button>
                    </form>
                </div>
            </div>

            <!-- Hızlı Kısayollar -->
            <div class="card border-0 shadow-lg">
                <div class="card-body p-3">
                    <h6 class="text-white fw-bold mb-3 small"><i class="bi bi-grid-fill me-2 text-primary"></i>Hızlı Eriş</h6>
                    <div class="row g-2">
                        <div class="col-12">
                            <a href="{{ route('schedules.create') }}" class="btn btn-dark w-100 py-2 rounded-3 border-0 d-flex align-items-center justify-content-between px-3 transition-hover" style="background: rgba(255,255,255,0.03);">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-calendar-plus text-primary fs-6"></i>
                                    <span class="small fw-bold text-white" style="font-size: 12px;">Çizelge Tanımla</span>
                                </div>
                                <i class="bi bi-chevron-right text-white-50 small" style="font-size: 10px;"></i>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('teachers.create') }}" class="btn btn-dark w-100 py-3 rounded-3 border-0 d-flex flex-column align-items-center gap-1 transition-hover" style="background: rgba(255,255,255,0.03);">
                                <div class="bg-info bg-opacity-10 rounded-circle p-2"><i class="bi bi-person-fill-add text-info fs-6"></i></div>
                                <span class="small fw-bold text-white" style="font-size: 11px;">Öğretmen</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('locations.create') }}" class="btn btn-dark w-100 py-3 rounded-3 border-0 d-flex flex-column align-items-center gap-1 transition-hover" style="background: rgba(255,255,255,0.03);">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2"><i class="bi bi-geo-alt-fill text-warning fs-6"></i></div>
                                <span class="small fw-bold text-white" style="font-size: 11px;">Nokta Ekle</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { background: rgba(255,255,255,0.08) !important; transform: translateY(-2px); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .fw-black { font-weight: 900; }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('quickPeriod')?.addEventListener('change', function() {
        const times = {
            morning:   { start: '08:00', end: '11:30' },
            afternoon: { start: '11:30', end: '13:30' },
            evening:   { start: '13:30', end: '17:20' }
        };
        const t = times[this.value];
        if (t) {
            document.getElementById('quickStartTime').value = t.start;
            document.getElementById('quickEndTime').value = t.end;
        }
    });
</script>
@endpush
