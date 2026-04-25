<?php

namespace App\Http\Controllers;

use App\Models\DutyAssignment;
use App\Models\DutySchedule;
use App\Models\Location;
use App\Models\SwapRequest;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Bugünkü çizelge
        $todaySchedule = DutySchedule::with(['assignments.teacher', 'assignments.location'])
            ->where('date', today())
            ->first();

        if ($user->isAdmin()) {
            // Admin istatistikleri
            $stats = [
                'totalTeachers' => User::where('role', 'teacher')->count(),
                'totalLocations' => Location::active()->count(),
                'todayAssignments' => $todaySchedule ? $todaySchedule->assignments()->count() : 0,
                'pendingSwaps' => SwapRequest::pending()->count(),
                'totalSchedules' => DutySchedule::count(),
                'completedToday' => $todaySchedule
                    ? $todaySchedule->assignments()->where('status', 'completed')->count()
                    : 0,
            ];

            // Son 7 günün çizelgeleri
            $recentSchedules = DutySchedule::with('creator')
                ->orderBy('date', 'desc')
                ->limit(7)
                ->get();

            $teachers = User::where('role', 'teacher')->orderBy('name')->get();
            $locations = Location::active()->orderBy('name')->get();

            return view('dashboard.admin', compact('stats', 'todaySchedule', 'recentSchedules', 'teachers', 'locations'));
        }

        // Öğretmen paneli
        $myTodayDuties = $todaySchedule
            ? DutyAssignment::with('location')
                ->where('duty_schedule_id', $todaySchedule->id)
                ->where('user_id', $user->id)
                ->get()
            : collect();

        $upcomingDuties = DutyAssignment::with(['dutySchedule', 'location'])
            ->where('user_id', $user->id)
            ->whereHas('dutySchedule', function ($q) {
                $q->where('date', '>=', today());
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $mySwapRequests = SwapRequest::with(['target', 'dutyAssignment.location'])
            ->where('requester_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.teacher', compact('myTodayDuties', 'upcomingDuties', 'mySwapRequests', 'todaySchedule'));
    }
}
