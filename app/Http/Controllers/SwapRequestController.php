<?php

namespace App\Http\Controllers;

use App\Models\DutyAssignment;
use App\Models\SwapRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SwapRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $swapRequests = SwapRequest::with(['requester', 'target', 'dutyAssignment.location', 'dutyAssignment.dutySchedule'])
                ->latest()
                ->paginate(10);
        } else {
            $swapRequests = SwapRequest::with(['requester', 'target', 'dutyAssignment.location', 'dutyAssignment.dutySchedule'])
                ->where('requester_id', $user->id)
                ->orWhere('target_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('swap_requests.index', compact('swapRequests'));
    }

    public function create()
    {
        $user = auth()->user();

        // Öğretmenin gelecekteki nöbet atamaları
        $myAssignments = DutyAssignment::with(['dutySchedule', 'location'])
            ->where('user_id', $user->id)
            ->whereHas('dutySchedule', function ($q) {
                $q->where('date', '>=', today());
            })
            ->get();

        $teachers = User::where('role', 'teacher')
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();

        return view('swap_requests.create', compact('myAssignments', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'duty_assignment_id' => ['required', 'exists:duty_assignments,id'],
            'target_id' => ['required', 'exists:users,id'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ], [
            'duty_assignment_id.required' => 'Takas edilecek nöbet seçimi zorunludur.',
            'target_id.required' => 'Hedef öğretmen seçimi zorunludur.',
        ]);

        // Kendi nöbeti mi kontrol et
        $assignment = DutyAssignment::findOrFail($request->duty_assignment_id);
        if ($assignment->user_id !== auth()->id()) {
            return back()->with('error', 'Sadece kendi nöbetinizi takas edebilirsiniz.');
        }

        SwapRequest::create([
            'requester_id' => auth()->id(),
            'target_id' => $request->target_id,
            'duty_assignment_id' => $request->duty_assignment_id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('swap-requests.index')
            ->with('success', 'Takas talebi başarıyla gönderildi.');
    }

    // Admin onay/red
    public function approve(SwapRequest $swapRequest)
    {
        $swapRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'responded_at' => now(),
        ]);

        // Nöbet atamasını güncelle
        $assignment = $swapRequest->dutyAssignment;
        $assignment->update([
            'user_id' => $swapRequest->target_id,
            'status' => 'swapped',
        ]);

        return redirect()
            ->route('swap-requests.index')
            ->with('success', 'Takas talebi onaylandı.');
    }

    public function reject(SwapRequest $swapRequest)
    {
        $swapRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'responded_at' => now(),
        ]);

        return redirect()
            ->route('swap-requests.index')
            ->with('success', 'Takas talebi reddedildi.');
    }
}
