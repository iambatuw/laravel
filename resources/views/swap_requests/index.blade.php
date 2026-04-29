@extends('layouts.app')

@section('title', 'Takas Başvuruları | Nöbet Kontrol')
@section('page-title', 'Nöbet Değişim Talepleri')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1 text-primary"></i>Öğretmenler arası nöbet değişim taleplerini buradan takip edip onaylayabilirsiniz.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end">
            @if(auth()->user()->isTeacher())
                <a href="{{ route('swap-requests.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow">
                     <i class="bi bi-plus-circle-fill"></i> Yeni Takas Talebi
                </a>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($swapRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle text-light mb-0">
                        <thead class="bg-dark bg-opacity-25">
                            <tr>
                                <th class="ps-4">Talep Sahibi</th>
                                <th>Hedef Öğretmen</th>
                                <th>Görev Bilgisi</th>
                                <th>Tarih</th>
                                <th class="text-center">Durum</th>
                                @if(auth()->user()->isAdmin())
                                    <th class="text-end pe-4">Onay / Red</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($swapRequests as $swap)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px; flex-shrink:0;">
                                                {{ strtoupper(substr($swap->requester->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-light">{{ $swap->requester->name }}</div>
                                                <div class="text-muted" style="font-size: 11px;">{{ $swap->requester->branch }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-light small">{{ $swap->target->name }}</div>
                                        <div class="text-muted" style="font-size: 10px;">{{ $swap->target->branch }}</div>
                                    </td>
                                    <td>
                                        <div class="text-primary small fw-bold">
                                            <i class="bi bi-geo-alt me-1"></i> {{ $swap->dutyAssignment->location->name ?? 'Belirlenmedi' }}
                                        </div>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $swap->dutyAssignment->dutySchedule->date->format('d.m.Y') ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $sCls = $swap->status === 'approved' ? 'bg-success' : ($swap->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger');
                                        @endphp
                                        <span class="badge {{ $sCls }} px-3 py-1 rounded-pill" style="font-size: 10px;">
                                            {{ $swap->status_label }}
                                        </span>
                                    </td>
                                    @if(auth()->user()->isAdmin())
                                        <td class="text-end pe-4">
                                            @if($swap->isPending())
                                                <div class="btn-group gap-1">
                                                    <form action="{{ route('swap-requests.approve', $swap) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-dark border-0 p-2" title="Onayla">
                                                            <i class="bi bi-check-circle-fill text-success"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('swap-requests.reject', $swap) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-dark border-0 p-2" title="Reddet">
                                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <small class="text-muted opacity-50" style="font-size: 10px;">
                                                    {{ $swap->responded_at ? $swap->responded_at->format('d.m.Y') : 'İşlem Gördü' }}
                                                </small>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-dark bg-opacity-25 d-flex justify-content-center">
                    {{ $swapRequests->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="opacity-10 mb-3"><i class="bi bi-arrow-left-right fs-1" style="font-size: 80px !important;"></i></div>
                    <h5 class="text-muted">Aktif takas talebi bulunamadı.</h5>
                    @if(auth()->user()->isTeacher())
                        <a href="{{ route('swap-requests.create') }}" class="btn btn-primary mt-3 px-5">Talep Oluştur</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
