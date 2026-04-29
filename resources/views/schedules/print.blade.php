<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $schedule->title ?? 'Nöbet Çizelgesi' }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; color: #333; }
        h1 { font-size: 24px; margin-bottom: 10px; }
        .meta { color: #666; font-size: 14px; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #f5f5f5; font-weight: bold; }
        .period-title { font-size: 18px; font-weight: bold; margin: 20px 0 10px; color: #444; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .bg-success { background: #d4edda; color: #155724; }
        .bg-warning { background: #fff3cd; color: #856404; }
        .bg-info { background: #d1ecf1; color: #0c5460; }
        .empty { color: #999; font-style: italic; padding: 20px; text-align: center; }
    </style>
</head>
<body>
    <h1>{{ $schedule->title ?? $schedule->date->format('d.m.Y') . ' Nöbet Çizelgesi' }}</h1>
    <div class="meta">
        Tarih: {{ $schedule->date->format('d.m.Y') }} | Gün: {{ $schedule->day_of_week }}<br>
        Durum: {{ $schedule->status === 'published' ? 'Yayında' : ($schedule->status === 'draft' ? 'Taslak' : 'Tamamlandı') }}
    </div>

    @php
        $periods = [
            'morning' => 'Sabah Periyodu (08:00 - 11:30)',
            'noon' => 'Öğle Arası (11:30 - 13:30)',
            'afternoon' => 'İkindi / Çıkış (13:30 - 17:20)',
            'custom' => 'Özel / Manuel'
        ];
    @endphp

    @foreach($periods as $key => $label)
        <div class="period-title">{{ $label }}</div>
        @if(isset($groupedAssignments[$key]) && $groupedAssignments[$key]->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Öğretmen</th>
                        <th>Branş</th>
                        <th>Nöbet Yeri</th>
                        <th>Saat Aralığı</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupedAssignments[$key] as $assignment)
                        <tr>
                            <td>{{ $assignment->teacher->name }}</td>
                            <td>{{ $assignment->teacher->branch }}</td>
                            <td>{{ $assignment->location->name }} ({{ $assignment->location->floor ?? 'ZM' }})</td>
                            <td>
                                @if($assignment->start_time && $assignment->end_time)
                                    {{ $assignment->start_time }} - {{ $assignment->end_time }}
                                @else
                                    Program Dahilinde
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusLabels = [
                                        'assigned' => 'Atandı',
                                        'completed' => 'Tamamlandı',
                                        'absent' => 'Gelmedi',
                                        'swapped' => 'Takas Edildi'
                                    ];
                                    $statusClass = [
                                        'assigned' => 'bg-info',
                                        'completed' => 'bg-success',
                                        'absent' => 'bg-danger',
                                        'swapped' => 'bg-warning'
                                    ];
                                @endphp
                                <span class="badge {{ $statusClass[$assignment->status] ?? '' }}">{{ $statusLabels[$assignment->status] ?? $assignment->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">Bu periyot için atama yapılmamış.</div>
        @endif
    @endforeach

    <script>
        window.onload = function() { window.print(); };
    </script>
</body>
</html>
