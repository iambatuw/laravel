@extends('layouts.app')

@section('title', ($schedule->title ?? $schedule->date->format('d.m.Y') . ' Nöbet Çizelgesi'))
@section('page-title')
    <span class="text-white-50 fw-light">Çizelge Detayı:</span> {{ $schedule->date->format('d.m.Y') }}
@endsection

@section('content')
    <!-- Üst Kontrol Paneli -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-4 text-primary">
                        <i class="bi bi-calendar2-week-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-white">{{ $schedule->title ?? $schedule->date->format('d.m.Y') . ' Nöbet Çizelgesi' }}</h4>
                        <div class="d-flex flex-wrap gap-3 align-items-center mt-1">
                            <span class="badge bg-dark border border-secondary text-white px-3 py-1" style="font-size: 11px;">
                                <i class="bi bi-calendar me-2"></i> {{ $schedule->date->format('d.m.Y') }}
                            </span>
                            <span class="badge bg-dark border border-secondary text-white px-3 py-1" style="font-size: 11px;">
                                <i class="bi bi-person me-2"></i> {{ $schedule->creator->name ?? 'Sistem' }}
                            </span>
                            @php
                                $stCls = $schedule->status === 'published' ? 'bg-success' : ($schedule->status === 'draft' ? 'bg-warning text-dark' : 'bg-info');
                            @endphp
                            <span class="badge {{ $stCls }} px-3 py-1" style="font-size: 11px;">
                                {{ $schedule->status === 'draft' ? 'Taslak' : ($schedule->status === 'published' ? 'Yayında' : 'Tamamlandı') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('schedules.print', $schedule) }}" target="_blank" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-lg border-0">
                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF Olarak İndir
                    </a>
                    
                    @if($schedule->isDraft())
                        <form action="{{ route('schedules.publish', $schedule) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success d-flex align-items-center gap-2 px-4 border-0">
                                <i class="bi bi-send-check"></i> Yayına Al
                            </button>
                        </form>
                    @endif
                    
                    <div class="dropdown">
                        <button class="btn btn-dark border-secondary px-3" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-white"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('schedules.edit', $schedule) }}"><i class="bi bi-pencil me-2 text-warning"></i>Düzenle</a></li>
                            <li><a class="dropdown-item" href="{{ route('public.board') }}" target="_blank"><i class="bi bi-display me-2 text-info"></i>TV Görünümü</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form id="del-schedule-{{ $schedule->id }}" action="{{ route('schedules.destroy', $schedule) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('del-schedule-{{ $schedule->id }}', '{{ $schedule->date->format('d.m.Y') }} Çizelgesi')">
                                        <i class="bi bi-trash3 me-2"></i>Çizelgeyi Sil
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            @if($schedule->notes)
                <div class="mt-4 p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                    <small class="text-white-50 d-block mb-1 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1px;">Notlar:</small>
                    <div class="text-white small">{{ $schedule->notes }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- Nöbet Programı İçeriği (PDF'e aktarılacak alan) -->
        <div class="col-lg-8" id="scheduleTableArea">
            <div class="pdf-export-header d-none">
                <h2 style="color: black; margin-bottom: 20px;">{{ $schedule->title ?? 'Nöbet Çizelgesi' }}</h2>
                <p style="color: black;">Tarih: {{ $schedule->date->format('d.m.Y') }} | Gün: {{ $schedule->day_of_week }}</p>
                <hr>
            </div>

            @foreach(['morning' => 'Sabah Periyodu (08:00 - 11:30)', 'noon' => 'Öğle Arası (11:30 - 13:30)', 'afternoon' => 'İkindi / Çıkış (13:30 - 17:20)'] as $period => $label)
                <div class="card mb-4 border-0 bg-dark overflow-hidden shadow-sm" style="background: rgba(15, 23, 42, 0.4) !important; border: 1px solid rgba(255,255,255,0.05) !important;">
                    <div class="card-header border-bottom border-light border-opacity-10 py-3 px-4 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-bold text-white">
                            @if($period === 'morning') <i class="bi bi-brightness-alt-high text-warning me-2"></i>
                            @elseif($period === 'noon') <i class="bi bi-sun-fill text-info me-2"></i>
                            @else <i class="bi bi-moon-stars text-primary me-2"></i>
                            @endif
                            {{ $label }}
                        </h6>
                        <span class="text-white-50 small">{{ ($groupedAssignments[$period] ?? collect())->count() }} Görevli</span>
                    </div>
                    <div class="card-body p-0">
                        @if(isset($groupedAssignments[$period]) && $groupedAssignments[$period]->count() > 0)
                            <div class="table-responsive">
                                <table class="table align-middle text-white mb-0">
                                    <thead class="bg-dark bg-opacity-50">
                                        <tr>
                                            <th class="ps-4 text-white-50">Öğretmen</th>
                                            <th class="text-white-50">Nöbet Yeri</th>
                                            <th class="text-white-50">Saat Aralığı</th>
                                            <th class="text-end pe-4 text-white-50">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($groupedAssignments[$period] as $assignment)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="user-avatar" style="width:32px;height:32px;font-size:12px;border-radius:10px;">
                                                            {{ strtoupper(substr($assignment->teacher->name, 0, 1)) }}
                                                        </div>
                                                        <div class="fw-medium text-white">{{ $assignment->teacher->name }}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge border border-secondary text-primary px-3 py-1" style="font-size: 11px;">
                                                        <i class="bi bi-geo-alt me-2"></i> {{ $assignment->location->name }}
                                                    </span>
                                                </td>
                                                <td class="text-white-50 small">
                                                    @if($assignment->start_time && $assignment->end_time)
                                                        {{ \Carbon\Carbon::parse($assignment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($assignment->end_time)->format('H:i') }}
                                                    @else
                                                        Program Dahilinde
                                                    @endif
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <form id="del-{{ $assignment->id }}" action="{{ route('assignments.destroy', $assignment) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-dark border-0 p-2" onclick="confirmDelete('del-{{ $assignment->id }}', 'Görev kaydı')">
                                                                <i class="bi bi-trash3 text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-4 text-center text-white-50 small">
                                <i class="bi bi-dash-circle me-2"></i> Bu periyot için henüz atama yapılmadı.
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Atama Formu Bölümü -->
        <div class="col-lg-4">
            <div class="card border-0 bg-primary bg-opacity-10 shadow-lg overflow-hidden" style="border: 1px dashed rgba(79, 70, 229, 0.3) !important; position: sticky; top: 100px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center gap-3">
                    <div class="p-2 rounded bg-primary text-white shadow-sm">
                        <i class="bi bi-lightning-fill"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-white">Hızlı Atama Ekle</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('assignments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="duty_schedule_id" value="{{ $schedule->id }}">
                        
                        <div class="mb-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase">Öğretmen Seçimi</label>
                            <select class="form-select border-0 bg-dark text-white py-3 shadow-sm" name="user_id" required>
                                <option value="">Bir öğretmen seçin...</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase">Nöbet Konumu</label>
                            <select class="form-select border-0 bg-dark text-white py-3 shadow-sm" name="location_id" required>
                                <option value="">Bir konum belirleyin...</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }} ({{ $location->floor }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase">Zaman Periyodu</label>
                            <select class="form-select border-0 bg-dark text-white py-3 shadow-sm" id="pd-select" name="period" required>
                                <option value="morning">Sabah (08:00 - 11:30)</option>
                                <option value="noon">Öğle (11:30 - 13:30)</option>
                                <option value="afternoon">İkindi / Çıkış (13:30 - 17:20)</option>
                                <option value="custom">Manuel / Özel</option>
                            </select>
                        </div>

                        <div class="row g-2 mb-5">
                            <div class="col-6">
                                <label class="form-label text-white-50 small fw-bold text-uppercase">Başlangıç</label>
                                <input type="time" class="form-control border-0 bg-dark text-white py-3 shadow-sm" id="st-time" name="start_time" value="08:00">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-white-50 small fw-bold text-uppercase">Bitiş</label>
                                <input type="time" class="form-control border-0 bg-dark text-white py-3 shadow-sm" id="en-time" name="end_time" value="11:30">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 shadow border-0 fw-bold">
                            Listeye Ekle <i class="bi bi-plus-lg ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pdSelect = document.getElementById('pd-select');
        const stInput = document.getElementById('st-time');
        const enInput = document.getElementById('en-time');

        pdSelect.addEventListener('change', function() {
            if (this.value === 'morning') { stInput.value = '08:00'; enInput.value = '11:30'; }
            else if (this.value === 'noon') { stInput.value = '11:30'; enInput.value = '13:30'; }
            else if (this.value === 'afternoon') { stInput.value = '13:30'; enInput.value = '17:20'; }
        });

        // PDF Export Logic
        document.getElementById('exportPdfBtn').addEventListener('click', function() {
            const element = document.getElementById('scheduleTableArea');
            const opt = {
                margin: 1,
                filename: 'nobet-cizelgesi-{{ $schedule->date->format('d-m-Y') }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Temporarily style for white background for PDF readability
            const darkCards = element.querySelectorAll('.card');
            darkCards.forEach(c => {
                c.style.backgroundColor = 'white';
                c.style.color = 'black';
                c.style.border = '1px solid #eee';
            });
            const textLights = element.querySelectorAll('.text-white, .text-white, .fw-medium, .fw-bold, h6, h5');
            textLights.forEach(t => t.style.color = 'black');
            
            html2pdf().set(opt).from(element).save().then(() => {
                // Restore styles
                darkCards.forEach(c => c.removeAttribute('style'));
                textLights.forEach(t => t.removeAttribute('style'));
            });
        });
    });
</script>
<style>
    /* Table styling helpers */
    .table thead th { border-top: 0; background: rgba(255,255,255,0.02); color: rgba(255,255,255,0.5); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
    .table td { border-bottom: 1px solid rgba(255,255,255,0.05); }
    .transition-hover:hover { transform: translateY(-2px); transition: all 0.3s ease; }
</style>
@endpush
