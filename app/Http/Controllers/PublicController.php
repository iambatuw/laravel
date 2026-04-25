<?php

namespace App\Http\Controllers;

use App\Models\DutySchedule;
use Carbon\Carbon;

class PublicController extends Controller
{
    public function board()
    {
        Carbon::setLocale('tr');

        $today = Carbon::today();

        $schedule = DutySchedule::with(['assignments.teacher', 'assignments.location'])
            ->where('date', $today)
            ->first();

        return view('public.board', compact('schedule', 'today'));
    }
}
