<?php

namespace App\Http\Controllers;

use App\Models\DutyAssignment;
use App\Models\DutySchedule;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class DutyAssignmentController extends Controller
{
    public function index()
    {
        $assignments = DutyAssignment::with(['teacher', 'location', 'dutySchedule'])
            ->latest('id')
            ->paginate(20);

        $teachers = User::orderBy('name')->get();
        $locations = Location::active()->orderBy('name')->get();
        $schedules = DutySchedule::orderByDesc('date')->get();

        return view('assignments.index', compact('assignments', 'teachers', 'locations', 'schedules'));
    }

    public function csvImport(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
            'duty_schedule_id' => ['required', 'exists:duty_schedules,id'],
        ], [
            'csv_file.required' => 'CSV dosyası seçmelisiniz.',
            'csv_file.mimes' => 'Dosya CSV formatında olmalıdır.',
            'duty_schedule_id.required' => 'Çizelge seçimi zorunludur.',
        ]);

        $file = $request->file('csv_file');
        $rows = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('trim', array_shift($rows));

        $imported = 0;
        $errors = [];

        foreach ($rows as $i => $row) {
            if (count($row) < count($header)) continue;

            $data = array_combine($header, array_map('trim', $row));
            $line = $i + 2;

            $teacher = User::where('name', $data['ogretmen'] ?? '')->first();
            if (!$teacher) {
                $errors[] = "Satır {$line}: \"{$data['ogretmen']}\" adlı öğretmen bulunamadı.";
                continue;
            }

            $location = Location::where('name', $data['nobet_yeri'] ?? '')->first();
            if (!$location) {
                $errors[] = "Satır {$line}: \"{$data['nobet_yeri']}\" adlı nöbet yeri bulunamadı.";
                continue;
            }

            $period = $data['periyot'] ?? 'morning';
            $periodMap = ['sabah' => 'morning', 'ogle' => 'noon', 'ikindi' => 'afternoon'];
            $period = $periodMap[mb_strtolower($period)] ?? $period;

            $times = [
                'morning'   => ['08:00', '11:30'],
                'noon'      => ['11:30', '13:30'],
                'afternoon' => ['13:30', '17:20'],
            ];

            $startTime = $data['baslangic'] ?? ($times[$period][0] ?? '08:00');
            $endTime = $data['bitis'] ?? ($times[$period][1] ?? '11:30');

            DutyAssignment::create([
                'duty_schedule_id' => $request->duty_schedule_id,
                'user_id' => $teacher->id,
                'location_id' => $location->id,
                'period' => $period,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
            $imported++;
        }

        $msg = "{$imported} atama başarıyla içe aktarıldı.";
        if (!empty($errors)) {
            $msg .= ' ' . count($errors) . ' satırda hata oluştu: ' . implode(' | ', array_slice($errors, 0, 5));
        }

        return redirect()->route('assignments.index')->with($imported > 0 ? 'success' : 'error', $msg);
    }

    public function store(Request $request)
    {
        $rules = [
            'duty_schedule_id' => ['nullable', 'exists:duty_schedules,id'],
            'date' => ['nullable', 'date'], // Global atama için tarih desteği
            'user_id' => ['required', 'exists:users,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'period' => ['required', 'string'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];

        $request->validate($rules, [
            'user_id.required' => 'Öğretmen seçimi zorunludur.',
            'location_id.required' => 'Nöbet yeri seçimi zorunludur.',
            'period.required' => 'Nöbet zamanı seçimi zorunludur.',
            'end_time.after' => 'Bitiş saati başlangıç saatinden sonra olmalıdır.',
            'date.required_without' => 'Çizelge veya tarih seçimi zorunludur.',
        ]);

        $scheduleId = $request->duty_schedule_id;

        // Eğer ID yoksa tarihe göre çizelge bul veya oluştur
        if (! $scheduleId && $request->date) {
            $schedule = DutySchedule::firstOrCreate(
                ['date' => $request->date],
                [
                    'title' => \Carbon\Carbon::parse($request->date)->format('d.m.Y').' Hızlı Planlama',
                    'status' => 'published', // Hızlı atananları direkt yayına alalım
                    'creator_id' => auth()->id(),
                ]
            );
            $scheduleId = $schedule->id;
        }

        if (! $scheduleId) {
            return back()->with('error', 'Lütfen bir çizelge veya tarih seçin.');
        }

        // Aynı öğretmen, aynı çizelge, aynı periyotta atanmış mı kontrol et
        $exists = DutyAssignment::where('duty_schedule_id', $scheduleId)
            ->where('user_id', $request->user_id)
            ->where('period', $request->period)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Bu öğretmen bu zaman diliminde zaten görevlendirilmiş.');
        }

        $data = $request->only(['user_id', 'location_id', 'period', 'start_time', 'end_time', 'status', 'notes']);
        $data['duty_schedule_id'] = $scheduleId;

        DutyAssignment::create($data);

        return redirect()
            ->route('schedules.show', $scheduleId)
            ->with('success', 'Nöbet ataması başarıyla yapıldı.');
    }

    public function update(Request $request, DutyAssignment $assignment)
    {
        $request->validate([
            'status' => ['required', 'in:assigned,completed,absent,swapped'],
        ]);

        $assignment->update(['status' => $request->status]);

        return redirect()
            ->route('schedules.show', $assignment->duty_schedule_id)
            ->with('success', 'Nöbet durumu güncellendi.');
    }

    public function destroy(DutyAssignment $assignment)
    {
        $scheduleId = $assignment->duty_schedule_id;
        $assignment->delete();

        return redirect()
            ->route('schedules.show', $scheduleId)
            ->with('success', 'Nöbet ataması başarıyla silindi.');
    }

    // Öğretmenin nöbet geçmişi
    public function teacherHistory(User $teacher)
    {
        $assignments = DutyAssignment::with(['dutySchedule', 'location'])
            ->where('user_id', $teacher->id)
            ->whereHas('dutySchedule', function ($q) {
                $q->orderBy('date', 'desc');
            })
            ->paginate(15);

        return view('assignments.teacher_history', compact('teacher', 'assignments'));
    }
}
