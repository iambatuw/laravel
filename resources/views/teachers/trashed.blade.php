@extends('layouts.app')

@section('title', 'Silinen Öğretmenler')
@section('page-title', 'Silinen Öğretmenler')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <p class="text-muted mb-0">Silinen öğretmenler burada listelenir. Geri yükleyebilirsiniz.</p>
        <a href="{{ route('teachers.index') }}" class="btn btn-outline-primary" style="border-radius: 8px;">
            <i class="bi bi-arrow-left me-1"></i>Öğretmenlere Dön
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($teachers->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Öğretmen</th>
                                <th>E-posta</th>
                                <th>Branş</th>
                                <th>Silinme Tarihi</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td class="fw-semibold text-white">{{ $teacher->name }}</td>
                                    <td class="text-white-50">{{ $teacher->email }}</td>
                                    <td class="text-white-50">{{ $teacher->branch }}</td>
                                    <td class="text-white-50">{{ $teacher->deleted_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('teachers.restore', $teacher->id) }}" method="POST" class="d-inline">
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
                    {{ $teachers->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-trash3 d-block"></i>
                    <h5>Silinen öğretmen bulunmuyor</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
