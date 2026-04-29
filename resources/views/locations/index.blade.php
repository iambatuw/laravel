@extends('layouts.app')

@section('title', 'Nöbet Noktaları | Nöbet Kontrol')
@section('page-title', 'Nöbet Yerleşke Yönetimi')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill"></i><span>{{ session('success') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i><span>{{ session('error') }}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4 align-items-center">
        <div class="col-md-4">
            <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1 text-primary"></i>Nöbet tutulan tüm alanları buradan organize edebilirsiniz.</p>
        </div>
        <div class="col-md-8 text-md-end mt-3 mt-md-0 d-flex flex-wrap justify-content-md-end gap-2">
            <button type="button" class="btn btn-outline-success border-0 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#locImportModal">
                <i class="bi bi-cloud-upload-fill"></i> Toplu Ekle
            </button>
            <button type="button" class="btn btn-outline-danger border-0 d-flex align-items-center gap-2" id="locBulkDeleteBtn" style="display:none;" onclick="submitLocBulkDelete()">
                <i class="bi bi-trash3-fill"></i> Seçilenleri Sil (<span id="locSelectedCount">0</span>)
            </button>
            <a href="{{ route('locations.trashed') }}" class="btn btn-outline-danger border-0 d-flex align-items-center gap-2">
                <i class="bi bi-trash-fill"></i> Arşiv
            </a>
            <a href="{{ route('locations.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow">
                 <i class="bi bi-plus-square-fill"></i> Yeni Nokta Ekle
            </a>
        </div>
    </div>

    <form id="locBulkDeleteForm" action="{{ route('locations.bulk-delete') }}" method="POST">
        @csrf
        <div class="row g-4">
            @if($locations->count() > 0)
                @foreach($locations as $location)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-lg" style="background: rgba(30, 41, 59, 0.4) !important; border: 1px solid rgba(255,255,255,0.05) !important; transition: transform 0.3s ease;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" class="form-check-input loc-check" name="ids[]" value="{{ $location->id }}">
                                        @php
                                            $iconBg = $location->is_active ? 'var(--primary-gradient)' : 'rgba(255,255,255,0.05)';
                                            $iconCls = $location->is_active ? 'text-white' : 'text-muted';
                                        @endphp
                                        <div class="p-3 rounded-4" style="background: {{ $iconBg }}; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
                                            <i class="bi bi-geo-alt-fill fs-4 {{ $iconCls }}"></i>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-dark border-0 p-2 rounded-3" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('locations.edit', $location) }}"><i class="bi bi-pencil-square me-2 text-warning"></i> Düzenle</a></li>
                                            <li><a class="dropdown-item" href="{{ route('locations.show', $location) }}"><i class="bi bi-eye me-2 text-info"></i> Detay</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form id="del-loc-{{ $location->id }}" action="{{ route('locations.destroy', $location) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('del-loc-{{ $location->id }}', '{{ $location->name }}')">
                                                        <i class="bi bi-trash3 me-2"></i> Sil
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <h5 class="fw-bold text-white mb-1">{{ $location->name }}</h5>
                                <div class="text-primary small fw-bold mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-layers"></i> {{ $location->floor ?? 'Belirtilmedi' }}
                                </div>
                                
                                @if($location->description)
                                    <p class="text-muted small mb-4" style="font-size: 12px; height: 36px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        {{ $location->description }}
                                    </p>
                                @else
                                    <div class="mb-4 opacity-0" style="height: 36px;"></div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light border-opacity-10">
                                    <div class="text-center">
                                        <div class="fw-bold text-white" style="font-size: 14px;">{{ $location->capacity }}</div>
                                        <div class="text-muted extra-small" style="font-size: 9px; text-transform: uppercase;">Kapasite</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-bold text-white" style="font-size: 14px;">{{ $location->duty_assignments_count }}</div>
                                        <div class="text-muted extra-small" style="font-size: 9px; text-transform: uppercase;">Toplam Atama</div>
                                    </div>
                                    <span class="badge {{ $location->is_active ? 'bg-success' : 'bg-secondary' }} px-2 py-1" style="font-size: 9px;">
                                        {{ $location->is_active ? 'AKTİF' : 'PASİF' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 d-flex justify-content-center mt-4">
                    {{ $locations->links() }}
                </div>
            @else
                <div class="col-12 text-center py-5">
                    <div class="opacity-10 mb-3"><i class="bi bi-geo-fill fs-1" style="font-size: 80px !important;"></i></div>
                    <h5 class="text-muted">Tanımlanmış nöbet yeri bulunamadı.</h5>
                    <p class="small text-muted">Yeni ekleyin veya toplu ekle ile CSV/Excel dosyası yükleyin.</p>
                    <a href="{{ route('locations.create') }}" class="btn btn-primary mt-3 px-5">İlk Konumu Ekle</a>
                </div>
            @endif
        </div>
    </form>

    {{-- Toplu Ekleme Modal --}}
    <div class="modal fade" id="locImportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark border border-light border-opacity-10">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-cloud-upload-fill text-success me-2"></i>CSV / Excel ile Toplu Nöbet Yeri Ekleme</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('locations.csv-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-white-50">Dosya Seçin (.csv, .xlsx, .xls)</label>
                            <input type="file" class="form-control" name="csv_file" accept=".csv,.txt,.xlsx,.xls" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            <i class="bi bi-cloud-upload me-1"></i>Nöbet Yerlerini İçe Aktar
                        </button>
                    </form>

                    <hr class="border-light border-opacity-10 my-4">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-dark bg-opacity-50 rounded-3 h-100">
                                <div class="small fw-bold text-white mb-2"><i class="bi bi-table text-info me-1"></i>Dosya Formatı</div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless mb-0" style="font-size: 11px;">
                                        <thead><tr class="text-info"><th>ad</th><th>kat</th><th>aciklama</th></tr></thead>
                                        <tbody class="text-white-50">
                                            <tr><td>Kantin Önü</td><td>Giriş Kat</td><td>Ana giriş</td></tr>
                                            <tr><td>Öğretmenler Odası</td><td>3. Kat</td><td>İdari bölge</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-muted mt-2" style="font-size: 10px;">
                                    Opsiyonel sütunlar: <code>kat</code>, <code>aciklama</code>, <code>kapasite</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-dark bg-opacity-50 rounded-3 h-100">
                                <div class="small fw-bold text-white mb-2"><i class="bi bi-robot text-warning me-1"></i>Yapay Zeka Prompt Şablonu</div>
                                <div class="p-2 bg-black bg-opacity-50 rounded-2" style="font-size: 10.5px;">
                                    <code class="text-warning d-block" style="white-space: pre-wrap;">Bana bir CSV dosyası oluştur. Sütun başlıkları:
ad,kat,aciklama,kapasite

Aşağıdaki nöbet yerlerini ekle:
- Kantin Önü, Giriş Kat, Ana giriş kapısı, 2
- Öğretmenler Odası, 3. Kat, İdari bölge, 1
- Bahçe, Dış Alan, Okul bahçesi, 3

UTF-8 formatında kaydet.</code>
                                </div>
                                <div class="text-muted mt-2" style="font-size: 10px;">
                                    Bu prompt'u ChatGPT, Gemini veya Copilot'a yapıştırın.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const locChecks = document.querySelectorAll('.loc-check');
    const locBulkBtn = document.getElementById('locBulkDeleteBtn');
    const locCountSpan = document.getElementById('locSelectedCount');

    function updateLocBulk() {
        const checked = document.querySelectorAll('.loc-check:checked').length;
        locCountSpan.textContent = checked;
        locBulkBtn.style.display = checked > 0 ? '' : 'none';
    }
    locChecks.forEach(c => c.addEventListener('change', updateLocBulk));

    function submitLocBulkDelete() {
        const count = document.querySelectorAll('.loc-check:checked').length;
        if (count === 0) return;
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Emin misiniz?',
                text: count + ' nöbet yeri silinecek!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Evet, Sil',
                cancelButtonText: 'İptal'
            }).then((r) => { if (r.isConfirmed) document.getElementById('locBulkDeleteForm').submit(); });
        } else if (confirm(count + ' nöbet yeri silinecek. Emin misiniz?')) {
            document.getElementById('locBulkDeleteForm').submit();
        }
    }
</script>
@endpush
