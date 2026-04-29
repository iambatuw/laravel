<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDutyScheduleRequest;
use App\Models\DutySchedule;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DutyScheduleController extends Controller
{
    public function index()
    {
        $schedules = DutySchedule::with('creator')
            ->withCount('assignments')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        $locations = Location::active()->orderBy('name')->get();

        return view('schedules.create', compact('teachers', 'locations'));
    }

    public function store(StoreDutyScheduleRequest $request)
    {
        $date = Carbon::parse($request->date);

        $dayNames = [
            'Monday' => 'Pazartesi',
            'Tuesday' => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday' => 'Perşembe',
            'Friday' => 'Cuma',
            'Saturday' => 'Cumartesi',
            'Sunday' => 'Pazar',
        ];

        $schedule = DutySchedule::create([
            'date' => $request->date,
            'day_of_week' => $dayNames[$date->format('l')] ?? $date->format('l'),
            'title' => $request->title ?? $date->format('d.m.Y').' Nöbet Çizelgesi',
            'notes' => $request->notes,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('schedules.show', $schedule)
            ->with('success', 'Nöbet çizelgesi başarıyla oluşturuldu. Şimdi öğretmen ataması yapabilirsiniz.');
    }

    public function show(DutySchedule $schedule)
    {
        $schedule->load(['assignments.teacher', 'assignments.location', 'creator']);

        $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        $locations = Location::active()->orderBy('name')->get();

        // Atamaları periyoda göre grupla
        $groupedAssignments = $schedule->assignments->groupBy('period');

        return view('schedules.show', compact('schedule', 'teachers', 'locations', 'groupedAssignments'));
    }

    public function edit(DutySchedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    public function update(Request $request, DutySchedule $schedule)
    {
        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:draft,published,completed'],
        ]);

        $schedule->update($request->only(['title', 'notes', 'status']));

        return redirect()
            ->route('schedules.show', $schedule)
            ->with('success', 'Nöbet çizelgesi başarıyla güncellendi.');
    }

    public function destroy(DutySchedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Nöbet çizelgesi başarıyla silindi.');
    }

    // Çizelgeyi yayınla
    public function publish(DutySchedule $schedule)
    {
        $schedule->update(['status' => 'published']);

        return redirect()
            ->route('schedules.show', $schedule)
            ->with('success', 'Nöbet çizelgesi yayınlandı.');
    }

    // Bugünün çizelgesini göster
    public function today()
    {
        $schedule = DutySchedule::with(['assignments.teacher', 'assignments.location'])
            ->where('date', today())
            ->first();

        if (! $schedule) {
            return redirect()
                ->route('schedules.index')
                ->with('info', 'Bugün için henüz bir nöbet çizelgesi oluşturulmamış.');
        }

        return redirect()->route('schedules.show', $schedule);
    }
}
