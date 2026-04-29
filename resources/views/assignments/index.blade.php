@extends('layouts.app')

@section('title', 'Nöbet Atamaları | Nöbet Kontrol')
@section('page-title', 'Nöbet Atamaları')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-light border-opacity-10 py-3 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-list-check me-2 text-primary"></i>Tüm Atamalar</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1">{{ $assignments->total() }} Kayıt</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Öğretmen</th>
                                    <th>Nöbet Yeri</th>
                                    <th>Periyot</th>
                                    <th>Saat</th>
                                    <th>Çizelge</th>
                                    <th class="text-center">Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignments as $a)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="user-avatar" style="width:32px;height:32px;font-size:12px;border-radius:8px;">
                                                    {{ strtoupper(substr($a->teacher->name ?? 'X', 0, 1)) }}
                                                </div>
                                                <span class="fw-bold text-white small">{{ $a->teacher->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1" style="font-size: 11px;">
                                                <i class="bi bi-geo-alt-fill me-1"></i>{{ $a->location->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-white small fw-bold">{{ $a->period_label }}</td>
                                        <td class="text-muted small">{{ $a->start_time }} - {{ $a->end_time }}</td>
                                        <td>
                                            @if($a->dutySchedule)
                                                <a href="{{ route('schedules.show', $a->dutySchedule) }}" class="text-info small fw-bold text-decoration-none">
                                                    {{ $a->dutySchedule->date->format('d.m.Y') }}
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $sc = match($a->status) {
                                                    'completed' => 'bg-success',
                                                    'absent' => 'bg-danger',
                                                    'swapped' => 'bg-info',
                                                    default => 'bg-warning text-dark'
                                                };
                                            @endphp
                                            <span class="badge {{ $sc }} shadow-sm" style="font-size: 10px;">{{ $a->status_label }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">Henüz nöbet ataması yapılmamış.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($assignments->hasPages())
                        <div class="p-3 border-top border-light border-opacity-10">
                            {{ $assignments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- CSV ile Atama İçe Aktar --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-light border-opacity-10 py-3">
                    <h6 class="mb-0 fw-bold text-white"><i class="bi bi-upload me-2 text-success"></i>CSV / Excel ile Toplu Atama</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('assignments.csv-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-white-50">Çizelge Seçimi</label>
                            <select name="duty_schedule_id" class="form-select" required>
                                <option value="">Seçiniz...</option>
                                @foreach($schedules as $s)
                                    <option value="{{ $s->id }}">{{ $s->date->format('d.m.Y') }} — {{ $s->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-white-50">CSV / Excel Dosyası</label>
                            <input type="file" class="form-control" name="csv_file" accept=".csv,.txt,.xlsx,.xls" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            <i class="bi bi-cloud-upload me-1"></i>İçe Aktar
                        </button>
                    </form>

                    <div class="mt-3 p-3 bg-dark bg-opacity-25 rounded-3">
                        <div class="small fw-bold text-white mb-2"><i class="bi bi-info-circle text-info me-1"></i>Dosya Formatı (CSV veya Excel)</div>
                        <code class="small d-block text-info" style="font-size: 11px;">
                            ogretmen | nobet_yeri | periyot<br>
                            Fatma Demir | 1. Kat Koridor | sabah<br>
                            Ali Aksoy | Kantin Önü | ogle
                        </code>
                        <div class="text-muted small mt-2" style="font-size: 10px;">
                            Desteklenen: .csv, .xlsx, .xls<br>
                            Periyot: sabah, ogle, ikindi<br>
                            Opsiyonel: baslangic, bitis sütunları (ör: 13:30, 16:20)
                        </div>
                    </div>
                </div>
            </div>

            {{-- CSV ile Nöbet Yeri İçe Aktar --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-light border-opacity-10 py-3">
                    <h6 class="mb-0 fw-bold text-white"><i class="bi bi-geo-alt-fill me-2 text-warning"></i>CSV / Excel ile Toplu Nöbet Yeri</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('locations.csv-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-white-50">CSV / Excel Dosyası</label>
                            <input type="file" class="form-control" name="csv_file" accept=".csv,.txt,.xlsx,.xls" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold text-dark">
                            <i class="bi bi-cloud-upload me-1"></i>Nöbet Yerlerini Ekle
                        </button>
                    </form>

                    <div class="mt-3 p-3 bg-dark bg-opacity-25 rounded-3">
                        <div class="small fw-bold text-white mb-2"><i class="bi bi-info-circle text-info me-1"></i>Dosya Formatı (CSV veya Excel)</div>
                        <code class="small d-block text-info" style="font-size: 11px;">
                            ad | kat | aciklama<br>
                            Kantin Önü | Giriş Kat | Ana giriş<br>
                            Öğretmenler Odası | 3. Kat | İdari bölge
                        </code>
                        <div class="text-muted small mt-2" style="font-size: 10px;">
                            Desteklenen: .csv, .xlsx, .xls<br>
                            Opsiyonel sütunlar: kat, aciklama, kapasite
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
