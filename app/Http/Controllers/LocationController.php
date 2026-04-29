<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('dutyAssignments')
            ->latest()
            ->paginate(10);

        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(StoreLocationRequest $request)
    {
        Location::create($request->validated());

        return redirect()
            ->route('locations.index')
            ->with('success', 'Nöbet yeri başarıyla oluşturuldu.');
    }

    public function show(Location $location)
    {
        $location->load(['dutyAssignments.teacher', 'dutyAssignments.dutySchedule']);

        $recentAssignments = $location->dutyAssignments()
            ->with(['teacher', 'dutySchedule'])
            ->whereHas('dutySchedule', function ($q) {
                $q->orderBy('date', 'desc');
            })
            ->paginate(10);

        return view('locations.show', compact('location', 'recentAssignments'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(UpdateLocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        return redirect()
            ->route('locations.index')
            ->with('success', 'Nöbet yeri başarıyla güncellendi.');
    }

    public function destroy(Location $location)
    {
        $location->delete(); // Soft delete

        return redirect()
            ->route('locations.index')
            ->with('success', 'Nöbet yeri başarıyla silindi.');
    }

    // Silinen nöbet yerlerini gör (Soft Delete)
    public function trashed()
    {
        $locations = Location::onlyTrashed()->paginate(10);

        return view('locations.trashed', compact('locations'));
    }

    // Silinen nöbet yerini geri getir
    public function restore($id)
    {
        $location = Location::onlyTrashed()->findOrFail($id);
        $location->restore();

        return redirect()
            ->route('locations.trashed')
            ->with('success', 'Nöbet yeri başarıyla geri yüklendi.');
    }
}
