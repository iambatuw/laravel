@extends('layouts.app')

@section('title', 'Öğretmen Listesi | Nöbet Kontrol')
@section('page-title', 'Kayıtlı Öğretmenler')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 text-center text-md-start">
            <p class="text-white-50 mb-0 small"><i class="bi bi-info-circle me-1"></i>Sistemdeki tüm öğretmenleri buradan yönetebilirsiniz.</p>
        </div>
        <div class="col-md-6 text-center text-md-end mt-3 mt-md-0 d-flex justify-content-center justify-content-md-end gap-2">
            <a href="{{ route('teachers.trashed') }}" class="btn btn-outline-danger border-0 d-flex align-items-center gap-2">
                <i class="bi bi-archive-fill"></i> Arşiv / Silinenler
            </a>
            <a href="{{ route('teachers.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow">
                 <i class="bi bi-person-plus-fill"></i> Yeni Öğretmen Ekle
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            @if($teachers->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle text-white mb-0">
                        <thead class="bg-dark bg-opacity-25">
                            <tr>
                                <th class="ps-5 text-white-50 small text-uppercase fw-bold letter-spacing-1">Öğretmen Bilgisi</th>
                                <th class="text-white-50 small text-uppercase fw-bold letter-spacing-1">İletişim / E-posta</th>
                                <th class="text-white-50 small text-uppercase fw-bold letter-spacing-1">Uzmanlık / Branş</th>
                                <th class="text-center text-white-50 small text-uppercase fw-bold letter-spacing-1">Görev Yükü</th>
                                <th class="text-end pe-5 text-white-50 small text-uppercase fw-bold letter-spacing-1">Yönetim</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td class="ps-5">
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
                    <p class="small text-white-50">Sistemi kullanmaya başlamak için yeni öğretmen ekleyin.</p>
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary mt-3 px-5 py-2">Yeni Ekle</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .letter-spacing-1 { letter-spacing: 1px; }
    .fw-black { font-weight: 800; }
</style>
@endpush
