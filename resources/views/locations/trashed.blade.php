@extends('layouts.app')

@section('title', 'Silinen Nöbet Yerleri')
@section('page-title', 'Silinen Nöbet Yerleri')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <p class="text-muted mb-0">Silinen nöbet yerleri burada listelenir.</p>
        <a href="{{ route('locations.index') }}" class="btn btn-outline-primary" style="border-radius: 8px;">
            <i class="bi bi-arrow-left me-1"></i>Nöbet Yerlerine Dön
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($locations->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Yer Adı</th>
                                <th>Kat</th>
                                <th>Silinme Tarihi</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td class="fw-semibold">{{ $location->name }}</td>
                                    <td>{{ $location->floor ?? '-' }}</td>
                                    <td style="color: #999;">{{ $location->deleted_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('locations.restore', $location->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-primary-gradient">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Geri Yükle
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p-3">
                    {{ $locations->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-trash3 d-block"></i>
                    <h5>Silinen nöbet yeri bulunmuyor</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
