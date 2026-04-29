@extends('layouts.app')

@section('title', 'Öğretmen Listesi | Nöbet Kontrol')
@section('page-title', 'Kayıtlı Öğretmenler')

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
        <div class="col-md-4 text-center text-md-start">
            <p class="text-white-50 mb-0 small"><i class="bi bi-info-circle me-1"></i>Sistemdeki tüm öğretmenleri buradan yönetebilirsiniz.</p>
        </div>
        <div class="col-md-8 text-center text-md-end mt-3 mt-md-0 d-flex flex-wrap justify-content-center justify-content-md-end gap-2">
            <button type="button" class="btn btn-outline-success border-0 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-cloud-upload-fill"></i> Toplu Ekle
            </button>
            <button type="button" class="btn btn-outline-danger border-0 d-flex align-items-center gap-2" id="bulkDeleteBtn" style="display:none;" onclick="submitBulkDelete()">
                <i class="bi bi-trash3-fill"></i> Seçilenleri Sil (<span id="selectedCount">0</span>)
            </button>
            <a href="{{ route('teachers.trashed') }}" class="btn btn-outline-danger border-0 d-flex align-items-center gap-2">
                <i class="bi bi-archive-fill"></i> Arşiv
            </a>
            <a href="{{ route('teachers.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow">
                 <i class="bi bi-person-plus-fill"></i> Yeni Ekle
            </a>
        </div>
    </div>

    <form id="bulkDeleteForm" action="{{ route('teachers.bulk-delete') }}" method="POST">
        @csrf
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                @if($teachers->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle text-white mb-0">
                            <thead class="bg-dark bg-opacity-25">
                                <tr>
                                    <th class="ps-4" style="width:40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                    <th class="text-white-50 small text-uppercase fw-bold letter-spacing-1">Öğretmen Bilgisi</th>
                                    <th class="text-white-50 small text-uppercase fw-bold letter-spacing-1">İletişim / E-posta</th>
                                    <th class="text-white-50 small text-uppercase fw-bold letter-spacing-1">Uzmanlık / Branş</th>
                                    <th class="text-center text-white-50 small text-uppercase fw-bold letter-spacing-1">Görev Yükü</th>
                                    <th class="text-end pe-5 text-white-50 small text-uppercase fw-bold letter-spacing-1">Yönetim</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td class="ps-4"><input type="checkbox" class="form-check-input row-check" name="ids[]" value="{{ $teacher->id }}"></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 py-2">
                                                <div class="user-avatar" style="width:40px;height:40px;font-size:15px;border-radius:12px; flex-shrink:0;">
                                                    {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-white">{{ $teacher->name }}</div>
                                                    <div class="text-white-50" style="font-size: 11px;">#ID: {{ $teacher->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-white small fw-medium">{{ $teacher->email }}</div>
                                            @if($teacher->phone)
                                                <div class="text-white-50 extra-small mt-1" style="font-size: 11px;"><i class="bi bi-phone me-2 opacity-50"></i>{{ $teacher->phone }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-dark border border-secondary text-white-50 px-3 py-1 rounded-pill" style="font-size: 10px;">{{ $teacher->branch }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="fw-black text-primary fs-5">{{ $teacher->duty_assignments_count }}</div>
                                            <div class="text-white-50" style="font-size: 9px; text-transform: uppercase; font-weight: 800;">Toplam Atama</div>
                                        </td>
                                        <td class="text-end pe-5">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-dark border-0 p-2 shadow-sm rounded-3" title="Görüntüle">
                                                    <i class="bi bi-person-lines-fill text-info"></i>
                                                </a>
                                                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-dark border-0 p-2 shadow-sm rounded-3" title="Düzenle">
                                                    <i class="bi bi-pencil-square text-warning"></i>
                                                </a>
                                                <form id="del-t-{{ $teacher->id }}" action="{{ route('teachers.destroy', $teacher) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-dark border-0 p-2 shadow-sm rounded-3" onclick="confirmDelete('del-t-{{ $teacher->id }}', '{{ $teacher->name }}')" title="Sil">
                                                        <i class="bi bi-trash3-fill text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 bg-dark bg-opacity-10 d-flex justify-content-center">
                        {{ $teachers->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="opacity-10 mb-3"><i class="bi bi-people-fill fs-1" style="font-size: 80px !important;"></i></div>
                        <h5 class="text-white-50">Kayıtlı öğretmen bulunamadı.</h5>
                        <p class="small text-white-50">Sistemi kullanmaya başlamak için yeni öğretmen ekleyin veya toplu ekle butonunu kullanın.</p>
                        <a href="{{ route('teachers.create') }}" class="btn btn-primary mt-3 px-5 py-2">Yeni Ekle</a>
                    </div>
                @endif
            </div>
        </div>
    </form>

    {{-- Toplu Ekleme Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark border border-light border-opacity-10">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-cloud-upload-fill text-success me-2"></i>CSV / Excel ile Toplu Öğretmen Ekleme</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('teachers.csv-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-white-50">Dosya Seçin (.csv, .xlsx, .xls)</label>
                            <input type="file" class="form-control" name="csv_file" accept=".csv,.txt,.xlsx,.xls" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            <i class="bi bi-cloud-upload me-1"></i>Öğretmenleri İçe Aktar
                        </button>
                    </form>

                    <hr class="border-light border-opacity-10 my-4">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-dark bg-opacity-50 rounded-3 h-100">
                                <div class="small fw-bold text-white mb-2"><i class="bi bi-table text-info me-1"></i>Dosya Formatı</div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless mb-0" style="font-size: 11px;">
                                        <thead><tr class="text-info"><th>ad_soyad</th><th>eposta</th><th>brans</th></tr></thead>
                                        <tbody class="text-white-50">
                                            <tr><td>Fatma Demir</td><td>fatma@okul.com</td><td>Matematik</td></tr>
                                            <tr><td>Ali Aksoy</td><td>ali@okul.com</td><td>Türkçe</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-muted mt-2" style="font-size: 10px;">
                                    Opsiyonel sütunlar: <code>telefon</code>, <code>sifre</code>, <code>rol</code><br>
                                    Varsayılan şifre: password | Varsayılan rol: öğretmen
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-dark bg-opacity-50 rounded-3 h-100">
                                <div class="small fw-bold text-white mb-2"><i class="bi bi-robot text-warning me-1"></i>Yapay Zeka Prompt Şablonu</div>
                                <div class="p-2 bg-black bg-opacity-50 rounded-2" style="font-size: 10.5px;">
                                    <code class="text-warning d-block" style="white-space: pre-wrap;">Bana bir CSV dosyası oluştur. Sütun başlıkları şu şekilde olsun:
ad_soyad,eposta,brans,telefon

Aşağıdaki öğretmenleri ekle:
- Fatma Demir, Matematik, fatma@okul.com
- Ali Aksoy, Türkçe, ali@okul.com

Dosyayı UTF-8 formatında kaydet.</code>
                                </div>
                                <div class="text-muted mt-2" style="font-size: 10px;">
                                    Bu prompt'u ChatGPT, Gemini veya Copilot'a yapıştırın. Oluşan dosyayı direkt yükleyin.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .letter-spacing-1 { letter-spacing: 1px; }
    .fw-black { font-weight: 800; }
</style>
@endpush

@push('scripts')
<script>
    const selectAll = document.getElementById('selectAll');
    const rowChecks = document.querySelectorAll('.row-check');
    const bulkBtn = document.getElementById('bulkDeleteBtn');
    const countSpan = document.getElementById('selectedCount');

    function updateBulkBtn() {
        const checked = document.querySelectorAll('.row-check:checked').length;
        countSpan.textContent = checked;
        bulkBtn.style.display = checked > 0 ? '' : 'none';
    }

    selectAll?.addEventListener('change', function() {
        rowChecks.forEach(c => c.checked = this.checked);
        updateBulkBtn();
    });
    rowChecks.forEach(c => c.addEventListener('change', updateBulkBtn));

    function submitBulkDelete() {
        const count = document.querySelectorAll('.row-check:checked').length;
        if (count === 0) return;
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Emin misiniz?',
                text: count + ' öğretmen silinecek!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Evet, Sil',
                cancelButtonText: 'İptal'
            }).then((r) => { if (r.isConfirmed) document.getElementById('bulkDeleteForm').submit(); });
        } else if (confirm(count + ' öğretmen silinecek. Emin misiniz?')) {
            document.getElementById('bulkDeleteForm').submit();
        }
    }
</script>
@endpush
