@extends('layouts.app')

@section('title', 'Nöbet Noktaları | Nöbet Kontrol')
@section('page-title', 'Nöbet Yerleşke Yönetimi')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1 text-primary"></i>Okul içerisindeki nöbet tutulan tüm alanları buradan organize edebilirsiniz.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
            <a href="{{ route('locations.trashed') }}" class="btn btn-outline-danger border-0 d-flex align-items-center gap-2">
                <i class="bi bi-trash-fill"></i> Arşiv
            </a>
            <a href="{{ route('locations.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow">
                 <i class="bi bi-plus-square-fill"></i> Yeni Nokta Ekle
            </a>
        </div>
    </div>

    <div class="row g-4">
        @if($locations->count() > 0)
            @foreach($locations as $location)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-lg" style="background: rgba(30, 41, 59, 0.4) !important; border: 1px solid rgba(255,255,255,0.05) !important; transition: transform 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                @php
                                    $iconBg = $location->is_active ? 'var(--primary-gradient)' : 'rgba(255,255,255,0.05)';
                                    $iconCls = $location->is_active ? 'text-white' : 'text-muted';
                                @endphp
                                <div class="p-3 rounded-4" style="background: {{ $iconBg }}; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
                                    <i class="bi bi-geo-alt-fill fs-4 {{ $iconCls }}"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-dark border-0 p-2 rounded-3" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end bg-dark border-secondary">
                                        <li><a class="dropdown-item text-white" href="{{ route('locations.edit', $location) }}"><i class="bi bi-pencil-square me-2 text-warning"></i> Düzenle</a></li>
                                        <li><a class="dropdown-item text-white" href="{{ route('locations.show', $location) }}"><i class="bi bi-eye me-2 text-info"></i> Detay</a></li>
                                        <li><hr class="dropdown-divider opacity-10"></li>
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

                            <h5 class="fw-bold text-light mb-1">{{ $location->name }}</h5>
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
                                    <div class="fw-bold text-light" style="font-size: 14px;">{{ $location->capacity }}</div>
                                    <div class="text-muted extra-small" style="font-size: 9px; text-transform: uppercase;">Kapasite</div>
                                </div>
                                <div class="text-center">
                                    <div class="fw-bold text-light" style="font-size: 14px;">{{ $location->duty_assignments_count }}</div>
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
                <a href="{{ route('locations.create') }}" class="btn btn-primary mt-3 px-5">İlk Konumu Ekle</a>
            </div>
        @endif
    </div>
@endsection
