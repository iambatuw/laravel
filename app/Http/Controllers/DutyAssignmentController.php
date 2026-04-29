<?php

namespace App\Http\Controllers;

use App\Models\DutyAssignment;
use App\Models\DutySchedule;
use App\Models\User;
use Illuminate\Http\Request;

class DutyAssignmentController extends Controller
{
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

        $data = $request->all();
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
