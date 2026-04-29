<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LocationController extends Controller
{
    public function csvImport(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:2048'],
        ], [
            'csv_file.required' => 'Dosya seçmelisiniz.',
            'csv_file.mimes' => 'Dosya CSV veya Excel (xlsx/xls) formatında olmalıdır.',
        ]);

        $file = $request->file('csv_file');
        $ext = strtolower($file->getClientOriginalExtension());

        if (in_array($ext, ['xlsx', 'xls'])) {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
            $header = array_map('trim', array_shift($sheetData));
            $rows = $sheetData;
        } else {
            $rows = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_map('trim', array_shift($rows));
        }

        $imported = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            if (count($row) < count($header)) continue;

            $data = array_combine($header, array_map('trim', $row));
            $name = $data['ad'] ?? $data['name'] ?? '';

            if (empty($name)) continue;

            if (Location::where('name', $name)->exists()) {
                $skipped++;
                continue;
            }

            Location::create([
                'name' => $name,
                'floor' => $data['kat'] ?? $data['floor'] ?? null,
                'description' => $data['aciklama'] ?? $data['description'] ?? null,
                'capacity' => $data['kapasite'] ?? $data['capacity'] ?? null,
                'is_active' => true,
            ]);
            $imported++;
        }

        $msg = "{$imported} nöbet yeri başarıyla eklendi.";
        if ($skipped > 0) $msg .= " {$skipped} adet zaten mevcut olduğu için atlandı.";

        return redirect()->route('locations.index')->with($imported > 0 ? 'success' : 'error', $msg);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['exists:locations,id']]);
        Location::whereIn('id', $request->ids)->delete();
        return redirect()->route('locations.index')->with('success', count($request->ids) . ' nöbet yeri başarıyla silindi.');
    }

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
